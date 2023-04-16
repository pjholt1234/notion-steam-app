@extends('layouts.app')
@section('title', 'Add purchase')
@section('content')
<x-card>
    <form method="POST" action="{{route('purchases.store')}}">
        @csrf
        <div class="flex flex-col">
            <label class="text-white" for="name">Name</label>
            <select name="steam_item_id">
                @foreach($steamItems as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <x-text-input
            :error="$errors->has('quantity')"
            :errorMsg="$errors->first('quantity')"
            name="quantity"
        >
            Quantity
        </x-text-input>
        <x-text-input
            name="purchase_cost"
            :error="$errors->has('purchase_cost')"
            :errorMsg="$errors->first('purchase_cost')"
        >
            Cost
        </x-text-input>

        <x-date-input
            name="transaction_date"
            :error="$errors->has('transaction_date')"
            :errorMsg="$errors->first('transaction_date')"
        >
            Transaction date
        </x-date-input>

        <x-button class="mx-0" type="submit">Create purchase</x-button>
    </form>
</x-card>

@endsection
