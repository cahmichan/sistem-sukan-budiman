<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-budiman-secondary">Audit Log</h1>
    </x-slot>

    <div class="kb-container py-6">
        <form class="kb-card grid gap-3 p-4 md:grid-cols-4">
            <select class="kb-input" name="action">
                <option value="">Semua tindakan</option>
                @foreach (['create', 'update', 'delete'] as $action)
                    <option value="{{ $action }}" @selected(request('action') === $action)>{{ ucfirst($action) }}</option>
                @endforeach
            </select>
            <select class="kb-input md:col-span-2" name="model_type">
                <option value="">Semua model</option>
                @foreach ($modelTypes as $modelType)
                    <option value="{{ $modelType }}" @selected(request('model_type') === $modelType)>{{ class_basename($modelType) }}</option>
                @endforeach
            </select>
            <button class="kb-btn-primary" type="submit">Tapis</button>
        </form>

        <div class="kb-card mt-5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-stone-100 text-stone-700">
                        <tr><th class="px-4 py-3">Masa</th><th class="px-4 py-3">Admin</th><th class="px-4 py-3">Tindakan</th><th class="px-4 py-3">Model</th><th class="px-4 py-3">IP</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr class="border-t border-stone-100">
                                <td class="px-4 py-3">{{ $log->created_at?->format('d/m/Y h:i A') }}</td>
                                <td class="px-4 py-3">{{ $log->user?->name ?? 'Sistem' }}</td>
                                <td class="px-4 py-3 font-semibold">{{ ucfirst($log->action) }}</td>
                                <td class="px-4 py-3">{{ class_basename($log->model_type) }} #{{ $log->model_id ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $log->ip_address ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td class="px-4 py-6 text-center text-stone-500" colspan="5">Tiada rekod audit.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-stone-200 p-4">{{ $logs->links() }}</div>
        </div>
    </div>
</x-app-layout>
