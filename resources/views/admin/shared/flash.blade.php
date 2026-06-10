@if (session('success'))
    <div class="mb-4 rounded-lg border border-budiman-primary/20 bg-budiman-cream p-3 text-sm font-semibold text-budiman-primary">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm font-semibold text-red-800">{{ session('error') }}</div>
@endif
