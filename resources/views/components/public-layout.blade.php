<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Sukan Rakyat Kampung Budiman' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-budiman-surface font-sans antialiased">
    <header class="border-b border-stone-200 bg-white">
        <div class="kb-container flex min-h-16 items-center gap-4 py-3">
            <a href="{{ route('public.landing') }}" class="flex items-center gap-3 font-bold text-budiman-secondary">
                <img src="{{ asset('images/jpkk-kampung-budiman.png') }}" alt="JPKK Kampung Budiman" class="h-10 w-auto rounded bg-white object-contain">
                <span>Sukan Rakyat<br class="sm:hidden"> Kampung Budiman</span>
            </a>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>
</body>
</html>
