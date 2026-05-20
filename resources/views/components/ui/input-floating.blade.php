@props(['label', 'name', 'type' => 'text', 'value' => ''])

<div class="relative" data-aos="fade-up">
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder=" "
        {{ $attributes->merge(['class' => 'input-float peer']) }}
    />
    <label for="{{ $name }}" class="label-float peer-focus:top-2 peer-focus:text-xs peer-focus:text-brand-600 peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:text-xs dark:peer-focus:text-brand-400">{{ $label }}</label>
</div>
