<x-app-layout>
    <div class="disp_horario" x-data="filterConsults()">
        <div class="list1">
            @if(session('msg'))
                {{ session('msg') }}
            @endif
        </div>
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
        <h3 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Consultas Disponibilizadas :') }}
        </h3>

        <div>
            <div>
                <label for="start_date">Data de Início:</label>
                <input type="date" x-model="startDate" id="start_date">
            </div>
            <div>
                <label for="end_date">Data Final:</label>
                <input type="date" x-model="endDate" id="end_date">
            </div>
            <div>
                <button @click="filterConsults">Filtrar</button>
            </div>
        </div>

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
                            <tr class="consult-row" data-date="{{ date('Y-m-d', strtotime($consult->date)) }}">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="disp_horario">
                <p class="list1">Não há consultas disponibilizadas não agendadas. 
                <form action="{{ route('consult.create' ) }}" method="POST">
                        @csrf
                        <x-primary-button type="submit">Disponibilizar Horário</x-primary-button>
                </form>
                </p>
            </div>    
        @endif
    </div>
</x-app-layout>
