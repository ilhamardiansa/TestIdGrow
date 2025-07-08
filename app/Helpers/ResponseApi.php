<?php

if (!function_exists('responseSuccess')) {
    function responseSuccess($message = 'Berhasil', $data = [], $status = 200, $meta = [])
    {
        if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $meta = [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ];
            $data = $data->items();
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'meta' => $meta,
            'data' => $data,
        ], $status);
    }
}

if (!function_exists('responseError')) {
    function responseError($message = 'Terjadi kesalahan', $status = 400, $errors = [], $meta = [])
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
            'meta' => null,
        ], $status);
    }
}