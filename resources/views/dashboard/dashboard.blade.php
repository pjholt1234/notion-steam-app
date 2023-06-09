@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="p-1">
        <x-card>
            <div class="flex mb-2 h-[40px]">
                <h5 class="text-xl font-medium text-white">
                    Inventory
                </h5>
                <livewire:progress-bar></livewire:progress-bar>
                <div class="flex mr-0 ml-auto">
                    <livewire:request-steam-item-data></livewire:request-steam-item-data>
                    <livewire:push-notion-data></livewire:push-notion-data>
                    <x-button :href="route('dashboard.recalculate')" class="flex ml-2 border border-blue-500 hover:bg-blue-500 w-[40px]">
                        <i class="fa-solid fa-calculator"></i>
                    </x-button>
                    <x-button :href="route('purchases.create')" class="flex ml-2 border border-red-500 hover:bg-red-500">
                        <i class="fa-solid fa-circle-plus"></i>&nbsp;Purchase
                    </x-button>
                    <x-button :href="route('sales.create')" class="flex ml-2 border border-green-500 hover:bg-green-500">
                        <i class="fa-solid fa-circle-plus"></i>&nbsp;Sale
                    </x-button>
                </div>
            </div>
            <livewire:stock-item-table></livewire:stock-item-table>
        </x-card>
    </div>
@endsection
