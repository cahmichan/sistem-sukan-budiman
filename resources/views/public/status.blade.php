<x-public-layout title="Status Pendaftaran">
    <section class="kb-container py-10">
        <div class="mx-auto max-w-3xl">
            <h1 class="text-3xl font-bold text-green-950">Status Pendaftaran</h1>
            <p class="mt-2 text-sm text-stone-600">Keputusan semakan untuk: <span class="font-semibold">{{ $search }}</span></p>

            <div class="mt-6 space-y-4">
                @forelse ($participants as $participant)
                    <div class="kb-card p-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="text-xl font-bold text-green-950">{{ $participant->name }}</p>
                                <p class="text-sm text-stone-600">{{ $participant->registration_code }}</p>
                            </div>
                            <span class="w-fit rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800">{{ $participant->status }}</span>
                        </div>
                        <dl class="mt-5 grid gap-3 text-sm sm:grid-cols-2">
                            <div><dt class="font-semibold text-stone-700">Umur</dt><dd>{{ $participant->age }}</dd></div>
                            <div><dt class="font-semibold text-stone-700">Kategori</dt><dd>{{ $participant->category }}</dd></div>
                            <div><dt class="font-semibold text-stone-700">Rumah Sukan</dt><dd>{{ $participant->house?->name }}</dd></div>
                            <div>
                                <dt class="font-semibold text-stone-700">Acara</dt>
                                <dd>
                                    @forelse ($participant->sportRegistrations as $registration)
                                        <span>{{ $registration->sport?->name }} ({{ $registration->status }})</span>
                                    @empty
                                        Belum dipilih
                                    @endforelse
                                </dd>
                            </div>
                        </dl>
                        <p class="mt-5 rounded-lg bg-amber-50 p-3 text-sm text-amber-900">Untuk pembetulan maklumat, sila hubungi urusetia. Tiada fungsi edit untuk peserta awam.</p>
                    </div>
                @empty
                    <div class="kb-card p-5 text-stone-600">Tiada rekod dijumpai.</div>
                @endforelse
            </div>
        </div>
    </section>
</x-public-layout>
