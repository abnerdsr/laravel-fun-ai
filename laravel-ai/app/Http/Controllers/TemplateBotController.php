<?php

namespace App\Http\Controllers;

use App\Services\Chat;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;

class TemplateBotController extends Controller
{
    public function index(): mixed
    {
        session()->forget([
            'chat.home',
            'chat.docs',
            'chat.chatbot',
        ]);

        $content = Markdown::parse(session('chat.bot')?->messages()->last()['content'] ?? "");

        return view('bot', compact('content'));
    }

    public function send(Request $request): mixed
    {
        $chat = new Chat;

        $chat
            ->send($request->input('message'));

        session()->put('chat.bot', $chat);

        return back();
    }
}
