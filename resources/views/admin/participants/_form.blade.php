@php
    $isEdit = $participant->exists;
@endphp

@csrf
@if ($isEdit)
    @method('PUT')
@endif

<div class="grid gap-4 sm:grid-cols-2" x-data="{ age: '{{ old('age', $participant->age) }}', category() { return Number(this.age) > 0 && Number(this.age) < {{ \App\Models\Participant::CHILD_AGE_THRESHOLD }} ? 'Kanak-Kanak' : (Number(this.age) >= {{ \App\Models\Participant::CHILD_AGE_THRESHOLD }} ? 'Dewasa' : 'Ditentukan melalui umur') } }">
    <div class="sm:col-span-2">
        <label class="kb-label" for="name">Nama peserta</label>
        <input class="kb-input" id="name" name="name" value="{{ old('name', $participant->name) }}" required>
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="kb-label" for="age">Umur</label>
        <input class="kb-input" id="age" name="age" type="number" min="1" max="120" x-model="age" value="{{ old('age', $participant->age) }}" required>
        @error('age') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="kb-label" for="phone">Nombor telefon</label>
        <input class="kb-input" id="phone" name="phone" value="{{ old('phone', $participant->phone) }}" required>
        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="kb-label">Kategori</label>
        <div class="rounded-lg border border-stone-200 bg-stone-100 px-3 py-2 text-sm font-semibold text-green-900" x-text="category()"></div>
        <p class="mt-1 text-xs text-stone-500">Kategori dikira automatik daripada umur.</p>
    </div>
    <div>
        <label class="kb-label" for="house_id">Rumah sukan</label>
        <select class="kb-input" id="house_id" name="house_id" required>
            <option value="">Pilih rumah</option>
            @foreach ($houses as $house)
                <option value="{{ $house->id }}" @selected(old('house_id', $participant->house_id) == $house->id)>{{ $house->name }}</option>
            @endforeach
        </select>
        @error('house_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="kb-label" for="status">Status peserta</label>
        <select class="kb-input" id="status" name="status" required>
            @foreach (['Aktif', 'Dibatalkan'] as $status)
                <option value="{{ $status }}" @selected(old('status', $participant->status ?: 'Aktif') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="sm:col-span-2">
        <label class="kb-label" for="sport_id">Acara sukan</label>
        <select class="kb-input" id="sport_id" name="sport_id">
            <option value="">Tiada acara</option>
            @foreach ($sports as $sport)
                <option value="{{ $sport->id }}" @selected(old('sport_id', $selectedRegistration?->sport_id) == $sport->id) x-bind:disabled="category() !== 'Ditentukan melalui umur' && ! ['Terbuka', category()].includes('{{ $sport->category }}')">
                    {{ $sport->name }} - {{ $sport->category }} ({{ $sport->is_active ? $sport->availabilityLabel() : 'Tidak Aktif' }})
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-stone-500">Pilihan acara dikawal oleh kategori umur. Acara Terbuka dibenarkan untuk semua peserta.</p>
        @error('sport_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div class="sm:col-span-2">
        <label class="kb-label" for="sport_status">Status acara</label>
        <select class="kb-input" id="sport_status" name="sport_status">
            @foreach (['Menunggu', 'Diterima', 'Ditolak', 'Senarai Menunggu', 'Dibatalkan'] as $status)
                <option value="{{ $status }}" @selected(old('sport_status', $selectedRegistration?->status ?: 'Menunggu') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        @error('sport_status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2 rounded-lg border border-amber-200 bg-amber-50 p-4" x-show="Number(age) > 0 && Number(age) < {{ \App\Models\Participant::CHILD_AGE_THRESHOLD }}">
        <h2 class="font-semibold text-amber-950">Maklumat Penjaga</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="kb-label" for="guardian_name">Nama penjaga</label>
                <input class="kb-input" id="guardian_name" name="guardian_name" value="{{ old('guardian_name', $participant->guardian?->name) }}">
                @error('guardian_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="kb-label" for="guardian_phone">Telefon penjaga</label>
                <input class="kb-input" id="guardian_phone" name="guardian_phone" value="{{ old('guardian_phone', $participant->guardian?->phone) }}">
                @error('guardian_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="kb-label" for="guardian_relationship">Hubungan</label>
                <input class="kb-input" id="guardian_relationship" name="guardian_relationship" value="{{ old('guardian_relationship', $participant->guardian?->relationship) }}">
                @error('guardian_relationship') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <div class="sm:col-span-2">
        <label class="kb-label" for="notes">Catatan</label>
        <textarea class="kb-input" id="notes" name="notes" rows="3">{{ old('notes', $participant->notes) }}</textarea>
    </div>
</div>

<div class="mt-6 flex justify-end gap-3 border-t border-stone-200 pt-5">
    <a href="{{ route('admin.participants.index') }}" class="kb-btn-secondary">Batal</a>
    <button class="kb-btn-primary" type="submit">Simpan</button>
</div>
