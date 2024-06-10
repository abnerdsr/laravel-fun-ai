<x-layout>
    <h2 class="mb-4 text-white">AGENTE DE SUPORTE AO SITE ACESSÓRIAS - CHAT BOT</h2>
    <div class="w-[600px]">
        <form id="sendForm" method="POST" enctype="multipart/form-data" action="{{ route('chatbot.send') }}">
            @csrf
            <textarea
                id="message"
                name="message"
                placeholder="{{ __('Pergunte a IA...') }}"
                class="p-2 bg-gray-200 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <div class="flex items-center justify-content w-full">
                <div class="w-1/2">
                <input type="submit" class="mt-4 text-white p-2 border border-gray-300 cursor-pointer rounded-lg" value="Enviar"/>
                </div>
                <div class="w-1/2 text-right">
                <input type="button" class="mt-4 text-white p-2 border border-gray-300 cursor-pointer rounded-lg" value="Resetar" onclick="resetar()" />
                </div>
            </div>
        </form>
        

        <form id="sendFormClear" method="POST" action="{{ route('chatbot.clear') }}">
            @csrf
            
        </form>
    </div>

    <script>
        function resetar() {
            const form = document.getElementById('sendFormClear');
            form.submit();
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            const form = document.getElementById('sendForm');
            const textarea = document.getElementById('message');

            textarea.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();  // Prevent default behavior of Enter key
                    form.submit();  // Submit the form
                }
            });
        });
    </script>

    <div class="w-[600px] min-h-[100px] mt-6 text-xs font-sans text-white border border-gray-300 bg-gray-700 rounded-lg p-2">
        @foreach ($content as $item)
            <x-message>
            <div @class([
                'text-md',
                'font-bold',
                'text-gray-300' => $item['role'] == 'user', 
                'text-right' => $item['role'] == 'user',
            ])>
                @if($item['role'] == 'user')
                    Usuário
                @else
                    Agente IA
                @endif
            </div>
            <div @class([
                'text-right' => $item['role'] == 'user',
                'text-gray-300' => $item['role'] == 'user', 
            ])>
                {{ \Illuminate\Mail\Markdown::parse($item['content']) }}
            </div>
        </x-message>
        @endforeach
        
    </div>
</x-layout>