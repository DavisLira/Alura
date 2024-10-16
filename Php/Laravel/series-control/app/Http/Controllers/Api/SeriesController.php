<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Dto\SeriesData;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository)
    {
    }

    public function index(Request $request)
    {
        $query = Series::query();
        if ($request->has('name')) {
            $query->where('name', $request->name);
        }

        return $query->paginate(5);
    }

    public function store(SeriesFormRequest $request)
    {
        $coverPath = null;

        $seriesData = new SeriesData(
            $request->name,
            $request->seasonsQty,
            $request->episodesPerSeason,
            $coverPath
        );

        return  response()
            ->json($this->seriesRepository->add($seriesData, 201));
    }

    public function show(int $series)
    {
        $seriesModel = Series::with('seasons.episodes')->find($series);
        if ($seriesModel == null) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        return $seriesModel;
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return $series;
    }

    public function destroy(int $series, Authenticatable $user)
    {
        if (!$user->tokenCan('is_admin')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        Series::destroy($series);
        return response()->noContent();
    }
}