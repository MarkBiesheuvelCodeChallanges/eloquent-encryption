<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index()
    {
        $data = app('db')->select("SELECT 'bar' AS foo");

        return response()->json($data);
    }
}
