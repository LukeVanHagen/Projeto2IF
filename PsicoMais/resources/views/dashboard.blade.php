<x-app-layout>
   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                @if(session('msg'))
                    {{ session('msg') }}
                @else
                <x-slot name="header">
                    <h2 class=" list1 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ">
                        {{ __('Minhas Consultas :') }}
                    </h2>
                </x-slot>
                @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
