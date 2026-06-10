<!DOCTYPE html>
<html lang="ms">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sukan Budiman') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex min-h-screen flex-col items-center bg-budiman-surface pt-6 sm:justify-center sm:pt-0">
            <div>
                <a href="/" class="flex items-center gap-3 text-xl font-bold text-budiman-secondary">
                    <img src="{{ asset('images/jpkk-kampung-budiman.png') }}" alt="JPKK Kampung Budiman" class="h-12 w-auto rounded bg-white object-contain">
                    <span>Sukan Budiman</span>
                </a>
            </div>

            <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
