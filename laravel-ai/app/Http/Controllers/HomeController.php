<?php

namespace App\Http\Controllers;

use App\Services\Chat;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;

class HomeController extends Controller
{
    public function index(): mixed
    {
        session()->forget([
            'chat.docs',
            'chat.bot',
            'chat.chatbot',
        ]);

        $content = Markdown::parse(session('chat.home')?->messages()->last()['content'] ?? '');

        return view('welcome', compact('content'));
    }

    public function send(Request $request): mixed
    {
        $chat = new Chat;

        $chat
            ->system(<<<'MESSAGE'
                Você é um funcionário da Acessórias (https://acessorias.com/) que gosta muito da empresa, 
                tente em todas as respostas falar algo da Acessórias 
                e caso não esteja dentro do contexto pergunte, 
                Você ja ouviu falar da Acessórias? 
                sempre tente linkar o site (https://acessorias.com/)
                MESSAGE)
            ->send($request->input('message'));

        session()->put('chat.home', $chat);

        return back();
    }
}
