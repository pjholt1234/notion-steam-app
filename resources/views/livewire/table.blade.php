<div class="p-1">
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
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($items as $steamItem)
            <tr>
                @foreach($this->columns() as $column)
                    <x-td>{{$column->getContents($steamItem)}}</x-td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="flex mt-2">
        {{$items->links('livewire.custom-pagination', ['allowedItemsPerPage' => $allowedItemsPerPage])}}
    </div>
</div>
