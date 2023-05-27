<x-app-layout>
        <div class="disp_horario">
                <h3  class=" list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Disponibilizar Horário :
                </h3>
        </div>

    <div>
        <div>
            <div class=" forms_create ">
            <form  action="{{ route('consult.store') }}" method="POST">
                @csrf

                <div class="B_D_P">
                <label for="day">Estarei disponível em : </label>
                <input class="select" type="date" name="date" id="date" value="{{ $dataAtual }}" required>
                </div>
                <div class="B_D_P">
                    <label for="hour">ás : </label>
                    <input class="select" type="time" id="time" name="time" required>
                </div>
                <div class="B_D_P">
                    <p><label for="period">Durante</label>
                    <input class="select" type="number" name="period" id="period" min="1" max="24" placeholder="00" required>
                    <label for="period">Horas</label></p>
                </div>
                <div class="B_D_P">

                    <x-primary-button class="btt-3">
                    {{ __('Enviar') }}
                    </x-primary-button>

                </div>
            </form>
            </div>
        </div>
    </div>
    <div>
        <div>
            <div>
                <div class="">
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

                    <h3 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Consultas Disponibilizadas :') }}
                    </h3>

                    @if ($hasAvailableConsults)
                        <div class="list2 flex justify-between text-center p-2 gap-4">
                            <table class="list2 dark:text-white p-2">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Ínicio</th>
                                        <th>Término</th>
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
                                                        <x-primary-button class="btt-3" type="submit">Excluir</x-primary-button>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


