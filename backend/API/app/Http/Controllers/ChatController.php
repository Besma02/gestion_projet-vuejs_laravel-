<?php

namespace App\Http\Controllers;

//use App\Events\MessageSent;


use Illuminate\Http\Request;

use App\Events\ChatMessageSent;

use App\Models\Message; // Pour les messages de chat


class ChatController extends Controller

{
    public function sendMessage(Request $request)
    {
         // Valider la requête
         $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Créer le message
        $message = Message::create([
            'user_id' => auth()->id(), // ou un autre mécanisme pour obtenir l'ID utilisateur
            'message' => $request->input('message'),
        ]);
        broadcast(new ChatMessageSent($message))->toOthers();
        // Retourner une réponse JSON avec le message créé
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);
        
    }

    public function getMessages()
    {
        return Message::with('user')->get();
    }
}
