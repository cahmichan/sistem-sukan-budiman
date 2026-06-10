<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senarai Peserta Sukan Budiman</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
        }
    </style>
</head>
<body class="bg-white text-stone-950">
    <main class="mx-auto max-w-7xl p-6">
        <div class="no-print mb-4 flex justify-end gap-3">
            <button class="kb-btn-primary" onclick="window.print()">Cetak</button>
            <a class="kb-btn-secondary" href="{{ route('admin.reports.index') }}">Kembali</a>
        </div>
        <header class="border-b border-stone-300 pb-4">
            <p class="text-sm font-semibold uppercase tracking-wide text-budiman-primary">Sukan Rakyat Kampung Budiman</p>
            <h1 class="mt-1 text-2xl font-bold">Senarai Peserta</h1>
            <p class="mt-1 text-sm text-stone-600">Dicetak pada {{ now()->format('d/m/Y h:i A') }}</p>
        </header>
        <table class="mt-5 w-full border-collapse text-left text-xs">
            <thead>
                <tr class="bg-stone-100">
                    <th class="border border-stone-300 p-2">Kod</th>
                    <th class="border border-stone-300 p-2">Nama</th>
                    <th class="border border-stone-300 p-2">Telefon</th>
                    <th class="border border-stone-300 p-2">Kategori</th>
                    <th class="border border-stone-300 p-2">Rumah</th>
                    <th class="border border-stone-300 p-2">Acara</th>
                    <th class="border border-stone-300 p-2">Status Acara</th>
                    <th class="border border-stone-300 p-2">Penjaga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($participants as $participant)
                    <tr>
                        <td class="border border-stone-300 p-2">{{ $participant->registration_code }}</td>
                        <td class="border border-stone-300 p-2">{{ $participant->name }}</td>
                        <td class="border border-stone-300 p-2">{{ $participant->phone ?? '-' }}</td>
                        <td class="border border-stone-300 p-2">{{ $participant->category }}</td>
                        <td class="border border-stone-300 p-2">{{ $participant->house?->name }}</td>
                        <td class="border border-stone-300 p-2">{{ $participant->sportRegistrations->pluck('sport.name')->filter()->join(', ') ?: '-' }}</td>
                        <td class="border border-stone-300 p-2">{{ $participant->sportRegistrations->pluck('status')->filter()->join(', ') ?: '-' }}</td>
                        <td class="border border-stone-300 p-2">{{ $participant->guardian?->name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>
