<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'PsicoMais') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="../js/app.js"></script>

        <link rel="stylesheet" type="text/css" href="../css/app.css" />
        <link rel="stylesheet" type="text/css" href="../css/logopm.css"/>
    </head>
    <body>

        <div>
            @include('layouts.navigation')
            
            <!-- Page Heading -->
            @if (isset($header))
                <header class=" list 1 bg-white-100 dark:bg-gray-800 shadow">
                    <div class="list 1 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }} 

                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
                
            </main>
        </div>
    </body>
</html>

<style>
    body {
        background-image: url('/images/fundbranco.jpeg');
        background-repeat: no-repeat;
        background-size: cover;
        max-width: 100%;
        width: 100%;
        float: left;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.1);
    }
    
    </style>
