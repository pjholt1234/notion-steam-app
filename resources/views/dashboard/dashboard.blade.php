@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="p-1">
        <x-card>
            <div class="flex mb-2">
                <h5 class="text-xl font-medium text-white">
                    Inventory
                </h5>
                <div class="flex ml-auto">
                    <x-button :href="route('purchases.create')" class="mx-2 border border-red-500 hover:bg-red-500">Add purchase</x-button>
                    <x-button :href="route('sales.create')" class="mx-2 border border-green-500 hover:bg-green-500">Add sale</x-button>
                </div>
            </div>
            <livewire:stock-item-table></livewire:stock-item-table>
        </x-card>
    </div>
@endsection
