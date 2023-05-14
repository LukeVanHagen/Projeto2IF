<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Disponibilidades') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <table class="table-auto">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Hora de fim</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($consults as $i => $consult)
                        <tr>
                            <td>{{ $consults[$i]->date }}</td>
                            <td>{{ date('H:i', strtotime($consults[$i]->time) + ($i * 3600)) }}</td>
                            <td>{{ date('H:i', strtotime($consults[$i]->time) + (($i + 1) * 3600)) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
