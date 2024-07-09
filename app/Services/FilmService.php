<?php
namespace App\Services;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FilmService
{
    public function addFilm(Request $request)
    {
        $image = $request->file('image')->store('uploads', 'public');
        $film = new Film();
        $film->title = $request->input('title');
        $film->duration = $request->input('duration');
        $film->description = $request->input('description');
        $film->country = $request->input('country');
        $film->image = $image;
        $film->save();
    }
}