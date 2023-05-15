<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Horários Disponíveis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <table class="table-auto">
                    <thead>
                        <tr>
                            <th>Profissional</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Hora de fim</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($consults as $consult)
                        <tr>
                            <td>{{ $users->find($consult->profissional_id)->name }}</td>
                            <td>{{ $consult->date }}</td>
                            <td>{{ date('H:i', strtotime($consult->time)) }}</td>
                            <td>{{ date('H:i', strtotime($consult->end_time)) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
