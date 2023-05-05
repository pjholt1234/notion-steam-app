<x-card>
    <div class="flex">
        <div>
            <div class="flex h-[30px]">
                <select name="steam_item_id" wire:model="fields.steam_item_id" wire:change="setImageUrl" class="rounded">
                    @foreach($steamItems as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                <x-button class="flex text-sm border border-green-500 hover:bg-green-500 w-[30px] mx-1" wire:click="openSearch()">+</x-button>
            </div>

            <x-text-input
                wire:model="fields.quantity"
                :error="$errors->has('fields.quantity')"
                :errorMsg="$errors->first('fields.quantity')"
                name="quantity"
            >
                Quantity
            </x-text-input>

            <x-text-input
                wire:model="fields.sale_value"
                :error="$errors->has('fields.sale_value')"
                :errorMsg="$errors->first('fields.sale_value')"
            >
                Price
            </x-text-input>

            <x-date-input
                wire:model="fields.transaction_date"
                :error="$errors->has('fields.transaction_date')"
                :errorMsg="$errors->first('fields.transaction_date')"
            >
                Transaction date
            </x-date-input>

            <x-button class="flex text-sm border border-green-500 hover:bg-green-500 mt-2" wire:click="submit">Save Sale</x-button>
        </div>

        <div class="ml-auto w-[200px] h-[200px] flex justify-center items-center">
            @if(isset($itemImageUrl))
                <img class="w-[200px]" alt="item" src="{{$itemImageUrl}}" />
            @else
                <x-loading-icon></x-loading-icon>
            @endif
        </div>
    </div>
</x-card>
