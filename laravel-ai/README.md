# Instalando

## Requerimentos

Docker (https://docs.docker.com/desktop/)

API Key da OpenAI (https://platform.openai.com/api-keys)

## Configurando

clone o arquivo .env
```sh
cp .env.example .env
```

adicione sua api key na variavel OPENAI_API_KEY no arquivo .env
```sh
OPENAI_API_KEY=minhakey
```

suba os servidores
```sh
./vendor/bin/sail up -d
```

rode as migrations
```sh
./vendor/bin/sail artisan migrate
```

Acesse o projeto
```
http://localhost
```

## Observações

Caso não consiga acessar o projeto verifique os seguintes pontos

1. A porta 80 do seu computador precisa estar liberada
2. O Seu navegador pode redirecionar automatico para https, então digite no próprio navegador chrome://net-internals/#hsts, adicione localhost em Domain: na sessão Delete domain security policies, depois clique no botão "delete" e tente novamente