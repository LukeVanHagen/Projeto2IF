<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           Disponibilizar Horário
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <form action="{{ route('consult.store') }}" method="POST">
                @csrf
                <label for="day">Estarei disponível em: </label>
                <input type="date" name="date" id="date" value="{{ $dataAtual }}" required>
                <label for="hour">ás: </label>
                <input type="time" id="time" name="time" required>
                <p><label for="period">Durante</label>
                <input type="number" name="period" id="period" min="1" max="24" placeholder="00" required>
                <label for="period">Horas</label></p>
                <x-primary-button class="ml-4">
                {{ __('Enviar') }}
                 </x-primary-button>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>
