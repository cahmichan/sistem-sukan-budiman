<x-public-layout title="Sukan Rakyat Kampung Budiman">
    <section class="bg-green-950 text-white">
        <div class="kb-container grid gap-8 py-14 md:grid-cols-[1.15fr_0.85fr] md:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-amber-200">Sukan SULAM Kampung Budiman</p>
                <h1 class="mt-3 max-w-3xl text-4xl font-bold leading-tight sm:text-5xl">Sistem Pendaftaran Peserta Sukan Rakyat Kampung Budiman</h1>
                <p class="mt-4 max-w-2xl text-base leading-7 text-green-50">Daftar sebagai peserta melalui borang ringkas ini. Selepas hantar, anda akan menerima kod pendaftaran unik untuk semakan status.</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('public.register') }}" class="kb-btn-primary bg-amber-400 text-green-950 hover:bg-amber-300">Daftar Peserta</a>
                    <a href="{{ route('public.check') }}" class="kb-btn-secondary border-green-100 bg-white/10 text-white hover:bg-white/20">Semak Pendaftaran</a>
                </div>
            </div>
            <div class="rounded-lg border border-green-800 bg-green-900/70 p-6">
                <p class="text-lg font-semibold text-amber-100">Makluman Peserta</p>
                <ul class="mt-4 space-y-3 text-sm leading-6 text-green-50">
                    <li>Peserta awam tidak perlu log masuk.</li>
                    <li>Maklumat tidak boleh diedit sendiri selepas dihantar.</li>
                    <li>Jika ada kesilapan, sila hubungi pihak urusetia.</li>
                    <li>Peserta kanak-kanak perlu maklumat penjaga.</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="kb-container py-10">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="kb-card p-5">
                <p class="font-semibold text-green-900">1. Isi Borang</p>
                <p class="mt-2 text-sm text-stone-600">Lengkapkan nama, umur, telefon, rumah sukan dan acara pilihan.</p>
            </div>
            <div class="kb-card p-5">
                <p class="font-semibold text-green-900">2. Terima Kod</p>
                <p class="mt-2 text-sm text-stone-600">Simpan kod pendaftaran untuk semakan kemudian.</p>
            </div>
            <div class="kb-card p-5">
                <p class="font-semibold text-green-900">3. Hadir Awal</p>
                <p class="mt-2 text-sm text-stone-600">Urusetia akan mengurus senarai dan pengesahan peserta.</p>
            </div>
        </div>
    </section>
</x-public-layout>
