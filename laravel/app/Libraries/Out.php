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

    public static function exception($ex, $message = '', $message2 = '')
    {
        $meta = ['success' => false, 'exception' => $ex, 'message' => $message];

        return response()
            ->json(['meta' => $meta, 'data' => $message2])
            ->header('success', false)
            ->header('exception', $ex)
            ->header('message', $message);
    }
}
