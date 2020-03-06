<?php

namespace App\Http\Controllers;

use App\Consultation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $carbon_date_time = Carbon::now('Europe/Vilnius');
        $today_date = $carbon_date_time->format('Y-m-d');
        $today_time = $carbon_date_time->format('H:i:s');
        $consultations = Consultation::where('consultation_date', $today_date)
            ->where('consultation_time', '>', $today_time)
            ->orderBy('consultation_time', 'asc')
            ->get();
        $con_count = count($consultations);

        $now_live_cons = Consultation::where('consultation_date', $today_date)
            ->where('consultation_time', '<', $today_time)
            ->whereRaw('ADDTIME(`consultation_length`, `consultation_time`) >"'.$today_time.'"')
            ->orderBy('consultation_time', 'asc')
            ->get();
        $live_con_count = count($now_live_cons);

        return view('home')
            ->with('consultations', $consultations)
            ->with('live_consultations', $now_live_cons)
            ->with('con_count', $con_count)
            ->with('live_con_count', $live_con_count);
    }
}
