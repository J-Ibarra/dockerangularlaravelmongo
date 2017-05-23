<?php

namespace App\Libraries;

class Out
{

    public static function json($data, $message = '', $success = true)
    {
        $meta = ['success' => $success, 'message' => $message];

        return response()
            ->json(['meta' => $meta, 'data' => $data])
            ->header('success', $success)
            ->header('message', $message);
    }
}
