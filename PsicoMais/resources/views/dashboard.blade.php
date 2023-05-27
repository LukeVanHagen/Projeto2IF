<x-app-layout>
    <div>
        <div>
            <div>
                <div class="">
                    @if(session('msg'))
                        {{ session('msg') }}
                    @endif

                    @php
                        $hasConsults = false;
                    @endphp

                    @foreach ($sortedConsults as $consult)
                        @if (($consult->paciente_id && $consult->profissional_id == auth()->user()->id && Auth::user()->type == 'Profissional') ||
                            ($consult->paciente_id && $consult->paciente_id == auth()->user()->id && Auth::user()->type == 'Paciente'))
                            @php
                                $hasConsults = true;
                                break;
                            @endphp
                        @endif
                    @endforeach

                    @if ($hasConsults)
                        <h3 class=" list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Consultas Agendadas:') }}
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
                                        <th>Ínicio</th>
                                        <th>Término</th>
                                        <th colspan='2'>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sortedConsults as $consult)
                                        @if (($consult->paciente_id && $consult->profissional_id == auth()->user()->id && Auth::user()->type == 'Profissional') ||
                                            ($consult->paciente_id && $consult->paciente_id == auth()->user()->id && Auth::user()->type == 'Paciente'))
                                            <tr>
                                                @if(Auth::user()->type == 'Profissional')
                                                    <td>{{ $users->find($consult->paciente_id)->name }}</td>
                                                @elseif(Auth::user()->type == 'Paciente')
                                                    <td>{{ $users->find($consult->profissional_id)->name }}</td>
                                                @endif
                                                <td>{{ $consult->date }}</td>
                                                <td>{{ date('H:i', strtotime($consult->time)) }}</td>
                                                <td>{{ date('H:i', strtotime($consult->end_time)) }}</td>
                                                <td>
                                                    <form action="{{ route('consult.cancel', $consult->id) }}" method="POST">
                                                        @csrf
                                                        <button class="btt-2" type="submit">Cancelar</button>
                                                    </form>
                                                </td>
                                                @if(Auth::user()->type == 'Profissional')
                                                    <td>
                                                        <form action="{{ route('consult.destroy', $consult->id) }}" method="POST">
                                                            @csrf
                                                            <button class="btt-2" type="submit">Excluir</button>
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
                        <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Consultas Agendadas:') }}
                        </h3>
                        <p>Não há consultas agendadas.</p>
                    @endif

                    @if(Auth::user()->type == 'Profissional')
                        @php
                            $hasAvailableConsults = false;
                        @endphp

                        @foreach ($sortedConsults as $consult)
                            @if (!$consult->paciente_id && $consult->profissional_id == auth()->user()->id)
                                @php
                                    $hasAvailableConsults = true;
                                    break;
                                @endphp
                            @endif
                        @endforeach
                        <h3 class=" list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Consultas Disponibilizadas:') }}
                        </h3>
                        @if ($hasAvailableConsults)
                            

                            <div class="list2 flex justify-between text-center p-2 gap-4">
                                <table class="list2 dark:text-white p-2">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Ínicio</th>
                                            <th>Término</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sortedConsults as $consult)
                                            @if (!$consult->paciente_id && $consult->profissional_id == auth()->user()->id)
                                                <tr>
                                                    <td>{{ $consult->date }}</td>
                                                    <td>{{ date('H:i', strtotime($consult->time)) }}</td>
                                                    <td>{{ date('H:i', strtotime($consult->end_time)) }}</td>
                                                    <td>
                                                        <form action="{{ route('consult.destroy', $consult->id) }}" method="POST">
                                                            @csrf
                                                            <button class="btt-2" type="submit">Excluir</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>Não há consultas disponibilizadas.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
