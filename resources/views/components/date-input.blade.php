@props([
    'name' => null,
    'error' => false,
    'errorMsg' => '',
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
    <input type="date" name="{{$name}}" {{ $attributes->merge($defaultAttributes) }}/>
</x-field-wrapper>
