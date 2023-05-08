@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="p-1">
        <x-card>
            <div class="flex mb-2 h-[40px]">
                <h5 class="text-xl font-medium text-white">
                    Inventory
                </h5>
                <livewire:request-data></livewire:request-data>
                <div class="flex">
                    <x-button :href="route('purchases.create')" class="ml-2 border border-red-500 hover:bg-red-500">Add purchase</x-button>
                    <x-button :href="route('sales.create')" class="ml-2 border border-green-500 hover:bg-green-500">Add sale</x-button>
                </div>
            </div>
            <livewire:stock-item-table></livewire:stock-item-table>
        </x-card>
    </div>
@endsection
