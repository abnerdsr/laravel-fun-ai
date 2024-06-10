<?php

use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TemplateBotController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('/', [HomeController::class, 'send'])->name('home.send');
Route::get('/clear', [HomeController::class, 'clear'])->name('home.clear');

Route::get('/chatbot', [ChatBotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot', [ChatBotController::class, 'send'])->name('chatbot.send');

Route::get('/docs', [DocsController::class, 'index'])->name('docs.index');
Route::post('/docs', [DocsController::class, 'send'])->name('docs.send');

Route::get('/bot', [TemplateBotController::class, 'index'])->name('bot.index');
Route::post('/bot', [TemplateBotController::class, 'send'])->name('bot.send');

// Route::get('/', function () {
//     $messages = collect([
//         [
//             "role" =>  "system",
//             "content" =>  "You are a poetic assistant, skilled in explaining complex programming concepts with creative flair."
//         ],
//         [
//             "role" =>  "user",
//             "content" =>  "Compose a poem that explains the concept of recursion in programming."
//         ]
//     ]);

//     $content = Http::withToken(config('services.openai.api_key'))
//         ->post(config('services.openai.api_url'), [
//             "model" =>  "gpt-4o",
//             "messages" => $messages->toArray()
//         ])->json('choices.0.message.content');


//     $messages->push([
//         "role" =>  "assistant",
//         "content" =>  $content
//     ]);

//     $messages->push([
//         "role" =>  "user",
//         "content" =>  "Good, but can you make it much, much more silly."
//     ]);

//     $content = Http::withToken(config('services.openai.api_key'))
//         ->post(config('services.openai.api_url'), [
//             "model" =>  "gpt-4o",
//             "messages" => $messages->toArray()
//         ])->json('choices.0.message.content');

//     $messages->push([
//         "role" =>  "assistant",
//         "content" =>  $content
//     ]);

//     return view('welcome', compact('content'));
// });
