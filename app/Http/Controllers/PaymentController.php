<?php

namespace App\Http\Controllers;

use App\Consultation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index() {
        return view('payments.index');
    }

    public function update(Request $request) {
        $period = $request->input('period');
        $period_array = explode(' - ', $period);
        $consultations = Consultation::where('client_id', $request->input('company_id'))
            ->where('consultation_date', '>=', $period_array[0])
            ->where('consultation_date', '<=', $period_array[1]);

        $consultations_count = $consultations->count();

        $consultations->update([
            'is_paid' => $request->input('is_paid'),
            'paid_date' => $request->input('payment_date')
        ]);
        return redirect('/')->with('success', '<stroong>'. $consultations_count .'</stroong>'.' konsultacijos sėkmingai atnaujintos!');
    }
}
