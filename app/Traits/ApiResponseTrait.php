<?php

namespace App\Traits;

use App\Enums\ResponseEnum;
use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Return a 200 OK JSON response.
     */
    protected function ok(mixed $message = null, mixed $data = null): JsonResponse
    {
        return $this->formatResponse($message, $data, ResponseEnum::HTTP_OK);
    }

    protected function error(mixed $message = null, mixed $data = null): JsonResponse
    {
        return $this->formatResponse($message, $data, ResponseEnum::HTTP_BAD_REQUEST);
    }

    protected function formatResponse(mixed $message, mixed $data, ResponseEnum $code): JsonResponse
    {
        $formattedMessage = is_object($message) ? $message : ['txt' => is_array($message) ? $message : [$message]];

        return response()->json(
            [
                'message' => $formattedMessage,
                'data' => $data,
            ],
            $code->value,
        );
    }
}
