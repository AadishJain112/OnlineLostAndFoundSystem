@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input-float !pt-3 !pb-3']) }}>
