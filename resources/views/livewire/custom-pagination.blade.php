<div>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        <span>
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <x-button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="">
                    {!! __('pagination.previous') !!}
                </x-button>
            @endif
        </span>

        <select wire:model="itemsPerPage" class="rounded w-[50px]">
            @foreach($allowedItemsPerPage as $item)
                <option class="flex" value="{{$item}}">{{$item}}</option>
            @endforeach
        </select>

        <span>
            {{-- Next Page Link --}}
            @if($paginator->hasMorePages())
                <x-button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="">
                    {!! __('pagination.next') !!}
                </x-button>
            @endif
        </span>
    </nav>
</div>
