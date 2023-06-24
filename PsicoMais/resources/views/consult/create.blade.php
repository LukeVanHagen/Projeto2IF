<x-app-layout>
    <div class="disp_horario">
        <h3 class="list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Disponibilizar Horário :
        </h3>
    </div>
    <div>
        <div>
            <div class="forms_create">
                <form action="{{ route('consult.store') }}" method="POST" class="bg-white sm:max-w-md mt-6 px-6 py-4 sm:rounded-lg shadow-md">
                    @csrf

                    <div class="B_D_P">
                        <label for="day">Estarei disponível em:</label>
                        <input class="select" type="date" name="date" id="date" value="{{ $dataAtual }}" required>
                    </div>
                    <div class="B_D_P">
                        <label for="hour">às:</label>
                        <input class="select" type="time" id="time" name="time" required>
                    </div>
                    <div class="B_D_P">
                        <p>
                            <label for="period">Durante</label>
                            <input class="select" type="number" name="period" id="period" min="1" max="24" placeholder="00" required>
                            <label for="period">Horas</label>
                        </p>
                    </div>
                    <div class="B_D_P">
                        <x-primary-button>
                            {{ __('Enviar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>