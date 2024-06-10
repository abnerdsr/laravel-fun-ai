<x-layout>
    <h2 class="mb-4 text-white">ZERO SHOT COM CHAIN OF THOUGHTS - FISSURADO NA ACESSÓRIAS</h2>
    <div class="w-[600px]">
        <form id="sendForm" method="POST" action="{{ route('home.send') }}">
            @csrf
            <textarea
                id="message"
                name="message"
                placeholder="{{ __('Pergunte a IA...') }}"
                class="p-2 bg-gray-200 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <input type="submit" class="mt-4 text-white p-2 border border-gray-300 cursor-pointer rounded-lg" value="Enviar"/>
        </form>
    </div>

    <script>
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
        {!! nl2br($content) !!}
    </div>
</x-layout>