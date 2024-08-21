<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Serie::query()->orderBy('nome')->get();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        $series = Serie::create($request->all());
        session()->flash('mensagem.sucesso', "Série '{$series->nome}' adicionada com sucesso");

        return to_route('series.index');
    }

    public function destroy(Serie $series)
    {
        $series->delete();
        session()->flash('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");

        return to_route('series.index');
    }

    public function edit(Serie $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Serie $series, Request $request)
    {
        $series->fill($request->all())->save();
        session()->flash('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");

        return to_route('series.index');
    }
}
