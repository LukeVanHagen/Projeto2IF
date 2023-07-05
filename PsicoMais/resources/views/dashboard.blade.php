<x-app-layout>
    <div>
        <div>
            <div>
                <div class="disp_horario">
                    <div class="list1">
                    
                        @if(session('msg'))
                            <div class="{{ session('class') }}" x-init="hideDivsAfterDelay">
                                {{ session('msg') }}
                            </div>
                        @endif

                        @php
                            $hasConsults = false;
                        @endphp

                        @foreach ($sortedConsults as $consult)
                            @if ((($consult->paciente_id && $consult->profissional_id == auth()->user()->id && Auth::user()->type == 'Profissional') ||
                                        ($consult->paciente_id && $consult->paciente_id == auth()->user()->id && Auth::user()->type == 'Paciente')) &&
                                        strtotime($consult->date) > time())
                                @php
                                    $hasConsults = true;
                                    break;
                                @endphp
                            @endif
                        @endforeach
                    </div>
                    <h3 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Consultas Agendadas :') }}
                    </h3>
                    
                    @if ($hasConsults)
                        <div class="consul-contei">
                            <table>
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
                                        <th colspan=2>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>
                            @foreach ($sortedConsults as $consult)
                                    @if ((($consult->paciente_id && $consult->profissional_id == auth()->user()->id && Auth::user()->type == 'Profissional') ||
                                        ($consult->paciente_id && $consult->paciente_id == auth()->user()->id && Auth::user()->type == 'Paciente')) &&
                                        strtotime($consult->date) > time())
                                        <tr>
                                            @if(Auth::user()->type == 'Profissional')
                                                <td>{{ $users->find($consult->paciente_id)->name}}</td>
                                            @elseif(Auth::user()->type == 'Paciente')
                                                <td>{{ $users->find($consult->profissional_id)->name }}</td>
                                            @endif
                                            <td>{{ date('d-m-Y', strtotime($consult->date)) }}</td>
                                            <td>{{ date('H:i', strtotime($consult->date)) }}</td>
                                            <td>{{ date('H:i', strtotime($consult->end_time)) }}</td>
                                            <td>
                                                <form action="{{ route('consult.cancel', $consult->id) }}" method="POST">
                                                            @csrf
                                                            <x-primary-button class="btt-3" type="submit" data-confirm="Tem certeza que deseja desmarcar?">Desmarcar</x-primary-button>
                                                </form>
                                            </td>
                                            @if(Auth::user()->type == 'Profissional')
                                            <td>
                                                <form action="{{ route('consult.destroy', $consult->id) }}" method="POST">
                                                                @csrf
                                                                <x-primary-button class="btt-3" type="submit" data-confirm="Tem certeza que deseja excluir?">Excluir</x-primary-button>
                                                </form>
                                            </td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @else
                        <p class="list1"> Não há consultas agendadas.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
