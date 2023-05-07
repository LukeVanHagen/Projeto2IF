<?php

namespace App\Http\Controllers;
use App\Models\Consult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ConsultController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'day' => 'required|integer|min:1|max:31',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2022',
            'hours' => 'required|integer|min:0|max:23',
            'minutes' => 'required|integer|min:0|max:59',
            'period' => 'required|integer|min:0|max:24',
        ]);

        $consult = new Consult;
        $consult->profissional_id = Auth::id(); 
        $consult->paciente_id = null;
        $consult->day = $validatedData['day'];
        $consult->month = $validatedData['month'];
        $consult->year = $validatedData['year'];
        $consult->hours = $validatedData['hours'];
        $consult->minutes = $validatedData['minutes'];
        $consult->period = $validatedData['period'];
        $consult->save();

        return redirect()->route('dashboard')->with('msg', 'Consulta criada com sucesso!');
    }
}
