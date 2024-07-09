<?php
namespace App\Services;

use App\Models\Session;
use App\Models\Hall;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HallService
{
    public function updateConfig(Request $request) 
    {
        $hall = Hall::where('id', $request->id)->first();
        $hall->rows = $request->input('rows');
        $hall->seats = $request->input('seats');
        $hall->config = $request->input('config');
        $hall->save();
    }

    public function updatePrice(Request $request) 
    {
        $hall = Hall::where('id', $request->id)->first();
        $hall->standart_price = $request->input('standart_price');
        $hall->vip_price = $request->input('vip_price');
        $hall->save();
    }

    public function startSale(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            $hall = Hall::findOrFail($key);
            $hall->active_hall = $value;
            $hall->save();
            $sessions = Session::where('hall_id', $key)->get();
            foreach ($sessions as $session) {
                $session->active_hall = $value;
                $session->save();
            }
        };
    }
}