@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-white-400 dark:border-white-600 text-sm font-medium leading-5 text-white-900 dark:text-white-100 focus:outline-none focus:border-white-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white-500 dark:text-white-400 hover:text-white-200 dark:hover:text-white-300 hover:border-white-300 dark:hover:border-white-700 focus:outline-none focus:text-white-700 dark:focus:text-white-300 focus:border-white-300 dark:focus:border-white-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
