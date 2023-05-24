@extends('layouts.app')
@section('title', 'Add purchase')
@section('content')

<div class="flex grid grid-cols-3 h-[75%]">
    <div class="row-span-1">
        <livewire:create-purchase />
    </div>
    <div class="col-span-2 row-span-2">
        <x-card class="h-full">
            <livewire:purchase-table />
        </x-card>
    </div>
</div>

@endsection
