<?php

namespace App\Http\Traits;

// 1. Trait untuk standardisasi response (Recommended)
trait ApiResponseTrait
{
    /**
     * Return success response
     */
    protected function successResponse($data = null, $message = 'Success', $status = 200)
    {
        return response()->json([
            'success' => true,
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * Return error response
     */
    protected function errorResponse($message = 'Error', $status = 400, $data = null)
    {
        return response()->json([
            'success' => false,
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * Return not found response
     */
    protected function notFoundResponse($message = 'Data not found')
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Return validation error response
     */
    protected function validationErrorResponse($errors, $message = 'Validation failed')
    {
        return response()->json([
            'success' => false,
            'status' => 422,
            'message' => $message,
            'data' => null,
            'errors' => $errors
        ], 422);
    }
}
