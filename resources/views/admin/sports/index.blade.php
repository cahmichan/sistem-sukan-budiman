<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold text-budiman-secondary">Acara Sukan</h1>
            <a href="{{ route('admin.sports.create') }}" class="kb-btn-primary">Tambah Acara</a>
        </div>
    </x-slot>
    <div class="kb-container py-6">
        @include('admin.shared.flash')
        <div class="kb-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-stone-100"><tr><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Kapasiti</th><th class="px-4 py-3">Diterima</th><th class="px-4 py-3">Menunggu</th><th class="px-4 py-3">Status</th><th></th></tr></thead>
                    <tbody>
                        @foreach ($sports as $sport)
                            <tr class="border-t border-stone-100">
                                <td class="px-4 py-3 font-semibold">{{ $sport->name }}</td>
                                <td class="px-4 py-3">{{ $sport->category }}</td>
                                <td class="px-4 py-3">{{ $sport->max_players_per_group ?: 'Tiada had' }}</td>
                                <td class="px-4 py-3">{{ $sport->accepted_registrations_count }}</td>
                                <td class="px-4 py-3">{{ $sport->waiting_list_registrations_count }}</td>
                                <td class="px-4 py-3">{{ $sport->is_active ? $sport->availabilityLabel() : 'Tidak Aktif' }}</td>
                                <td class="px-4 py-3 text-right"><a class="font-semibold text-budiman-primary" href="{{ route('admin.sports.edit', $sport) }}">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-stone-200 p-4">{{ $sports->links() }}</div>
        </div>
    </div>
</x-app-layout>
