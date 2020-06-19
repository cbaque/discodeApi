<?php

function response_data($data, $status, $message, $path)
{
    return response()->json([
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s'),
        'message' => $message,
        'path' => $path,
        'status' => $status
    ], $status);
}
