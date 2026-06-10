<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold text-budiman-secondary">Rumah Sukan</h1>
            <a href="{{ route('admin.houses.create') }}" class="kb-btn-primary">Tambah Rumah</a>
        </div>
    </x-slot>
    <div class="kb-container py-6">
        @include('admin.shared.flash')
        <div class="kb-card overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-100"><tr><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Warna</th><th class="px-4 py-3">Peserta</th><th class="px-4 py-3"></th></tr></thead>
                <tbody>
                    @foreach ($houses as $house)
                        <tr class="border-t border-stone-100">
                            <td class="px-4 py-3 font-semibold">{{ $house->name }}</td>
                            <td class="px-4 py-3"><span class="inline-block h-5 w-10 rounded" style="background: {{ $house->color ?? '#15803d' }}"></span></td>
                            <td class="px-4 py-3">{{ $house->participants_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <a class="font-semibold text-budiman-primary" href="{{ route('admin.houses.edit', $house) }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t border-stone-200 p-4">{{ $houses->links() }}</div>
        </div>
    </div>
</x-app-layout>
