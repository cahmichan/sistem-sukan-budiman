<x-public-layout title="Status Pendaftaran">
    <section class="kb-container py-10">
        <div class="mx-auto max-w-3xl">
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-budiman-primary">Status Peserta</p>
            <h1 class="mt-2 text-3xl font-extrabold text-budiman-secondary">Status Pendaftaran</h1>
            <p class="mt-2 text-sm text-stone-600">Keputusan semakan untuk: <span class="font-semibold">{{ $search }}</span></p>

            <div class="mt-6 space-y-4">
                @forelse ($participants as $participant)
                    <div class="kb-card p-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-xl font-bold text-budiman-secondary">{{ $participant->name }}</p>
                                <p class="text-sm text-stone-600">{{ $participant->registration_code }}</p>
                            </div>
                            <span class="w-fit rounded-full bg-budiman-cream px-3 py-1 text-sm font-semibold text-budiman-primary">{{ $participant->status }}</span>
                        </div>
                        <dl class="mt-5 grid gap-3 text-sm sm:grid-cols-2">
                            <div><dt class="font-semibold text-stone-700">Umur</dt><dd>{{ $participant->age }}</dd></div>
                            <div><dt class="font-semibold text-stone-700">Kategori</dt><dd>{{ $participant->category }}</dd></div>
                            <div><dt class="font-semibold text-stone-700">Rumah Sukan</dt><dd>{{ $participant->house?->name }}</dd></div>
                            <div>
                                <dt class="font-semibold text-stone-700">Acara</dt>
                                <dd class="space-y-1">
                                    @forelse ($participant->sportRegistrations as $registration)
                                        <div>{{ $registration->sport?->name }} ({{ $registration->status }})</div>
                                    @empty
                                        Belum dipilih
                                    @endforelse
                                </dd>
                            </div>
                        </dl>
                        <p class="mt-5 rounded-xl bg-budiman-cream p-3 text-sm text-budiman-primary">Untuk pembetulan maklumat, sila hubungi urusetia. Tiada fungsi edit untuk peserta awam.</p>
                    </div>
                @empty
                    <div class="kb-card p-5 text-stone-600">Tiada rekod dijumpai.</div>
                @endforelse
            </div>
        </div>
    </section>
</x-public-layout>
