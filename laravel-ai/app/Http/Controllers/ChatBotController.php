<?php

namespace App\Http\Controllers;

use App\Services\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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
