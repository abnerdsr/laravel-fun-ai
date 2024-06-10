<?php

use App\Services\Chat;
use Illuminate\Support\Collection;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;
use OpenAI\Responses\Chat\CreateResponseUsage;

it('retorna as mensagens em formato de coleção', function () {
    $chat = new Chat();

    OpenAI::fake([
        CreateResponse::fake([
            'choices' => [
                [
                    'text' => 'ola da ia',
                ],
            ],
        ]),
    ]);

    $chat->send("ola do user");

    $result = $chat->messages();

    expect(get_class($result))->toBe(Collection::class);
    expect($result->count())->toBe(2);
});