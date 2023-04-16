@props([
    'name' => null,
    'error' => false,
    'errorMsg' => null,
])

@php
    $defaultAttributes = [];
@endphp

<x-field-wrapper
    :name="$name"
    :label="$slot"
    :error="$error"
    :errorMsg="$errorMsg"
>
    <input name="{{$name}}" {{ $attributes->merge($defaultAttributes) }} />
</x-field-wrapper>


