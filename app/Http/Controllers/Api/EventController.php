<?php

namespace App\Http\Controllers\Api;

use App\Events\TestEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Create websocket event.
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        $name = $request->input('name');
        $data = $request->input('data');

        broadcast(new TestEvent($name, json_decode($data, true)));
    }
}
