@props([
    'name' => null,
    'error' => false,
    'errorMsg' => '',
])

<x-field-wrapper
    :name="$name"
    :label="$slot"
    :error="$error"
    :errorMsg="$errorMsg"
>
    <input type="date" name="{{$name}}"/>
</x-field-wrapper>
