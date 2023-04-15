@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="p-1">
        <x-card>
            <div class="flex">
                <h5 class="text-xl font-medium text-white">
                    All registered steam items
                </h5>
                <x-button class="ml-auto mr-0">Add Item</x-button>
            </div>
            <table class="min-w-full divide-y divide-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Item name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Quantity
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Value
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        John Doe
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        johndoe@example.com
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Admin
                    </td>
                </tr>
                </tbody>
            </table>




{{--        @foreach($steamItems as $steamItem)--}}
{{--                {{$steamItem}}<br>--}}
{{--            @endforeach--}}
        </x-card>
    </div>
@endsection
