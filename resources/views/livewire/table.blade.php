<div class="p-1 overflow-x-auto overflow-y-hidden">
    <table class="min-w-full divide-y divide-gray-200 rounded-lg">
        <thead class="bg-gray-50">
        <tr>
            @foreach($this->columns() as $column)
                <x-td>
                    @if($column->isSortable)
                        <button wire:click="setSort('{{$column->column}}')">
                            {{$column->heading}}
                            @if($column->column == $this->sortColumn)
                                {{$this->getSortArrow()}}
                            @endif
                        </button>
                    @else
                        {{$column->heading}}
                    @endif
                </x-td>
            @endforeach
            @if($hasRefresh)
                <x-td>
                    <x-button wire:click="remount" class="text-gray-700 p-0">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </x-button>
                </x-td>
            @endif
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($items as $steamItem)
            <tr>
                @foreach($this->columns() as $column)
                    <x-td>{{$column->getContents($steamItem)}}</x-td>
                @endforeach
                @if($hasRefresh)
                    <x-td></x-td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="flex mt-2">
        {{$items->links('livewire.custom-pagination', ['allowedItemsPerPage' => $allowedItemsPerPage])}}
    </div>
</div>
