@extends('layouts.app')
@section('title', 'Add sales')
@section('content')
    <div class="flex grid grid-cols-3 h-[75%]">
        <div class="row-span-1">
            <livewire:create-sale />
        </div>
        <div class="col-span-2 row-span-2">
            <x-card class="h-full">
                <livewire:sale-table />
            </x-card>
        </div>
    </div>

@endsection
