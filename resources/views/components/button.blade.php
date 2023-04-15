@props([
    'href' => null
])

@php
    $tag = $tag ?? ($href ? 'a' : 'button');
    $defaultAttributes = ['class' => 'bg-transparent hover:bg-blue-500 text-white font-semibold p-2 border border-blue-500 hover:border-transparent rounded'];

    $href === null
    ? $defaultAttributes['type'] = 'button'
    : $defaultAttributes['href'] = $href;

@endphp
<{{$tag}} {{ $attributes->merge($defaultAttributes) }} >
    {{$slot}}
</{{$tag}}>
