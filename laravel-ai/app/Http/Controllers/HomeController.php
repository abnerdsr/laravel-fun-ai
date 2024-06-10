<?php

namespace App\Http\Controllers;

use App\Services\Chat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): mixed
    {
        $content = Markdown::parse(session('chat')?->messages()->last()['content'] ?? "");

        return view('welcome', compact('content'));
    }

    public function send(Request $request): mixed
    {
        $chat = new Chat;

        $chat->send($request->input('message'));

        session()->put('chat', $chat);

        return back();
    }

    public function clear(): mixed
    {
        session()->forget('chat');

        return back();
    }
}
