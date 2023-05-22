<div class="flex flex-col w-full">
    <div
        x-data="{
        progress: @entangle('progress')
    }"
        class="flex h-[40px] justify-center items-center"
    >
        @if($active)
            <div class="w-2/4 bg-gray-700 rounded-full h-1.5 dark:bg-gray-700 mx-auto">
                <div id="item-fetch-progress" class="bg-blue-600 h-1.5 rounded-full" x-bind:style="'width: ' + progress + '%'"></div>
            </div>
            <span class="ml-2 text-white">{{$message}}</span>
        @endif
        <x-button class="ml-auto mr-0 border border-green-500 hover:bg-green-500" wire:click="request({{$currentIndex}})">
            <i class="fa-sharp fa-solid fa-download"></i>
        </x-button>
    </div>
</div>
