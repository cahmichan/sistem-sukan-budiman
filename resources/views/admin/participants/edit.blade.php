<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-bold text-budiman-secondary">Edit Peserta</h1></x-slot>
    <div class="kb-container py-6">
        <form method="POST" action="{{ route('admin.participants.update', $participant) }}" class="kb-card p-5">
            @include('admin.participants._form')
        </form>
    </div>
</x-app-layout>
