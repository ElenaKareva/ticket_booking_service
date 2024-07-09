<?php
namespace App\Services;

use App\Models\Session;
use App\Models\Hall;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SessionService
{
public function addSession(Request $request): Session
    {
        $session = new Session();
        $session->date = $request->input('date');
        $session->session_start = $request->input('time');
        $session->hall_id = $request->input('id');
        $session->title_film = $request->input('film');
        $hall_name = Hall::where('id', $request->id)->first()->name;
        $hall_config = Hall::where('id', $request->id)->first()->config;
        $active_hall = Hall::where('id', $request->id)->first()->active_hall;
        $session->name_hall = $hall_name;
        $session->config_hall = $hall_config;
        $session->active_hall = $active_hall;
        $id_film = Film::where('title', $request->film)->first()->id;
        $session->film_id = $id_film;

        return $session;
    }

}

