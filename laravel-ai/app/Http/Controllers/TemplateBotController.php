<?php

namespace App\Http\Controllers;

use App\Services\Chat;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

        $promptTemplate = File::get(storage_path('app/public/prompt-template.txt'));

        $chat
            ->system($promptTemplate)
            ->json()
            ->send(
                "Pergunta: Lembre que os ids não númericos devem ser uuids. " .
                $request->input('message') .
                "\n Resposta:"
            );

        session()->put('chat.bot', $chat);

        return back();
    }
}
