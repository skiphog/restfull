<?php

namespace App\Traits;

use Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Validator;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $transformer = $collection->first()->transformer;

        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);

        return $this->successResponse($collection, $code);
    }

    protected function paginate(Collection $collection)
    {
        Validator::validate(request()->all(), [
            'per_page' => 'integer|min:2|max:50'
        ]);

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        if (request()->has('per_page')) {
            $perPage = (int)request()->input('per_page');
        }

        $result = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function showOne(Model $model, $code = 200)
    {
        /** @var \App\User|Model $model */
        return $this->successResponse(
            $this->transformData($model, $model->transformer),
            $code
        );
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    /**
     * @param Collection $collection
     * @param $transformation \App\Transformers\UserTransformer
     * @return Collection
     */
    protected function filterData(Collection $collection, $transformation)
    {
        foreach ((array)request()->query() as $query => $value) {
            $attribute = $transformation::getOriginalAttribute($query);

            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;
    }

    /**
     * @param Collection $collection
     * @param $transformation \App\Transformers\UserTransformer
     * @return Collection
     */
    protected function sortData(Collection $collection, $transformation)
    {
        if (request()->has('sort_by')) {
            $attribute = $transformation::getOriginalAttribute(request()->input('sort_by'));
            return $collection->sortBy->{$attribute};
        }

        return $collection;
    }

    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams, SORT_STRING);

        $queryString = http_build_query($queryParams);
        $fullUrl = $url . '?' . $queryString;


        return Cache::remember($fullUrl, 30 / 60, function () use ($data) {
            return $data;
        });
    }

}
