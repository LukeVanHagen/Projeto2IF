<x-app-layout>
    <div class="disp_horario" x-data="filterConsults()">
        <div class="list1">
            @if(session('msg'))
                <div class="{{ session('class') }}" x-init="hideDivsAfterDelay">
                    {{ session('msg') }}
                </div>
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
            

        @if ($hasAvailableConsults)
        <div class="filter-consul">
          <div class="esq-div  sm:max-w-md mt-6 px-6 py-4 sm:rounded-lg ">
            <h5 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Filtros') }} 
            </h5>
            <div class="B_D_P">
                <label for="start_date">Início:</label>
                <input class="select" type="date" x-model="startDate" id="start_date" required>
            </div>
            <div class="B_D_P">
                <label for="end_date">Fim:</label>
                <input class="select" type="date" x-model="endDate" id="end_date" required>
            </div>
            <div class="center1">
                <x-primary-button @click="filterConsults" >Filtrar</x-primary-button>
            </div> 
            <div class="dir-div">
                <form action="{{ route('consult.create' ) }}" method="POST">
                    @csrf
                    <button type="submit"><img src="{{ asset('images/icon_add.png')}}" width="50px" height="50px"></button>
                </form>
            </div>
          </div>
          
        </div>
        </div>
            <div class="consul-contei">
                <table class="consul-contei:nth-child(even)">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Início</th>
                            <th>Término</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        @foreach ($sortedConsults as $consult)
                            @if (!$consult->paciente_id && $consult->profissional_id == auth()->user()->id)
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
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="disp_horario">
                <p class="list1">Não há consultas disponibilizadas não agendadas.</p>
                <div class="center">
                    <form action="{{ route('consult.create' ) }}" method="POST">
                        @csrf
                        <button type="submit"><img src="{{ asset('images/icon_add.png')}}" width="50px" height="50px"></button>
                    </form>
                </div>
            </div>    
        @endif
    </div>
</x-app-layout>
