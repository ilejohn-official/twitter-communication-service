<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 
     * Send messages to subcribers
     */
    public function send(Request $request)
    {
        $channelProvider = app('channel.provider');

        $message = $request->message;
        $channelId = $request->channelId;

        $result = $channelProvider->sendMessage($message, $channelId);

        return response()->json([
            'message' => 'Message sent',
            'result' => $result
        ]);
    }
}
