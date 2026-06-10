<x-public-layout title="Semak Pendaftaran">
    <section class="kb-container py-12">
        <div class="mx-auto max-w-xl">
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-budiman-primary">Semakan Peserta</p>
            <h1 class="mt-2 text-3xl font-extrabold text-budiman-secondary">Semak Pendaftaran</h1>
            <p class="mt-2 text-sm text-stone-600">Masukkan kod pendaftaran atau nombor telefon peserta.</p>
            <form method="POST" action="{{ route('public.lookup') }}" class="kb-card mt-6 space-y-4 p-5">
                @csrf
                <div>
                    <label class="kb-label" for="search">Kod pendaftaran / nombor telefon</label>
                    <input class="kb-input" id="search" name="search" value="{{ old('search') }}" required>
                    @error('search') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <button class="kb-btn-primary w-full" type="submit">Semak</button>
            </form>
        </div>
    </section>
</x-public-layout>
