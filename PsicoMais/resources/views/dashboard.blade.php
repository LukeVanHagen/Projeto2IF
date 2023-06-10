<x-app-layout>
    <div>
        <div>
            <div>
                <div class="disp_horario">
                    <div class="list1">
                    
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
                    </div>
                    @if ($hasConsults)
                        <h3 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Consultas Agendadas :') }}
                        </h3>

                        <div class="c-conteiner">
                            @foreach ($sortedConsults as $consult)
                                @if ((($consult->paciente_id && $consult->profissional_id == auth()->user()->id && Auth::user()->type == 'Profissional') ||
                                    ($consult->paciente_id && $consult->paciente_id == auth()->user()->id && Auth::user()->type == 'Paciente')) &&
                                    strtotime($consult->date) > time())
                                    <div class="card">
                                        <div class="c-body">
                                            @if(Auth::user()->type == 'Profissional')
                                                <div class="consulta">     
                                                    <label class="label-consul">Paciente:</label>
                                                    <div class="consulta-name">{{ $users->find($consult->paciente_id)->name}}</div>
                                                </div>
                                            @elseif(Auth::user()->type == 'Paciente')
                                                <div class="consulta">     
                                                    <label class="label-consul">Profissional:</label>
                                                    <div class="consulta-name">{{ $users->find($consult->profissional_id)->name }}</div>
                                                </div>
                                            @endif
                                            <div class="consulta">
                                                <label class="label-consul">Data:</label>
                                                <div class="consulta-name">{{ date('d-m-Y', strtotime($consult->date)) }}</div>
                                            </div>
                                            <div class="consulta">
                                                <label class="label-consul">Início:</label>
                                                <div class="consulta-name">{{ date('H:i', strtotime($consult->date)) }}</div>
                                            </div>
                                            <div class="consulta">
                                                <label class="label-consul">Término:</label>
                                                <div class="consulta-name">{{ date('H:i', strtotime($consult->end_time)) }}</div>
                                            </div>
                                            <div class="consulta">
                                                <div class="consulta-botao">
                                                    <form action="{{ route('consult.cancel', $consult->id) }}" method="POST">
                                                        @csrf
                                                        <x-primary-button class="btt-3" type="submit" data-confirm="Tem certeza que deseja desmarcar?">Desmarcar</x-primary-button>
                                                    </form>
                                                </div>
                                            </div>
                                            @if(Auth::user()->type == 'Profissional')
                                                <div class="consulta">
                                                    <div class="consulta-botao">
                                                        <form action="{{ route('consult.destroy', $consult->id) }}" method="POST">
                                                            @csrf
                                                            <x-primary-button class="btt-3" type="submit" data-confirm="Tem certeza que deseja excluir?">Excluir</x-primary-button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @endforeach
                            </div>

                    @else
                        <div class="disp_horario">
                            <h3 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Consultas Agendadas :') }}
                            </h3>
                            <div class="disp_horario">
                                <p class="list1"> Não há consultas agendadas.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
