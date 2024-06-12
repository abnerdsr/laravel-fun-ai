<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\Chat;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Smalot\PdfParser\Parser;

class DocsController extends Controller
{
    public function index(): mixed
    {
        session()->forget([
            'chat.home',
            'chat.bot',
            'chat.chatbot',
        ]);

        $content = Markdown::parse(session('chat.docs')?->messages()->last()['content'] ?? '');

        $documents = Document::all();

        return view('docs', compact('content', 'documents'));
    }

    public function send(Request $request): mixed
    {
        $filePath = $request->file('pdf')->getPathName();

        $parser = new Parser();
        $pdf = $parser->parseFile($filePath);
        $text = $pdf->getText();

        $chat = (new Chat)
            ->system(
                <<<MESSAGE
                Você é um contador que analisa dados de documentos fiscais, 
                esses documentos seguem o modelo descrito no site da Receita Federal 
                link do site: (https://www.gov.br/receitafederal/pt-br/centrais-de-conteudo/formularios/modelos)
                Após analisar os dados do documento extraido forneça apenas um json como resposta contendo toda informação presente no documento
                O json deve conter as seguintes informações: data de vencimento, numero do documento e valor
                Sendo que a data de vencimento no json deve vir no formato seguindo o exemplo: 2024-06-10
                O Numero do documento pode ser qualquer numero que identifique o documento em questão
                O Valor de ser em reais
                Exemplo de json a ser seguido: {"data_de_vencimento":"1900-01-01","numero_do_documento":"00000","valor":"0.00"}
                Caso você não encontre algum valor no documento informado, preencha o campo com o valor do exemplo.
            MESSAGE
            )
            ->json();

        $chat->send("Texto extraido do pdf: [ {$text} ]. \n\nforneça um json com as informações do conteúdo acima");

        session()->put('chat.docs', $chat);

        try {
            $documentData = json_decode(session('chat.docs')?->messages()->last()['content'], true);
            Document::create($documentData);
            
        } catch (\Exception $e) {
            info($e->getMessage());
        }

        return back();
    }
}
