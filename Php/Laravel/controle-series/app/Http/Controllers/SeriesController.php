<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        try {
            DB::beginTransaction();
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
            DB::commit();

            session()->flash('mensagem.sucesso', "Série '{$series->name}' adicionada com sucesso");

        } catch (\Throwable $e) {
            DB::rollBack();

            session()->flash('mensagem.sucesso', "Erro ao adicionar a série: {$e->getMessage()}");
        }

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
