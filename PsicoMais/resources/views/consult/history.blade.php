<x-app-layout>

    <div>
        <div>
            <div>
                <div>
                    <h3 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Histórico de Consultas') }} 
                    </h3>
                    
                    <div class="c-conteiner">
                        @php
                            $consults = $sortedConsults;
                        @endphp
                        @foreach ($consults as $consult)
                            @if (($consult->paciente_id == Auth::id() || $consult->profissional_id == Auth::id()) && strtotime($consult->date) < time() && $consult->paciente_id != null) 
                                <div class="card">
                                    <div class="c-body">
                                        @if ($consult->paciente_id == Auth::id())
                                            <div class="consulta">
                                                <label class="label-consul">Profissional:</label>
                                                <div class="consulta-name">{{ $users->find($consult->profissional_id)->name }}</div>
                                            </div>
                                        @else
                                            <div class="consulta">
                                                <label class="label-consul">Paciente:</label>
                                                <div class="consulta-name">{{ $users->find($consult->paciente_id)->name }}</div>
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
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
