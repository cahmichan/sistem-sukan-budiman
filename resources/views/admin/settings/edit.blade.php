<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-green-950">Tetapan Sistem</h1>
    </x-slot>

    <div class="kb-container py-6">
        @include('admin.shared.flash')
        <form method="POST" action="{{ route('admin.settings.update') }}" class="kb-card space-y-6 p-5">
            @csrf
            @method('PUT')

            <div class="grid gap-4 sm:grid-cols-2">
                <label class="flex items-center gap-3 rounded-lg border border-stone-200 bg-stone-50 p-4 text-sm font-semibold text-stone-700">
                    <input type="checkbox" name="registration_is_open" value="1" @checked(($settings['registration_is_open'] ?? '1') === '1')>
                    Buka pendaftaran awam
                </label>
                <div>
                    <label class="kb-label" for="registration_deadline">Tarikh akhir pendaftaran</label>
                    <input class="kb-input" id="registration_deadline" name="registration_deadline" type="datetime-local" value="{{ ! empty($settings['registration_deadline']) ? \Illuminate\Support\Carbon::parse($settings['registration_deadline'])->format('Y-m-d\\TH:i') : '' }}">
                </div>
                <div>
                    <label class="kb-label" for="event_date">Tarikh acara</label>
                    <input class="kb-input" id="event_date" name="event_date" type="date" value="{{ $settings['event_date'] ?? '' }}">
                </div>
                <div>
                    <label class="kb-label" for="event_time">Masa acara</label>
                    <input class="kb-input" id="event_time" name="event_time" value="{{ $settings['event_time'] ?? '' }}" placeholder="Contoh: 8.00 pagi">
                </div>
                <div>
                    <label class="kb-label" for="event_venue">Tempat</label>
                    <input class="kb-input" id="event_venue" name="event_venue" value="{{ $settings['event_venue'] ?? '' }}">
                </div>
                <div>
                    <label class="kb-label" for="admin_contact">Nombor / kontak admin</label>
                    <input class="kb-input" id="admin_contact" name="admin_contact" value="{{ $settings['admin_contact'] ?? '' }}">
                </div>
                <div class="sm:col-span-2">
                    <label class="kb-label" for="whatsapp_template">Template WhatsApp</label>
                    <textarea class="kb-input" id="whatsapp_template" name="whatsapp_template" rows="8" required>{{ old('whatsapp_template', $settings['whatsapp_template'] ?? '') }}</textarea>
                    <p class="mt-2 text-xs text-stone-500">Placeholder: [Nama], [Rumah], [Tarikh], [Masa], [Lokasi]</p>
                </div>
            </div>

            <div class="flex justify-end border-t border-stone-200 pt-5">
                <button class="kb-btn-primary" type="submit">Simpan Tetapan</button>
            </div>
        </form>
    </div>
</x-app-layout>
