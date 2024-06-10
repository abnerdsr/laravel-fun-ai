<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Chat
{
    /**
     * Dados que serão enviados a OpenAI
     */
    private array $responseData = [];

    /**
     * Instancia um objeto de Chat
     */
    public function __construct(
        private Collection $messages = new Collection(),
        private string $model = 'gpt-4o'
    ) {
        $this->responseData['model'] = $this->model;
    }

    /**
     * Adiciona a mensagem de configuração do Prompt
     * Aqui é onde inserimos nossas técnicas de Prompt Engineering
     */
    public function system(string $message): static
    {
        if ($this->messages->contains('role', 'system')) {
            return $this;
        }

        $this->messages->push([
            'role' => 'system',
            'content' => $message,
        ]);

        return $this;
    }

    /**
     * Força a resposta do conteúdo vir em formato json
     */
    public function json(): static
    {
        $this->responseData["response_format"] = [
            "type" => "json_object"
        ];

        return $this;
    }

    /**
     * Envia uma mensagem a IA e retorna a resposta
     */
    public function send(string $message): string
    {
        $this->messages->push([
            "role" =>  "user",
            "content" =>  $message,
        ]);

        $this->responseData['messages'] = $this->messages->toArray();

        $response = Http::withToken(config('services.openai.api_key'))
            ->post(
                config('services.openai.api_url'),
                $this->responseData
            )->json();

        if (empty($response['choices'][0]['message']['content'])) {
            dd('Conteúdo retornou com erro', $response);
        }

        $content = $response['choices'][0]['message']['content'];

        $this->messages->push([
            "role" =>  "assistant",
            "content" =>  $content
        ]);

        return $content;
    }

    /**
     * Retorna todas as mensagens da isntancia atual
     */
    public function messages(): Collection
    {
        return $this->messages;
    }
}
