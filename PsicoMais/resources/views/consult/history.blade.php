<x-app-layout>

    <div>
        <div>
            <div>
                <div>
                    <h3 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Histórico de Consultas') }} 
                    </h3>
                    
                    <div class="list2 flex justify-between text-center p-2 gap-4">
                        <table class="list2 dark:text-white p-2">
                          <thead>
                            <tr>
                                @if(Auth::check() && Auth::user()->type == 'Profissional')
                                <th>Paciente</th>
                                @elseif(Auth::check() && Auth::user()->type == 'Paciente')
                                <th>Profissional</th>
                                @endif
                                <th>Data</th>
                                <th>Início</th>
                                <th>Término</th>
                            </tr>
                          </thead>
                        <tbody>
                        @php
                            $consults = $sortedConsults;
                        @endphp
                        @foreach ($consults as $consult)
                            @if (($consult->paciente_id == Auth::id() || $consult->profissional_id == Auth::id()) && strtotime($consult->date) < time() && $consult->paciente_id != null)
                            <tr>
                                @if (consult->paciente_id == Auth::id())
                                <td>{{ $users->find($consult->profissional_id)->name }}</td>
                                @else
                                <td>{{ $users->find($consult->paciente_id)->name }}</td>
                                @endif
                                <td>{{ date('d-m-Y', strtotime($consult->date)) }}</td>
                                <td>{{ date('H:i', strtotime($consult->date)) }}</td>
                                <td>{{ date('H:i', strtotime($consult->end_time)) }}</td>
                            </tr>
                            @endif
                        @endforeach
                      </tbody>
                    </table>
                   </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
