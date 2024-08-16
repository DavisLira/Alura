<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        $series = [
            'Punisher',
            'Lost',
            'Greys\'s anatomy'
        ];

        return view('listar-series', compact('series'));
    }
}
