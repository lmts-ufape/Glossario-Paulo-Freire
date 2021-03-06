<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerbeteController extends Controller
{
    public function exibir() {
        return view('glossario.adicionar_verbete');
    }

    public function adicionar(Request $request) {
        $validated = $request->validate([
            'nome' => 'required',
        ]);

        $verbete = new \App\Verbete();

        $verbete->descricao = $request->nome;
        $verbete->save();

        return redirect( route('glossario') )->with('mensagem', 'Verbete salvo com sucesso!');
    }

    public function deletar($id) {
        $verbete = \App\Verbete::find($id);

        if ($verbete == null) {
            return abort(404);
        }
        
        $trechos = \App\Trecho::where('verbete_id', $id)->get();

        foreach ($trechos as $trecho) {
            if ($trecho->arquivo_hd != '' && Storage::disk()->exists($trecho->arquivo_hd)) {
                Storage::delete($trecho->arquivo_hd);
            }
    
            if ($trecho->arquivo_sd != '' && Storage::disk()->exists($trecho->arquivo_sd)) {
                Storage::delete($trecho->arquivo_sd);
            }
            $trecho->delete();
        }

        $verbete->delete();
        return redirect( route('glossario') )->with('mensagem', 'Verbete excluido com sucesso!');
    }

    public function editar(Request $request, $id) {
        $validated = $request->validate([
            'descricao' => 'required',
        ]);

        $verbete = \App\Verbete::find($id);

        if ($verbete == null) {
            return abort(404);
        }

        $verbete->descricao = $request->descricao;
        $verbete->update();

        return redirect()->back()->with('mensagem', 'Verbete editado com sucesso!');;
    }
}
