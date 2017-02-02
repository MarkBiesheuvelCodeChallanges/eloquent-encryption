<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index()
    {
        $data = [
            'foo' => 'bar',
        ];

        return response()->json($data);
    }
}
