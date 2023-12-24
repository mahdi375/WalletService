<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;

trait RespondApi
{
    protected function response(JsonResource|ResourceCollection|string|array $data, $status = Response::HTTP_OK): JsonResponse
    {
        if (is_string($data)) {
            $structuredData = ['message' => $data];

            return response()->json($structuredData, $status);
        }

        if (is_array($data)) {
            return response()->json($data, $status);
        }

        return $data->response()->setStatusCode($status);
    }

    protected function responseError(string|array $parameters, $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        if (is_string($parameters)) {
            $data = ['message' => $parameters];
        } else {
            $data = [
                'message' => $parameters['message'],
                'errors' => $parameters['errors'],
            ];
        }

        return response()->json($data, $status);
    }
}
