@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-budiman-primary text-sm font-medium leading-5 text-budiman-primary focus:outline-none focus:border-budiman-accent transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-budiman-primary hover:border-budiman-primary/40 focus:outline-none focus:text-budiman-primary focus:border-budiman-primary/40 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
