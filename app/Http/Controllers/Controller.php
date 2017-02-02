<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Message;

class Controller extends BaseController
{
    public function index()
    {
        $data = Message::query()
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return response()->json($data);
    }
}
