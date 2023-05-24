<x-modal id="modal" class="h-[300px] w-[600px]" :title="$title">
    <div>
        @if(isset($content))
            <livewire:dynamic-component wire:key="$content" :component="$content" :params="$params"></livewire:dynamic-component>
        @endif
    </div>
</x-modal>
