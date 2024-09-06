<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EpisodesController
{
    public function index(Season $season)
    {
        $mensagemSucesso = session('mensagem.sucesso');
        
        return view('episodes.index')
            ->with('episodes', $season->episodes)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function update(Request $request, Season $season)
    {
        $watchedEpisodes = implode(', ', $request->episodes ?? []);

        if (empty($watchedEpisodes)) {
            DB::transaction(function() use ($season) {
                $season->episodes()->update(['watched' => 0]);
            });

            session()->flash('mensagem.sucesso', "Episódios marcados como não assistidos");
        } else {
            DB::transaction(function () use ($watchedEpisodes, $season) {
                $season->episodes()->update(['watched' => DB::raw("case when id in ($watchedEpisodes) then 1 else 0 end")]);
            });
            
            session()->flash('mensagem.sucesso', "Episódios marcados como assistidos");
        }


        return to_route('episodes.index', $season->id);
    }
}
