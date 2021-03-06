<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewsController extends Controller
{
    public function glossario() {
        return view('glossario.glossario');
    }

    public function listarPalavras() {
        return view('glossario.lista_de_palavras');
    }
    
    public function pesquisa() {
        return view('glossario.pesquisa');
    }

    public function LinhaDoTempo() {
        return view('glossario.linha_do_tempo');
    }

    public function contarView($id) {
        $trecho = \App\Trecho::find($id);
        $trecho->quant_views = $trecho->quant_views + 1;
        $trecho->update();
    }

    public function viewOhGlossario() {
        return view('glossario.o_glossario');
    }
}
