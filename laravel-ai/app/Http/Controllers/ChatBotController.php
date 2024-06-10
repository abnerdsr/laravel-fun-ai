<?php

namespace App\Http\Controllers;

use App\Services\Chat;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function index(): mixed
    {
        if (session()->missing('chat')) {
            session()->put('chat', new Chat);
        }

        $content = session('chat')->messages()->where('role', '!=', 'system')->toArray() ?? [];

        return view('chatbot', compact('content'));
    }

    public function send(Request $request): mixed
    {
        if (session()->missing('chat')) {
            session()->put('chat', new Chat);
        }

        /** @var Chat */
        $chat = session('chat') ?? new Chat;

        $chat->send($request->input('message'));

        session()->put('chat', $chat);

        return back();
    }
}
