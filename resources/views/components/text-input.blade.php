@props([
    'name' => null,
    'error' => false,
    'errorMsg' => null,
    'placeholder' => null,
])

@php
    $defaultAttributes = ['class' => 'rounded'];

    if($attributes->has('readonly')){
        $defaultAttributes = ['class' => 'rounded bg-gray-300 text-gray-500'];
    }
@endphp

<x-field-wrapper
    :name="$name"
    :label="$slot"
    :error="$error"
    :errorMsg="$errorMsg"
>
    <input name="{{$name}}" placeholder="{{$placeholder}}" {{ $attributes->merge($defaultAttributes) }} />
</x-field-wrapper>


