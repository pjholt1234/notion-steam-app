@props([
    'label' => null,
    'name' => null,
    'error' => false,
    'errorMsg' => '',
])

<div class="flex flex-col flex-grow">
    @if(isset($label))
        <label class="text-white" for="{{$name}}">{{$label}}</label>
    @endif
    {{$slot}}
    @if($error)
        <p class="text-red-600">{{ $errorMsg }}</p>
    @endif
</div>
