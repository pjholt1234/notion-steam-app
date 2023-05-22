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
                    <x-button :href="route('recalculate')" class="ml-2 border border-orange-500 hover:bg-orange-500">
                        <i class="fa-solid fa-calculator"></i>
                    </x-button>
                    <x-button :href="route('purchases.create')" class="ml-2 border border-red-500 hover:bg-red-500">
                        <i class="fa-solid fa-plus"></i> Purchase
                    </x-button>
                    <x-button :href="route('sales.create')" class="ml-2 border border-green-500 hover:bg-green-500">
                        <i class="fa-solid fa-plus"></i> Sale
                    </x-button>
                </div>
            </div>
            <livewire:stock-item-table></livewire:stock-item-table>
        </x-card>
    </div>
@endsection
