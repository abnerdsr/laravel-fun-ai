<?php

use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TemplateBotController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('/', [HomeController::class, 'send'])->name('home.send');

Route::get('/chatbot', [ChatBotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot', [ChatBotController::class, 'send'])->name('chatbot.send');
Route::post('/chatbotclear', [ChatBotController::class, 'clear'])->name('chatbot.clear');

Route::get('/docs', [DocsController::class, 'index'])->name('docs.index');
Route::post('/docs', [DocsController::class, 'send'])->name('docs.send');

Route::get('/bot', [TemplateBotController::class, 'index'])->name('bot.index');
Route::post('/bot', [TemplateBotController::class, 'send'])->name('bot.send');
