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