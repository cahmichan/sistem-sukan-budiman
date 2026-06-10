@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-budiman-primary focus:ring-budiman-primary rounded-md shadow-sm']) }}>
