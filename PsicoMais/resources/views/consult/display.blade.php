<x-app-layout>
    <div>
        <div>
            

            <div>
                <div>
                    <div>
                        <div class="disp_horario">
                            <div class="list1">
                            @if(session('msg'))
                                {{ session('msg') }}
                            @endif

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
                            </div>
                            <h3 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Consultas Disponibilizadas :') }}
                            </h3>

                            @if ($hasAvailableConsults)
                                <div class="list2 flex justify-between text-center p-2 gap-4">
                                   <table class="list2 dark:text-white p-2">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Início</th>
                                            <th>Término</th>
                                            <th>Ações</th>
                                            <th>
                                            <form action="{{ route('consult.create' ) }}" method="POST">
                                                @csrf
                                                <x-primary-button type="submit">+</x-primary-button>
                                            </form>
                                            </th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                            @foreach ($sortedConsults as $consult)
                                                @if (!$consult->paciente_id && $consult->profissional_id == auth()->user()->id)
                                               <tr>
                                                <td>{{ date('d-m-Y', strtotime($consult->date)) }}</td>
                                                <td>{{ date('H:i', strtotime($consult->date)) }}</td>
                                                <td>{{ date('H:i', strtotime($consult->end_time)) }}</td>
                                                <td> 
                                                            <form action="{{ route('consult.destroy', $consult->id) }}" method="POST">
                                                                @csrf
                                                                <x-primary-button type="submit" data-confirm="Tem certeza que deseja excluir?">Excluir</x-primary-button>
                                                            </form>
                                                </td>
                                               </tr>
                                                        
                                                @endif
                                            @endforeach
                                        </tbody>
                                       </table>
                                </div>
                            @else
                            <div class="disp_horario">
                                <p class="list1">Não há consultas disponibilizadas não agendadas</p>
                            </div>    
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
