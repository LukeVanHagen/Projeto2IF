<x-app-layout>

        <h3  class=" list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           Disponibilizar Horário:
        </h3>


    <div>
        <div>
            <div class=" forms_create ">
            <form  action="{{ route('consult.store') }}" method="POST">
                @csrf
                <label for="day">Estarei disponível em: </label>
                <input class="select" type="date" name="date" id="date" value="{{ $dataAtual }}" required>
                <label for="hour">ás: </label>
                <input class="select" type="time" id="time" name="time" required>
                <p><label for="period">Durante</label>
                <input class="select" type="number" name="period" id="period" min="1" max="24" placeholder="00" required>
                <label for="period">Horas</label></p>
                <br>
                <x-primary-button class="ml-4">
                {{ __('Enviar') }}
                 </x-primary-button>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>
