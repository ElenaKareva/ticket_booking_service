<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Http\Requests\FilmRequest;
use App\Services\FilmService;
use Illuminate\Http\Response;

class FilmsController extends Controller
{
    public function index() 
    {
        return view ('admin', ['films'=>Film::all()]); 
    }

    public function addFilm(FilmRequest $request, FilmService $filmService) 
    {
        $filmService->addFilm($request);
        return redirect()->route('admin')->with('success', 'Фильм добавлен');
    }

    public function deleteFilm($id) 
    {
        Film::find($id)->delete();
        return redirect()->route('admin')->with('success', 'Фильм  удалён');
    }
}
