<?php

namespace App\Http\Controllers;

use App\Models\Consult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class ConsultController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'period' => 'required|integer|min:1|max:24',
        ]);

        $start_time = strtotime($validatedData['time']);
        $consults = collect();

        for ($i = 0; $i < $validatedData['period']; $i++) {
            $consult = new Consult;
            $consult->profissional_id = Auth::id();
            $consult->paciente_id = null;
            $consult->date = $validatedData['date'];
            $consult->time = date('H:i', $start_time);
            $consult->end_time = date('H:i', strtotime('+1 hour', $start_time));
            $consults->push($consult);
        }

        Consult::insert($consults->toArray());

        return redirect()->route('dashboard')->with('msg', 'Consultas criadas com sucesso!');
    }

    public function list()
    {
        $consults = Consult::all();
        return view('lista-disponibilidades', compact('consults'));
    }

    public function createAvailability()
    {
        if (Auth::user()->type == "Profissional") {
            $dataAtual = Carbon::now()->format('Y-m-d');
            return view('profissional.cadastroDisponibilidade', ['dataAtual' => $dataAtual]);
        } else {
            return redirect()->route('dashboard')->with('msg', 'Acesso Negado!');
        }
    }
}