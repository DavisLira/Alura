<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        $series = Series::create($request->all());

        $seasons = [];
        for ($i = 1; $i <= $request->seasonsQty; $i++) {
            $seasons[] = [
                'series_id' => $series->id,
                'number' => $i,
            ];
        }
        Season::insert($seasons);

        $episodes = [];
        foreach ($series->seasons as $season) {
            for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                $episodes[] = [
                    'season_id' => $season->id,
                    'number' => $j,
                ];
            }
        }
        Episode::insert($episodes);

        session()->flash('mensagem.sucesso', "Série '{$series->name}' adicionada com sucesso");

        return to_route('series.index');
    }

    public function destroy(Series $series)
    {
        $series->delete();
        session()->flash('mensagem.sucesso', "Série '{$series->name}' removida com sucesso");

        return to_route('series.index');
    }

    public function edit(Series $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all())->save();
        session()->flash('mensagem.sucesso', "Série '{$series->name}' atualizada com sucesso");

        return to_route('series.index');
    }
}
