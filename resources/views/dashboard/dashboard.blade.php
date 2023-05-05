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
            <table class="min-w-full divide-y divide-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                <tr>
                    <x-th>Item Name</x-th>
                    <x-th>Quantity</x-th>
                    <x-th>Cost</x-th>
                    <x-th>Value</x-th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($items as $item)
                        <tr>
                            <x-td>{{$item['name']}}</x-td>
                            <x-td>{{$item['quantity']}}</x-td>
                            <x-td>£{{$item['total_cost']}}</x-td>
                            <x-td>£{{$item['net_value']}}</x-td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-card>
    </div>
@endsection
