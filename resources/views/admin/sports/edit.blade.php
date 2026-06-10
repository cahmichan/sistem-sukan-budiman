<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-bold text-budiman-secondary">Edit Acara</h1></x-slot>
    <div class="kb-container py-6">
        <form method="POST" action="{{ route('admin.sports.update', $sport) }}" class="kb-card p-5">@include('admin.sports._form')</form>
        <form method="POST" action="{{ route('admin.sports.destroy', $sport) }}" class="mt-4" onsubmit="return confirm('Padam acara ini?')">
            @csrf @method('DELETE')
            <button class="text-sm font-semibold text-red-700" type="submit">Padam acara</button>
        </form>
    </div>
</x-app-layout>
