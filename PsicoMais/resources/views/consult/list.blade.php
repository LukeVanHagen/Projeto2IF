<x-app-layout>
    <x-slot name="header">
        <h2 class=" list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ">
            {{ __('Marcar Consulta') }}
        </h2>
    </x-slot>

            <div class=" list2 flex justify-between  text-center  p-2 gap-4 ">
                <table class="list2">
                    <thead>
                        <tr>
                            <th>Profissional</th>
                            <th>Data</th>
                            <th>Ínicio</th>
                            <th>Termino</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($consults as $consult)
                        <tr>
                            <td>{{ $users->find($consult->profissional_id)->name }}</td>
                            <td>{{ $consult->date }}</td>
                            <td>{{ date('H:i', strtotime($consult->time)) }}</td>
                            <td>{{ date('H:i', strtotime($consult->end_time)) }}</td>
                            
                            <td> <button class="btt-2" @click="showEdit = true">Marcar Consulta</button> </td>

                        </tr>
                    @endforeach
                    <template x-if="showEdit">
                                <div class="absolute top-0 bottom-0 left-0 rigth-0 bg-gray-900 bg-opacity-20 z-0 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <div class="w-96 bg-white p-4 absolute left-1/4 rigth-1/4 top-1/2 botton-1/4 z-10 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <h2 class="text-xl  font-bold text-center text-black">MARQUE AQUI ! </h2>
                                        <div class="flex justify-between mt-4">
                                                <form action="{{ route('consult.store') }}" method="POST">
                                                    @csrf
                                                   
                                                    <x-primary-button> Delete anyway </x-primary-button>
                                                </form>
                                            <x-danger-button @click=" showEdit = false ">Cancel</x-danger-botton>
                                        </div>
                                        
                                    </div>
                                </div>
                            </template>
                    </tbody>
                </table>
            </div>       
</x-app-layout>
