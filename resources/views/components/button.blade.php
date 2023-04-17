@props([
    'href' => null
])

@php
    $tag = $tag ?? ($href ? 'a' : 'button');
    $defaultAttributes = ['class' => 'bg-transparent text-white font-semibold p-2 hover:border-transparent rounded justify-center items-center'];

    $href === null
    ? $defaultAttributes['type'] = 'button'
    : $defaultAttributes['href'] = $href;

@endphp
<{{$tag}} {{ $attributes->merge($defaultAttributes) }} >
    {{$slot}}
</{{$tag}}>
