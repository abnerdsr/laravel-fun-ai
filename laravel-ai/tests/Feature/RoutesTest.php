<?php

it('retorna status 200 para a rota da página inicial', function () {
    $response = $this->get('/');
    expect($response->status())->toBe(200);
});

it('retorna status 200 para a rota de pagina de documentos', function () {
    $response = $this->get('/docs');
    expect($response->status())->toBe(200);
});

it('retorna status 200 para a rota de pagina de chat bot', function () {
    $response = $this->get('/chatbot');
    expect($response->status())->toBe(200);
});

it('retorna status 200 para a rota de pagina de template bot', function () {
    $response = $this->get('/bot');
    expect($response->status())->toBe(200);
});