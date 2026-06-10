<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-bold text-budiman-secondary">Edit Rumah Sukan</h1></x-slot>
    <div class="kb-container py-6">
        <form method="POST" action="{{ route('admin.houses.update', $house) }}" class="kb-card p-5">@include('admin.houses._form')</form>
        <form method="POST" action="{{ route('admin.houses.destroy', $house) }}" class="mt-4" onsubmit="return confirm('Padam rumah sukan ini?')">
            @csrf @method('DELETE')
            <button class="text-sm font-semibold text-red-700" type="submit">Padam rumah sukan</button>
        </form>
    </div>
</x-app-layout>
