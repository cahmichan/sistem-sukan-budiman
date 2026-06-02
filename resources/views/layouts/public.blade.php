<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Sukan Rakyat Kampung Budiman' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-50 font-sans antialiased">
    <header class="border-b border-stone-200 bg-white">
        <div class="kb-container flex min-h-16 items-center gap-4 py-3">
            <a href="{{ route('public.landing') }}" class="flex items-center gap-3 font-bold text-green-950">
                <span class="grid h-10 w-10 place-items-center rounded-lg bg-green-800 text-white">SB</span>
                <span>Sukan Rakyat<br class="sm:hidden"> Kampung Budiman</span>
            </a>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>
</body>
</html>
