<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticator;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware(Authenticator::class)->except('index');
    }

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
            $series = $this->repository->add($request);

            $email = new SeriesCreated(
                $series->name,
                $series->id,
                $request->seasonsQty,
                $request->episodesPerSeason
            );
            Mail::to($request->user())->send($email);

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
