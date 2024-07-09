<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hall;
use App\Models\Film;
use App\Models\Session;
use App\Http\Requests\HallRequest;
use App\Http\Requests\HallPriceRequest;
use App\Http\Requests\HallConfigRequest;
use App\Services\HallService;

class HallsController extends Controller
{
    public function index()
    {
        return view('admin', [
            'halls' => Hall::all(),
            'films' => Film::all(),
            'sessions' => Session::all()
        ]);
    }

    public function indexClient()
    {
        return view('index', [
            'halls' => Hall::all(),
            'films' => Film::all(),
            'sessions' => Session::where('active_hall', 'on')->get()
        ]);
    }

    public function addHall(HallRequest $request)
    {
        $hall = new Hall();
        $hall->name = $request->input('name');
        $hall->save();
        return redirect()->route('admin')->with('success', 'Зал успешно добавлен');
    }

    public function deleteHall($id)
    {
        Hall::find($id)->delete();
        return redirect()->route('admin')->with('success', 'Зал успешно удалён');
    }

    public function price(Request $request)
    {
        $data = Hall::where('id', $request->id)->get();
        return $data;
    }

    public function updatePrice(HallPriceRequest $request, HallService $hallService)
    {
        $hallService->updatePrice($request);
    }

    public function updateConfig(HallConfigRequest $request, HallService $hallService)
    {
        if (Session::where('hall_id', $request->id)->exists()) {
            return response()->json(['code' => 200, 'success' => 'Конфигурация зала не обновлена, так как в зале назначены сеансы']);
        }
        $hallService->updateConfig($request);
        return response()->json(['code' => 400, 'success' => 'Конфигурация зала успешно обновлена']);
    }

    public function startSale(Request $request, HallService $hallService)
    {
        $hallService->startSale($request);
        return redirect()->route('admin')->with('success', 'Продажи обновлены');
    }
}
