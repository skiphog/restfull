<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $transformer
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function handle($request, Closure $next, $transformer)
    {
        /** @var \Illuminate\Http\JsonResponse $response */
        $response = $next($request);

        $transformerInput = [];
        foreach ($request->request->all() as $input => $value) {
            /** @var \App\Transformers\UserTransformer $transformer */
            $transformerInput[$transformer::getOriginalAttribute($input)] = $value;
        }
        $request->replace($transformerInput);

        if ($response->exception instanceof ValidationException) {
            $data = $response->getData();

            $transformedErrors = [];
            foreach ((array)$data->error as $field => $error) {
                $transformedField = $transformer::transformedAttribute($field);
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
            }
            $data->error = $transformedErrors;

            $response->setData($data);
        }

        return $response;
    }
}
