<x-layout>
    <h2 class="mb-4 text-white">FEW SHOT - RECEBE DOCUMENTOS PDF E REGISTRA NO BANCO</h2>
    <div class="w-[600px]">
        <form id="sendForm" method="POST" enctype="multipart/form-data" action="{{ route('docs.send') }}">
            @csrf
            <label for="sendDoc"></label>
            <input
                id="pdf"
                name="pdf"
                type="file"
                class="p-2 bg-gray-200 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <input type="submit" class="mt-4 text-white p-2 border border-gray-300 cursor-pointer rounded-lg" value="Enviar"/>
        </form>
    </div>

    <div class="w-[600px] min-h-[40px] mt-6 text-xs font-sans text-white border border-gray-300 bg-gray-700 rounded-lg p-2">
        <div class="grid grid-cols-4 gap-2">
            <div>
                ID
            </div>
            <div>
                Numero
            </div>
            <div>
                Valor
            </div>
            <div>
                Vencimento
            </div>


            @foreach($documents as $document)

            <div>
                {{ $document->id }}
            </div>
            <div>
                {{ $document->numero_do_documento }}
            </div>
            <div>
                {{ $document->valor }}
            </div>
            <div>
                {{ $document->data_de_vencimento->format('d/m/Y') }}
            </div>

            @endforeach

        </div>
        
    </div>

    <div class="w-[600px] min-h-[100px] mt-6 text-xs font-sans text-white border border-gray-300 bg-gray-700 rounded-lg p-2">
        <h2 class="text-md font-bold mb-2">Ultimo documento registrado pela IA</h2>
        {!! nl2br($content) !!}
    </div>
</x-layout>