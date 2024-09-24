<?php

namespace Tests\Feature;

use App\Http\Requests\SeriesFormRequest;
use App\Repositories\SeriesRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeriesRepositoryTest extends TestCase
{
    public function test_when_a_series_is_created_its_seasons_and_episodes_must_also_be_created(): void
    {
        // Arange
        $repository = $this->app->make(SeriesRepository::class);
        $request = new SeriesFormRequest();
        // $request->name = 'Nome da série';
        // $request->seasonsQty = 1;
        // $request->episodesPerSeason = 1;

        // Act

        // Assert
    }
}
