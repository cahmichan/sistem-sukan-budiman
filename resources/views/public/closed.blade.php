<x-public-layout title="Pendaftaran Ditutup">
    <section class="kb-container py-12">
        <div class="mx-auto max-w-2xl">
            <div class="kb-card p-6 text-center">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-budiman-primary">Pendaftaran Ditutup</p>
                <h1 class="mt-3 text-3xl font-extrabold text-budiman-secondary">Pendaftaran peserta belum dibuka atau telah tamat</h1>
                <p class="mt-4 text-sm leading-6 text-stone-600">
                    Sila hubungi pihak urusetia jika anda memerlukan bantuan atau ingin membuat pertanyaan berkaitan pendaftaran Sukan Rakyat Kampung Budiman.
                </p>
                @if (! empty($settings['registration_deadline']))
                    <p class="mt-4 rounded-lg bg-stone-100 p-3 text-sm text-stone-700">
                        Tarikh akhir pendaftaran: {{ \Illuminate\Support\Carbon::parse($settings['registration_deadline'])->format('d/m/Y h:i A') }}
                    </p>
                @endif
                @if (! empty($settings['admin_contact']))
                    <p class="mt-3 text-sm font-semibold text-budiman-primary">Hubungi urusetia: {{ $settings['admin_contact'] }}</p>
                @endif
                <div class="mt-6 flex justify-center">
                    <a href="{{ route('public.landing') }}" class="kb-btn-primary">Kembali ke Utama</a>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
