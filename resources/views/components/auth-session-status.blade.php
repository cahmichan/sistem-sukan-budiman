@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-budiman-primary']) }}>
        {{ $status }}
    </div>
@endif
