<x-app-layout>

<div>
    <div>
        <div>
            <div>

  
        <h3 class=" list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Marcar Consulta') }} 
        </h3>

    

            
     <div class="c-conteiner">
                    
                    @php
                        $consults = $sortedConsults;
                    @endphp
                        @foreach ($consults as $consult)
                        @if($consult->paciente_id == null)
         <div class="card">
            <div class="c-body">
               <div class="consulta">
                <label class="label-consul">Profissional:</label>
                <div class="consulta-name">{{ $users->find($consult->profissional_id)->name }}</div>
               </div>
               <div class="consulta">
                <label class="label-consul">Data:</label>
                <div class="consulta-name">{{ date('d-m-Y', strtotime($consult->date)) }}</div>
               </div>
               <div class="consulta">
               <label class="label-consul">Início:</label>
                <div class="consulta-name">{{ date('H:i', strtotime($consult->date)) }}</div>
               </div>
               <div class="consulta">
               <label class="label-consul">Término:</label>
                <div class="consulta-name">{{ date('H:i', strtotime($consult->end_time)) }}</div>
               </div>
               <div class="consulta">
                <div class="consulta-botao">
                    <form action="{{ route('consult.mark', $consult->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                        <x-primary-button type="submit">Marcar Consulta</x-primary-button>
                    </form>
                </div>
               </div>
            </div>
        </div>
                            @endif
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
                </div>    
            </div>  
        </div>
    </div>
</div>

</x-app-layout>
