<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold text-green-950">{{ $participant->name }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.participants.edit', $participant) }}" class="kb-btn-primary">Edit</a>
                <form method="POST" action="{{ route('admin.participants.destroy', $participant) }}" onsubmit="return confirm('Padam rekod peserta ini?')">
                    @csrf @method('DELETE')
                    <button class="kb-btn-secondary" type="submit">Padam</button>
                </form>
            </div>
        </div>
    </x-slot>
    <div class="kb-container py-6">
        @include('admin.shared.flash')
        <div class="grid gap-6 lg:grid-cols-[1fr_0.8fr]">
            <div class="kb-card p-5">
                <h2 class="font-bold text-green-950">Butiran Peserta</h2>
                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div><dt class="text-sm font-semibold text-stone-500">Kod</dt><dd>{{ $participant->registration_code }}</dd></div>
                    <div><dt class="text-sm font-semibold text-stone-500">Status</dt><dd>{{ $participant->status }}</dd></div>
                    <div><dt class="text-sm font-semibold text-stone-500">Telefon</dt><dd>{{ $participant->phone }}</dd></div>
                    <div><dt class="text-sm font-semibold text-stone-500">Umur</dt><dd>{{ $participant->age }}</dd></div>
                    <div><dt class="text-sm font-semibold text-stone-500">Kategori</dt><dd>{{ $participant->category }}</dd></div>
                    <div><dt class="text-sm font-semibold text-stone-500">Rumah</dt><dd>{{ $participant->house?->name }}</dd></div>
                </dl>
                @if ($participant->notes)
                    <p class="mt-4 rounded-lg bg-stone-100 p-3 text-sm">{{ $participant->notes }}</p>
                @endif
            </div>
            <div class="kb-card p-5">
                <h2 class="font-bold text-green-950">Penjaga & Acara</h2>
                <div class="mt-4 space-y-4 text-sm">
                    <div>
                        <p class="font-semibold text-stone-700">Penjaga</p>
                        <p>{{ $participant->guardian?->name ?? 'Tiada' }}</p>
                        @if ($participant->guardian)
                            <p>{{ $participant->guardian->phone }} - {{ $participant->guardian->relationship }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-stone-700">Acara</p>
                        <ul class="mt-2 space-y-2">
                            @forelse ($participant->sportRegistrations as $registration)
                                <li class="rounded-lg bg-stone-100 p-3">{{ $registration->sport?->name }} <span class="text-stone-500">({{ $registration->status }})</span></li>
                            @empty
                                <li>Belum ada acara.</li>
                            @endforelse
                        </ul>
                    </div>
                    @php
                        $settings = \App\Models\Setting::allAsArray();
                        $message = $settings['whatsapp_template'] ?? '';
                        $message = str_replace(
                            ['[Nama]', '[Rumah]', '[Tarikh]', '[Masa]', '[Lokasi]'],
                            [$participant->name, $participant->house?->name ?? '-', $settings['event_date'] ?? '-', $settings['event_time'] ?? '-', $settings['event_venue'] ?? '-'],
                            $message
                        );
                    @endphp
                    <a class="kb-btn-secondary w-full" target="_blank" href="https://wa.me/60{{ preg_replace('/\D/', '', ltrim($participant->phone, '0')) }}?text={{ urlencode($message) }}">Buka WhatsApp Peringatan</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
