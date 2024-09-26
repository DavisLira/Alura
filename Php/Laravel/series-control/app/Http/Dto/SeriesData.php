<?php

namespace App\Http\Dto;

class SeriesData 
{
    public string $name;
    public int $seasonsQty;
    public int $episodesPerSeason;
    public ?string $coverPath;

    public function __construct(
        string $name, 
        int $seasonsQty, 
        int $episodesPerSeason, 
        ?string $coverPath
    ) {
        $this->name = $name;
        $this->seasonsQty = $seasonsQty;
        $this->episodesPerSeason = $episodesPerSeason;
        $this->coverPath = $coverPath;
    }
}
