<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SessionsRequest;
use App\Http\Requests\TicketRequest;
use App\Models\Session;
use App\Models\Film;
use App\Services\SessionService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SessionController extends Controller
{
    public function index($id) 
    {
        return view ('hall', ['sessions'=>Session::find($id)]); 
    }

    public function  addSession(SessionsRequest $request, SessionService $sessionService) 
    {
        {
            $session = $sessionService->addSession($request);
            $time = $request->input('time');
            $stime = explode(':', $time);
            $minute_start = round((($stime[0] * 60) + $stime[1]) / 2);
            $session->minute_start = $minute_start;
            $duration_film = Film::where('title', $request->film)->first()->duration;
            $session->duration = round($duration_film / 2);
            $minute_finish = round($minute_start + ($duration_film / 2));
            $session->minute_finish = $minute_finish;
    
            if (!Session::where('hall_id', $request->id)
                ->where('date', $request->date)
                ->where('minute_start', '<=', $minute_start)
                ->where('minute_finish', '>=', $minute_start)->first()) {
                   $session->save();
                   return redirect()->route('admin')->with('success', 'Сеанс успешно добавлен');
                } else {
                    return redirect()->route('admin')->with('alert-danger', 'Время сеансов совпадает');
        }
     
        }
    }

    public function deleteSession($id) 
    {
        Session::find($id)->delete();
        return redirect()->route('admin')->with('success', 'Фильм успешно удалён из сетки сеансов');
    }

    public function updateSession(Request $request) 
    {
        $session = Session::where('id', $request->id)->first();
        $session->config_hall = $request->input('config');
        $session->save();
        $film_title = Session::where('id', $request->id)->first()->title_film;
        $hall_name = Session::where('id', $request->id)->first()->name_hall;
        $session_start = Session::where('id', $request->id)->first()->session_start;
        $session_date = Session::where('id', $request->id)->first()->date;
        $placeArr = [];
        $priceSum = 0;
        for ($i = 0; $i < count($request->orders); $i++) {
            $row = (string)$request->orders[$i]['row'];
            $place = (string)$request->orders[$i]['seat'];
            $price = (int)$request->orders[$i]['price'];
            $string = $row . ' ряд / ' . $place . ' место';
            $placeArr[] = $string;
            $priceSum += $price;
        }
        $places = implode(', ', $placeArr);
        return route('payment', [
            'film_title' => $film_title, 
            'hall_name' => $hall_name, 
            'session_start' => $session_start,
            'session_date' => $session_date,
            'places' => $places,
            'priceSum' => $priceSum
        ]);
    }

    public function payment(Request $request) 
    {
        return view ('payment', [ 
            'film_title' => $request->input('film_title'), 
            'hall_name' => $request->input('hall_name'), 
            'session_start' => $request->input('session_start'), 
            'session_date' => $request->input('session_date'), 
            'places' => $request->input('places'), 
            'priceSum' => $request->input('priceSum') 
        ]); 
    }

    public function ticket(TicketRequest $request) 
    {
        $QRvalue = 'На фильм: ' . $request->input('film_title') . PHP_EOL . 'Места: ' . $request->input('places') . PHP_EOL . 'В зале: ' . $request->input('hall_name') . PHP_EOL . 'Начало сеанса: ' . $request->input('session_start') . ' ' . date('d.m.Y', strtotime($request->input('session_date'))) . PHP_EOL . 'Стоимость: ' . $request->input('priceSum');
        $QR = QrCode::encoding('UTF-8')->size(200)->generate($QRvalue);
        return view ('ticket', [ 
            'film_title' => $request->input('film_title'), 
            'hall_name' => $request->input('hall_name'), 
            'session_start' => $request->input('session_start'),  
            'session_date' => $request->input('session_date'),
            'places' => $request->input('places'), 
            'priceSum' => $request->input('priceSum'),
            'QR' => $QR
        ]); 
    }
}
