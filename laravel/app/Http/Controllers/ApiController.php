<?php

namespace App\Http\Controllers;

use App\Libraries\Out;

class ApiController extends Controller
{

    public function apiStatus()
    {
        $data = array(
            'version' => 'v1.0 - snapshot',
            'status' => 'api it\'s running',
        );

        return Out::json($data, 'check api status');
    }
}
