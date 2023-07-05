<?php

namespace App\Http\Controllers;

use App\Models\Consult;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConsultController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'time' => 'required',
            'period' => 'required|integer|min:1|max:24',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('consult.display')->withErrors($validator)->withInput();
        }
    
        $validatedData = $validator->validated();
    
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $validatedData['date'] . ' ' . $validatedData['time']);
        $endDateTime = $startDateTime->copy()->addHours($validatedData['period']);
    
        $existingConsults = DB::table('consults')
        ->where('profissional_id', Auth::id())
        ->where(function ($query) use ($startDateTime, $endDateTime) {
            $query->whereBetween('date', [$startDateTime, $endDateTime])
                ->orWhere(function ($subQuery) use ($startDateTime, $endDateTime) {
                    $subQuery->where('date', '<', $startDateTime)
                        ->where('end_time', '>', $startDateTime)
                        ->where('end_time', '<', $endDateTime);
                })
                ->orWhere(function ($subQuery) use ($startDateTime, $endDateTime) {
                    $subQuery->where('date', '>', $startDateTime)
                        ->where('date', '<', $endDateTime)
                        ->where('end_time', '>', $endDateTime);
                });
        })
        ->get();
    
    
        if ($existingConsults->count() > 0) {
            return redirect()->route('consult.display')->with([
                'msg' => 'Já existe uma consulta disponibilizada nesse horário.',
                'class' => 'msg vermelho'
            ]);
        }
    
        $consults = [];
        $dateModified = false;
    
        for ($i = 0; $i < $validatedData['period']; $i++) {
            $startHour = $startDateTime->copy()->addHours($i);
            $endHour = $startDateTime->copy()->addHours($i + 1);
    
            $consults[] = [
                'profissional_id' => Auth::id(),
                'paciente_id' => null,
                'date' => $startHour->format('Y-m-d H:i'), // Combina a data e a hora
                'end_time' => $endHour->format('H:i'), // Utiliza apenas a hora final
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
    
        DB::table('consults')->insert($consults);
    
        return redirect()->route('consult.display')->with([
            'msg' => 'Consultas criadas com sucesso!',
            'class' => 'msg verde'
        ]);
    }
    
    

    public function list()
    {
        $consults = Consult::all();
        $dataAtual = Carbon::now()->format('Y-m-d');
        $sortedConsults = $consults->sortBy(function ($consult) {
            return $consult->date . ' ' . $consult->time;
        });
        $users = User::all();
        return view('consult.list', compact('sortedConsults', 'users','dataAtual'));
    }
    public function history()
    {
        $consults = Consult::all();
        $sortedConsults = $consults->sortBy(function ($consult) {
            return $consult->date . ' ' . $consult->time;
        });
        $users = User::all();
        return view('consult.history', compact('sortedConsults', 'users'));
    }

    public function display()
    {
        if (Auth::user()->type == "Profissional") {
            $users = User::all();
            $consults = Consult::all();
            $dataAtual = Carbon::now()->format('d-m-Y');  
            $sortedConsults = $consults->sortBy(function ($consult) {
                return $consult->date . ' ' . $consult->time;
            });

            return view('consult.display', compact('sortedConsults', 'users','dataAtual'));
        } else {
            return redirect()->route('dashboard')->with([
                'msg' => 'Acesso negado!',
                'class' => 'msg vermelho'
            ]);
        }
    }
    public function create()
    {
        if (Auth::user()->type == "Profissional") {   
            $dataAtual = Carbon::now()->format('Y-m-d');       
            return view('consult.create', compact('dataAtual'));
        } else {
            return redirect()->route('dashboard')->with([
                'msg' => 'Acesso negado!',
                'class' => 'msg vermelho'
            ]);
        }
    }
    public function mark(Request $request, $id)
    {
        $userId = $request->input('user_id');

        $consult = Consult::findOrFail($id);
        $consult->paciente_id = $userId;
        $consult->save();

        return redirect()->route('dashboard')->with([
            'msg' => 'Consulta marcada com sucesso!',
            'class' => 'msg verde'
        ]);

    }
    public function cancel(Request $request, $id)
    {
        $userId = $request->input('user_id');

        $consult = Consult::findOrFail($id);
        $consult->paciente_id = null;
        $consult->save();

        return redirect()->route('dashboard')->with([
            'msg' => 'Consulta desmarcada com sucesso!',
            'class' => 'msg verde'
        ]);

    }
    public function destroy($id)
    {
        $consult = Consult::find($id);

        if (!$consult) {
            return redirect()->route('dashboard')->with([
                'msg' => 'Consulta não encontrada',
                'class' => 'msg vermelho'
            ]);
        }

        $consult->delete();

        return redirect()->route('consult.display')->with([
            'msg' => 'Consulta excluida com sucesso!',
            'class' => 'msg verde'
        ]);
    }
}