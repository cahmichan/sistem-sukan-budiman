<x-public-layout title="Sukan Rakyat Kampung Budiman">
    <section class="relative isolate min-h-[calc(100svh-72px)] overflow-hidden bg-budiman-secondary text-white">
        <img src="{{ asset('images/kampung-budiman-hero.jpg') }}" alt="Kampung Budiman" class="absolute inset-0 h-full w-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-budiman-secondary/82 to-black/30"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/45"></div>
        <div class="kb-container relative flex min-h-[calc(100svh-72px)] items-center py-14">
            <div class="max-w-2xl [text-shadow:_0_2px_16px_rgb(0_0_0_/_0.72)]">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-white/90">Sukan SULAM Kampung Budiman</p>
                <h1 class="mt-4 text-4xl font-extrabold leading-tight sm:text-6xl">Sukan Rakyat Kampung Budiman</h1>
                <p class="mt-5 max-w-xl text-base leading-8 text-white sm:text-lg">Daftar acara sukan komuniti, semak status pendaftaran, dan simpan kod unik untuk urusan urusetia pada hari program.</p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    @if ($registrationIsOpen)
                        <a href="{{ route('public.register') }}" class="kb-btn-primary bg-white text-budiman-primary hover:bg-budiman-cream">Daftar Peserta</a>
                    @else
                        <span class="inline-flex items-center justify-center rounded-full bg-white/85 px-5 py-2.5 text-sm font-semibold text-stone-700">Pendaftaran Ditutup</span>
                    @endif
                    <a href="{{ route('public.check') }}" class="kb-btn-secondary border-white/35 bg-white/10 text-white hover:bg-white/20">Semak Pendaftaran</a>
                </div>

                <div class="mt-10 grid gap-6 border-t border-white/25 pt-6 text-sm sm:grid-cols-3">
                    <div>
                        <p class="text-white/60">Tarikh</p>
                        <p class="mt-1 font-bold">{{ ! empty($settings['event_date']) ? \Illuminate\Support\Carbon::parse($settings['event_date'])->format('d/m/Y') : 'Akan dimaklumkan' }}</p>
                    </div>
                    <div>
                        <p class="text-white/60">Masa</p>
                        <p class="mt-1 font-bold">{{ $settings['event_time'] ?? 'Akan dimaklumkan' }}</p>
                    </div>
                    <div>
                        <p class="text-white/60">Tempat</p>
                        <p class="mt-1 font-bold">{{ $settings['event_venue'] ?? 'Kampung Budiman' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-12">
        <div class="kb-container grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-budiman-primary">Aliran Pendaftaran</p>
                <h2 class="mt-2 text-3xl font-extrabold text-budiman-secondary">Mudah untuk peserta, tersusun untuk urusetia</h2>
                <p class="mt-3 text-sm leading-6 text-stone-600">Pendaftaran awam kekal ringkas, sementara acara, kapasiti, dan senarai menunggu dikawal oleh sistem.</p>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div class="border-t-4 border-budiman-primary bg-budiman-surface p-5">
                    <p class="text-sm font-bold text-budiman-primary">01</p>
                    <p class="mt-3 font-bold text-stone-950">Isi Borang</p>
                    <p class="mt-2 text-sm leading-6 text-stone-600">Masukkan maklumat peserta, rumah sukan dan acara pilihan.</p>
                </div>
                <div class="border-t-4 border-budiman-primary bg-budiman-surface p-5">
                    <p class="text-sm font-bold text-budiman-primary">02</p>
                    <p class="mt-3 font-bold text-stone-950">Simpan Kod</p>
                    <p class="mt-2 text-sm leading-6 text-stone-600">Kod unik dipaparkan selepas pendaftaran berjaya.</p>
                </div>
                <div class="border-t-4 border-budiman-primary bg-budiman-surface p-5">
                    <p class="text-sm font-bold text-budiman-primary">03</p>
                    <p class="mt-3 font-bold text-stone-950">Semak Status</p>
                    <p class="mt-2 text-sm leading-6 text-stone-600">Peserta boleh menyemak acara dan status pendaftaran.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-budiman-surface py-12">
        <div class="kb-container">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.16em] text-budiman-primary">Acara Sukan</p>
                    <h2 class="mt-2 text-3xl font-extrabold text-budiman-secondary">Pilihan acara yang tersedia</h2>
                </div>
                <a href="{{ route('public.register') }}" class="font-semibold text-budiman-primary hover:text-budiman-accent">Daftar sekarang</a>
            </div>
            <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($sports as $sport)
                    <div class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-bold text-budiman-secondary">{{ $sport->name }}</p>
                                <p class="mt-1 text-sm text-stone-600">{{ $sport->category }} - {{ $sport->duration_minutes ?? '-' }} minit</p>
                            </div>
                            <span class="rounded-full bg-budiman-cream px-3 py-1 text-xs font-bold text-budiman-primary">{{ $sport->availabilityLabel() }}</span>
                        </div>
                        <p class="mt-4 border-t border-stone-100 pt-3 text-xs text-stone-500">Kapasiti: {{ $sport->max_players_per_group ? $sport->max_players_per_group.' peserta/kumpulan' : 'Tiada had' }}</p>
                    </div>
                @empty
                    <div class="kb-card p-5 text-sm text-stone-600">Belum ada acara aktif.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-budiman-footer py-12 text-white">
        <div class="kb-container grid gap-8 md:grid-cols-[0.8fr_1.2fr] md:items-center">
            <div>
                <img src="{{ asset('images/jpkk-kampung-budiman.png') }}" alt="JPKK Kampung Budiman" class="h-14 w-auto rounded bg-white object-contain p-1">
                <p class="mt-4 max-w-lg text-sm leading-6 text-white/80">Sistem pendaftaran ini menyokong acara komuniti Kampung Budiman dengan semakan status, kategori automatik dan laporan urusetia.</p>
            </div>
            <div class="grid gap-4 text-sm sm:grid-cols-3">
                <div>
                    <p class="font-bold">Acara aktif</p>
                    <p class="mt-2 text-3xl font-extrabold">{{ $sports->count() }}</p>
                </div>
                <div>
                    <p class="font-bold">Rumah sukan</p>
                    <p class="mt-2 text-3xl font-extrabold">{{ $houses->count() }}</p>
                </div>
                <div>
                    <p class="font-bold">Status</p>
                    <p class="mt-2 text-3xl font-extrabold">{{ $registrationIsOpen ? 'Buka' : 'Tutup' }}</p>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
