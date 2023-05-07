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
                wire:model="fields.purchase_cost"
                :error="$errors->has('fields.purchase_cost')"
                :errorMsg="$errors->first('fields.purchase_cost')"
            >
                Cost
            </x-text-input>

            <x-date-input
                wire:model="fields.transaction_date"
                :error="$errors->has('fields.transaction_date')"
                :errorMsg="$errors->first('fields.transaction_date')"
            >
                Transaction date
            </x-date-input>

            <div class="flex">
                <div class="w-[100px] h-[100px] flex justify-center items-center">
                    @if(isset($itemImageUrl))
                        <img class="w-[200px]" alt="item" src="{{$itemImageUrl}}" />
                    @else
                        <x-loading-icon></x-loading-icon>
                    @endif
                </div>
                <div class="my-auto ml-2 max-w-[200px]">
                    @if(isset($setItem))
                        <span class="text-white">Name: {{$setItem->name}}</span><br>
                        <span class="text-white">Current price: {{$setItem->current_price_per_unit}}</span><br>
                    @endif
                </div>
                <x-button class="ml-auto mr-0 flex text-sm border border-green-500 hover:bg-green-500 mt-2 h-[40px]" wire:click="submit">Save Purchase</x-button>
            </div>
        </div>
    </div>
</x-card>
