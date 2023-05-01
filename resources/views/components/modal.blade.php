@props([
    'title' => null,
])
@php
    $defaultAttributes = ['class' => 'overflow-hidden'];
@endphp
<div
    {{$attributes->except('class')}}
    x-data="{show: true}"
    x-show="show"
    x-init="
      eventName = $el.id+'-toggle';
      window.addEventListener(eventName, event => show = !show);
    "
    class="fixed inset-0 z-50 overflow-y-auto"
>
    <div class="flex items-center justify-center min-h-screen bg-gray-500 bg-opacity-50">
        <x-card {{$attributes->except('id')->merge($defaultAttributes)}} >
            <div class="text-white mb-4 flex">
                @if(isset($title))
                    <h2 class="text-xl font-bold">{{ $title }}</h2>
                @endif
                    <x-button class="flex text-sm border border-red-500 hover:bg-red-500 w-[30px] mr-0 ml-auto" @click="show = false">X</x-button>
            </div>
            <div>
                {{ $slot }}
            </div>
        </x-card>
    </div>
</div>
