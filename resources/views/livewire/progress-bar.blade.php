<div
    x-data="{
        progress: @entangle('progress')
    }"
    class="w-full flex h-[40px] justify-center items-center"
>
    @if($active)
        <div class="w-2/4 bg-gray-700 rounded-full h-1.5 dark:bg-gray-700">
            <div class="bg-blue-600 h-1.5 rounded-full" x-bind:style="'width: ' + progress + '%'"></div>
        </div>
        <span class="ml-2 text-white">{{$message}}</span>
    @endif
</div>
