<?php

namespace App\Repositories;

use App\Http\Dto\SeriesData;
use App\Models\Series;

interface SeriesRepository
{
    public function add(SeriesData $series): Series;
}