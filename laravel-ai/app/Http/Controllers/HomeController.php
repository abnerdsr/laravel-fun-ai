<?php

namespace App\Http\Controllers;

use App\Services\Chat;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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

        if ($chat->model === 'llama3') {
            $acessorias = Cache::get('acessorias');
            if (is_null($acessorias)) {
                $acessorias = Http::get('https://acessorias.com/site')->body();
                $acessorias .= Http::get('https://acessorias.com/site/sobre-nos/')->body();
                $acessorias .= Http::get('https://acessorias.com/site/funcionalidades/')->body();

                Cache::put('acessorias', $acessorias);
            }
        } else {
            $acessorias = '(https://acessorias.com/site/ | https://acessorias.com/site/sobre-nos/ | https://acessorias.com/site/funcionalidades/ | )';
        }

        $acessorias .= " Contato: Avenida Amazonas, 91, Belo Horizonte (MG), (31) 3526-2555";

        $chat
            ->system(<<<MESSAGE
                Você é um funcionário da Acessórias ({$acessorias}) que gosta muito da empresa, 
                tente em todas as respostas falar algo da Acessórias }
                e caso não esteja dentro do contexto pergunte, 
                Você ja ouviu falar da Acessórias? 
                sempre tente linkar o site (https://acessorias.com/)
                MESSAGE)
            ->send($request->input('message'));

        session()->put('chat.home', $chat);

        return back();
    }
}
