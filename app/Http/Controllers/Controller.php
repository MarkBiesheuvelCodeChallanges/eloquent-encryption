<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Message;

class Controller extends BaseController
{
    public function index()
    {
        $data = Message::all(['from', 'to', 'content']);

        return response()->json($data);
    }

    public function raw()
    {
        $data = app('db')->select("SELECT `from`, `to`, `content` FROM messages");

        return response()->json($data);
    }
}
