@php
    $defaultAttributes = ['class' => 'p-4 whitespace-nowrap']
@endphp

<td {{ $attributes->merge($defaultAttributes) }}>
    {{$slot}}
</td>
