<x-public-layout title="Pendaftaran Berjaya">
    <section class="kb-container py-10">
        <div class="mx-auto max-w-2xl">
            <div class="kb-card p-6 text-center">
                <p class="text-sm font-semibold uppercase tracking-wide text-green-700">Pendaftaran Berjaya</p>
                <h1 class="mt-3 text-3xl font-bold text-green-950">Terima kasih, {{ $participant->name }}</h1>
                <p class="mt-3 text-stone-600">Kod pendaftaran anda ialah:</p>
                <div class="mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-5 text-2xl font-bold tracking-wide text-green-950">{{ $participant->registration_code }}</div>
                @if ($participant->sportRegistrations->isNotEmpty())
                    @php($registration = $participant->sportRegistrations->first())
                    <div class="mt-4 rounded-lg bg-stone-100 p-4 text-left text-sm">
                        <p class="font-semibold text-stone-800">Acara: {{ $registration->sport?->name }}</p>
                        <p class="mt-1">Status acara: <span class="font-semibold">{{ $registration->status }}</span></p>
                    </div>
                @endif
                <p class="mt-5 text-sm leading-6 text-stone-600">Sila simpan kod ini untuk semakan. Jika terdapat kesilapan maklumat, hubungi pihak urusetia kerana peserta tidak boleh mengedit pendaftaran sendiri.</p>
                <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
                    <a href="{{ route('public.status', $participant->registration_code) }}" class="kb-btn-primary">Lihat Status</a>
                    <a href="{{ route('public.landing') }}" class="kb-btn-secondary">Kembali ke Utama</a>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
