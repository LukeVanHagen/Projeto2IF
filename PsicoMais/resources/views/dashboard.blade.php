<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('msg'))
                        {{ session('msg') }}
                    @else
                        <x-slot name="header">
                            <h2 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Minhas Consultas:') }}
                            </h2>
                        </x-slot>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class=" list2 flex justify-between  text-center  p-2 gap-4 ">
        <table class="list2 dark:text-white">
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
                </tr>
            </thead>
            <tbody>
                @foreach ($consults as $consult)
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
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    
</x-app-layout>
