<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageChat;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSent as EventsMessageSent;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        broadcast(new EventsMessageSent($message))->toOthers();

        return response()->json(['status' => 'Message sent successfully!']);
    }
}
