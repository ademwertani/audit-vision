<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroqClient;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function show()
    {
        $history = session('chatbot_history', []);
        return view('chatbot', compact('history'));
    }

    public function send(Request $request, GroqClient $groq)
    {
        try {
            $data = $request->validate([
                'message' => ['required','string','max:5000'],
            ]);

            $history = session('chatbot_history', []);

            $messages = array_merge(
                [[
                    'role'    => 'system',
                    'content' => "Tu es un assistant utile et concis. Réponds en français si l'utilisateur parle français.",
                ]],
                $history,
                [[
                    'role'    => 'user',
                    'content' => $data['message'],
                ]]
            );

            $answer = $groq->chat($messages);

            $history[] = ['role' => 'user', 'content' => $data['message']];
            $history[] = ['role' => 'assistant', 'content' => $answer];
            session(['chatbot_history' => $history]);

            return response()->json([
                'ok'      => true,
                'answer'  => $answer,
                'history' => $history,
            ]);

        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json([
                'ok'    => false,
                'error' => 'Message invalide: '.collect($ve->errors())->flatten()->join(' '),
            ], 422);

        } catch (\Throwable $e) {
            Log::error('[Chatbot] send error', ['error' => $e->getMessage()]);
            return response()->json([
                'ok'    => false,
                'error' => $e->getMessage(), // ← on renvoie le vrai message
            ], 500);
        }
    }

    public function reset()
    {
        session()->forget('chatbot_history');
        return response()->json(['ok' => true]);
    }
}
