<x-public-layout title="Daftar Peserta">
    <section class="kb-container py-8">
        <div class="mx-auto max-w-3xl">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-green-950">Daftar Peserta</h1>
                <p class="mt-2 text-sm text-stone-600">Sila pastikan maklumat tepat sebelum dihantar. Peserta tidak boleh mengedit maklumat selepas pendaftaran.</p>
            </div>

            <form method="POST" action="{{ route('public.register.store') }}" class="kb-card space-y-6 p-5 sm:p-6" x-data="{ age: '{{ old('age') }}', category() { return Number(this.age) > 0 && Number(this.age) < {{ $childAgeThreshold }} ? 'Kanak-Kanak' : (Number(this.age) >= {{ $childAgeThreshold }} ? 'Dewasa' : 'Ditentukan melalui umur') } }">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="kb-label" for="name">Nama peserta</label>
                        <input class="kb-input" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="kb-label" for="age">Umur</label>
                        <input class="kb-input" id="age" name="age" type="number" min="1" max="120" x-model="age" value="{{ old('age') }}" required>
                        @error('age') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="kb-label" for="phone">Nombor telefon</label>
                        <input class="kb-input" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 0123456789" required>
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="kb-label">Kategori peserta</label>
                        <div class="rounded-lg border border-stone-200 bg-stone-100 px-3 py-2 text-sm font-semibold text-green-900" x-text="category()"></div>
                        <p class="mt-1 text-xs text-stone-500">Kategori ditentukan secara automatik berdasarkan umur.</p>
                    </div>
                    <div>
                        <label class="kb-label" for="house_id">Rumah sukan</label>
                        <select class="kb-input" id="house_id" name="house_id" required>
                            <option value="">Pilih rumah sukan</option>
                            @foreach ($houses as $house)
                                <option value="{{ $house->id }}" @selected(old('house_id') == $house->id)>{{ $house->name }}</option>
                            @endforeach
                        </select>
                        @error('house_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="kb-label" for="sport_id">Acara pilihan</label>
                        <select class="kb-input" id="sport_id" name="sport_id" required>
                            <option value="">Pilih acara</option>
                            @foreach ($sports as $sport)
                                <option value="{{ $sport->id }}" @selected(old('sport_id') == $sport->id) x-bind:disabled="category() !== 'Ditentukan melalui umur' && ! ['Terbuka', category()].includes('{{ $sport->category }}')">
                                    {{ $sport->name }} - {{ $sport->category }} ({{ $sport->availabilityLabel() }})
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-stone-500">Acara Dewasa/Kanak-Kanak akan dipadankan mengikut umur. Acara Terbuka boleh disertai semua peserta. Jika acara penuh, pendaftaran anda akan dimasukkan ke Senarai Menunggu.</p>
                        @error('sport_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4" x-show="Number(age) > 0 && Number(age) < {{ $childAgeThreshold }}">
                    <h2 class="font-semibold text-amber-950">Maklumat Penjaga</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="kb-label" for="guardian_name">Nama penjaga</label>
                            <input class="kb-input" id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}">
                            @error('guardian_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="kb-label" for="guardian_phone">Nombor telefon penjaga</label>
                            <input class="kb-input" id="guardian_phone" name="guardian_phone" value="{{ old('guardian_phone') }}">
                            @error('guardian_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="kb-label" for="guardian_relationship">Hubungan</label>
                            <select class="kb-input" id="guardian_relationship" name="guardian_relationship">
                                <option value="">Pilih hubungan</option>
                                @foreach (['Ibu', 'Bapa', 'Penjaga', 'Lain-lain'] as $relationship)
                                    <option value="{{ $relationship }}" @selected(old('guardian_relationship') === $relationship)>{{ $relationship }}</option>
                                @endforeach
                            </select>
                            @error('guardian_relationship') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3 border-t border-stone-200 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('public.landing') }}" class="kb-btn-secondary">Kembali</a>
                    <button class="kb-btn-primary" type="submit">Hantar Pendaftaran</button>
                </div>
            </form>
        </div>
    </section>
</x-public-layout>
