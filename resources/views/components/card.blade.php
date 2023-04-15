@props([])
<div class="rounded-lg bg-neutral-700 p-6">
    @if(isset($title))
        <h5 class="mb-2 text-xl font-medium text-neutral-800 dark:text-neutral-50">
            {{$title}}
        </h5>
    @endif
    {{$slot}}
</div>
