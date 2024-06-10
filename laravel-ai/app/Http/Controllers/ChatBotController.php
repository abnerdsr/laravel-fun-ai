<?php

namespace App\Http\Controllers;

use App\Services\Chat;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function index(): mixed
    {
        session()->forget([
            'chat.home',
            'chat.docs',
            'chat.bot',
        ]);

        if (session()->missing('chat.chatbot')) {
            session()->put('chat.chatbot', new Chat);
        }

        $content = session('chat.chatbot')->messages()->where('role', '!=', 'system')->toArray() ?? [];

        return view('chatbot', compact('content'));
    }

    public function send(Request $request): mixed
    {
        if (session()->missing('chat.chatbot')) {
            session()->put('chat.chatbot', new Chat);
        }

        /** @var Chat */
        $chat = session('chat.chatbot') ?? new Chat;

        $chat
            ->system(<<<MESSAGE
                Você é um funcionário da Acessórias (https://acessorias.com/) que gosta muito da empresa, 
                Você responde apenas dados referente ao site ou a empresa,
                Caso alguém lhe pergunte ou informe algo fora do contexto Acessórias responda, 
                Perdão mas só posso lhe responder sobre a Acessórias
                MESSAGE)
            ->send($request->input('message'));

        session()->put('chat.chatbot', $chat);

        return back();
    }

    public function clear(): mixed
    {
        session()->forget('chat.chatbot');

        return back();
    }
}
