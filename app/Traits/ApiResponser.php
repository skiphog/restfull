<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

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

        return $this->successResponse(
            $this->transformData($collection, $transformer),
            $code
        );
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
}
