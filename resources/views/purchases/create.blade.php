@extends('layouts.app')
@section('title', 'Add purchase')
@section('content')
<x-modal id="add-item-modal" class="h-[300px] w-[600px]" title="Add Steam Item">
    <livewire:create-steam-item />
</x-modal>

<div class="grid grid-cols-2">
    <livewire:create-purchase />
</div>

@endsection
