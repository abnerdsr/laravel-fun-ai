<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full bg-gray-800 ">
    <div class="bg-gray-600 w-full h-[80px] flex items-center text-white">

        <a class="p-2" href="{{ route('home.index') }}">Home</a>
        |<a class="p-2" href="{{ route('docs.index') }}">Docs</a>
        |<a class="p-2" href="{{ route('bot.index') }}">Template de Robos</a>
        |<a class="p-2" href="{{ route('chatbot.index') }}">Chat Bot</a>

    </div>
    <div class="grid place-items-center p-6 break-words">
        {{ $slot }}
    </div>
</body>

</html>
