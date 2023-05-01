
<div
    x-data="{
        loading: @entangle('loading'),
    }"
>
    <div class="flex">
        <x-text-input
            name="market_hash"
            class="w-full h-[30px] "
            placeholder="Search for steam market hash..."
            wire:model="fields.market_hash"
            :error="$errors->has('fields.market_hash')"
            :errorMsg="$errors->first('fields.market_hash')"
        ></x-text-input>
        <x-button class="text-sm border border-green-500 hover:bg-green-500 py-1 ml-2 h-[30px]" wire:click="search">Search</x-button>
    </div>

    <div x-show="loading">
        <x-loading-icon></x-loading-icon>
    </div>

    @if(count($item) > 0)
        @if($item['stored'])
            <div class="flex mt-6">
                <span class="text-white my-auto">Name: {{$item['name']}}</span>
                <img class="mr-0 ml-auto w-[200px]" alt="item" src="{{$item['image_url']}}" />
            </div>
        @else
            <div class="grid grid-cols-2 mt-3">
                <div class="my-auto">
                    <x-text-input
                        name="name"
                        class="w-full h-[30px]"
                        wire:model="item.name"
                    >Name
                    </x-text-input>
                    <x-text-input
                        name="market_hash"
                        class="w-full h-[30px]"
                        wire:model="item.market_hash"
                        readonly
                    >Market Hash
                    </x-text-input>
                </div>
                <a href="{{$item['url']}}" target="_blank"><img class="mr-0 ml-auto w-[200px]" alt="item" src="{{$item['image_url']}}" /></a>
            </div>
            <x-button class="text-sm border border-green-500 hover:bg-green-500 py-1 h-[30px]" wire:click="submit">Save</x-button>
        @endif
    @endif
</div>

