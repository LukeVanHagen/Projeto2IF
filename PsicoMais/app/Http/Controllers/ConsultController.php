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
        $current_date = $validatedData['date'];
    
        $dateModified = false; // Variável para rastrear se a data já foi modificada
    
        for ($i = 0; $i < $validatedData['period']; $i++) {
            $consult = new Consult;
            $consult->profissional_id = Auth::id();
            $consult->paciente_id = null;
    
            $consult->date = $current_date;
            $consult->time = date('H:i', $start_time + ($i * 3600));
            $consult->end_time = date('H:i', $start_time + (($i + 1) * 3600));
    
            if ($consult->end_time >= "00:00" && !$dateModified) {
                $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
                $dateModified = true;
            } elseif ($consult->end_time <= "00:00") {
                $dateModified = false; // Reinicia a variável para a próxima ocorrência de ultrapassar a meia-noite
            }
    
            // Verifica se já existe uma consulta do mesmo profissional no mesmo horário
            $existingConsult = Consult::where('profissional_id', $consult->profissional_id)
                ->where('date', $consult->date)
                ->where(function ($query) use ($consult) {
                    $query->where(function ($q) use ($consult) {
                        $q->where('time', '>=', $consult->time)
                            ->where('time', '<', $consult->end_time);
                    })
                    ->orWhere(function ($q) use ($consult) {
                        $q->where('time', '<=', $consult->time)
                            ->where('end_time', '>', $consult->time);
                    })
                    ->orWhere(function ($q) use ($consult) {
                        $q->where('time', '>=', $consult->time)
                            ->where('end_time', '<=', $consult->end_time);
                    });
                })
                ->first();
    
            if ($existingConsult) {
                return redirect()->route('consult.create')->with('msg', 'Já existe uma consulta disponibilizada nesse horário.');
            }
    
            // Verifica se já existe uma consulta do mesmo profissional durante o intervalo de horário
            $overlappingConsult = Consult::where('profissional_id', $consult->profissional_id)
                ->where('date', $consult->date)
                ->where(function ($query) use ($consult) {
                    $query->where('time', '<', $consult->time)
                        ->where('end_time', '>', $consult->time);
                })
                ->orWhere(function ($query) use ($consult) {
                    $query->where('time', '>=', $consult->time)
                        ->where('end_time', '<=', $consult->end_time);
                })
                ->orWhere(function ($query) use ($consult) {
                    $query->where('time', '<', $consult->end_time)
                        ->where('end_time', '>', $consult->end_time);
                })
                ->first();
    
            if ($overlappingConsult) {
                return redirect()->route('consult.create')->with('msg', 'Já existe uma consulta durante o intervalo desse horário.');
            }
    
            $consults->push($consult);
        }
    
        Consult::insert($consults->toArray());
    
        return redirect()->route('consult.create')->with('msg', 'Consultas criadas com sucesso!');
    }
    

    public function list()
    {
        $consults = Consult::all();
        $sortedConsults = $consults->sortBy(function ($consult) {
            return $consult->date . ' ' . $consult->time;
        });
        $users = User::all();
        return view('consult.list', compact('sortedConsults', 'users'));
    }

    public function createAvailability()
    {
        if (Auth::user()->type == "Profissional") {
            $users = User::all();
            $consults = Consult::all();
            $sortedConsults = $consults->sortBy(function ($consult) {
                return $consult->date . ' ' . $consult->time;
            });
            $dataAtual = Carbon::now()->format('Y-m-d');
            return view('consult.create', compact('sortedConsults', 'users','dataAtual'));
        } else {
            return redirect()->route('dashboard')->with('msg', 'Acesso Negado!');
        }
    }
    public function mark(Request $request, $id)
    {
        $userId = $request->input('user_id');

        $consult = Consult::findOrFail($id);
        $consult->paciente_id = $userId;
        $consult->save();

        return redirect()->route('dashboard')->with('msg', 'Consulta marcada com sucesso!');

    }
    public function cancel(Request $request, $id)
    {
        $userId = $request->input('user_id');

        $consult = Consult::findOrFail($id);
        $consult->paciente_id = null;
        $consult->save();

        return redirect()->route('dashboard')->with('msg', 'Consulta desmarcada com sucesso!');

    }
    public function destroy($id)
    {
        $consult = Consult::find($id);

        if (!$consult) {
            return redirect()->route('dashboard')->with('msg', 'Consulta não encontrada');
        }

        $consult->delete();

        return redirect()->route('consult.create')->with('msg', 'Consulta excluída com sucesso!');
    }
}