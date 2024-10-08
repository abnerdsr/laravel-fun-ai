# Instalando

## Requerimentos

Docker (https://docs.docker.com/desktop/)

### OpenAI
API Key da OpenAI (https://platform.openai.com/api-keys)

Org Key da OpenAI (https://platform.openai.com/settings/organization/general)

### Ollama
API instalada localmente (https://ollama.com)
GPU Boa
40Gb de espaço em disco

## Configurando

clone o arquivo .env
```sh
cp .env.example .env
```

adicione sua api key na variavel OPENAI_API_KEY no arquivo .env se for utilizar OPenAI
```sh
OPENAI_API_KEY=minhakey
OPENAI_ORGANIZATION=minhaorgkey
```

se for utilizar ollama altere o modelo no .env
```sh
IA_MODEL=llama3
```

se estiver utilizando ollama suba o serviço de api da IA em um terminal, 
lembrando que `llama3` pode ser substituido pela versão do modelo que estiver usando 
```sh
ollama run llama3
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
http://localhost:8000
```

## Observações

Caso não consiga acessar o projeto verifique os seguintes pontos

1. A porta 8000 do seu computador precisa estar liberada
2. O Seu navegador pode redirecionar automatico para https, então digite no próprio navegador chrome://net-internals/#hsts, adicione localhost em Domain: na sessão Delete domain security policies, depois clique no botão "delete" e tente novamente
3. Se for utilizar o llama instale ele e rode o projeto localmente sem o docker ou instale ele dentro da imagem da aplicação (https://ollama.com)
