@props([
    'success' => true,
    'onEvent' => false,
])

@php
    $defaultAttributes = ['class' => 'absolute h-[60px] inset-0 m-2 p-2 cursor-pointer rounded flex items-center text-white'];
@endphp
<div {{$attributes->merge($defaultAttributes)}}
     x-data="{ show: false, onEvent: {{json_encode($onEvent)}}, message: '', success: true}"
     x-bind:class="{ 'bg-green-500': success,  'bg-red-500': !success }"
     x-init="
        if(!onEvent){
            show = true
            setTimeout(() => show = false, 3000);
            success = {{json_encode($success)}};
        }
     "
     @alert.window ="
        show = true
        setTimeout(() => show = false, 3000)
        message = $event.detail.message;
        success = $event.detail.success;
    "

     x-show="show"
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-90"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-90"
>
    @if($onEvent)
        <span x-text="message"></span>
    @else
        {{$slot}}
    @endif
</div>
