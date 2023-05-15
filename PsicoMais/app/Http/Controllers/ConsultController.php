<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Consult;


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
            $consult->time = date('H:i', $start_time + ($i * 3600));
            $consult->end_time = date('H:i', $start_time + (($i + 1) * 3600));
            $consults->push($consult);
        }
    
        Consult::insert($consults->toArray());
    
        return redirect()->route('dashboard')->with('msg', 'Consultas criadas com sucesso!');
    }

    public function list()
    {
        $consults = Consult::all();
        $users = User::all();
        return view('consult.list', compact('consults', 'users'));
    }

    public function createAvailability()
    {
        if (Auth::user()->type == "Profissional") {
            $dataAtual = Carbon::now()->format('Y-m-d');
            return view('consult.create', ['dataAtual' => $dataAtual]);
        } else {
            return redirect()->route('dashboard')->with('msg', 'Acesso Negado!');
        }
    }
}