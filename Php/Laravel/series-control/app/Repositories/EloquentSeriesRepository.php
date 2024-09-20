<?php

namespace App\Repositories;

use App\Http\Dto\SeriesData;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Support\Facades\DB;

class EloquentSeriesRepository implements SeriesRepository 
{
    public function add(SeriesData $seriesData): Series
    {
        return DB::transaction(function () use ($seriesData) {
            $series = Series::create([
                'name' => $seriesData->name, 
                'cover_path' => $seriesData->coverPath,
            ]);
            
            $seasons = [];
            for ($i = 1; $i <= $seriesData->seasonsQty; $i++) {
                $seasons[] = [
                    'series_id' => $series->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);
    
            $episodes = [];
            foreach ($series->seasons as $season) {
                for ($j = 1; $j <= $seriesData->episodesPerSeason; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j,
                    ];
                }
            }
            Episode::insert($episodes);
            DB::commit();

            return $series;
        });
    }
}