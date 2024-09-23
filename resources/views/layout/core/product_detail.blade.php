@extends('layout.base')
@section('title', 'product detail')
@section('content')
    <div class=" w-full md:w-1/2 mx-auto my-10">
        <div  class=" bg-white shadow-md rounded-lg p-6">
            <!-- Product Image -->
            <div class="mb-6">
                <img src="http://127.0.0.1:8000/uploads/{{ $product->image }}" alt="{{ $product->name }}" class=" w-full md:w-1/2 object-contain h-auto rounded">
            </div>

            <!-- Product Name -->
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

            <!-- Product Price -->
            <p class="text-xl text-green-500 mb-4">Price: ${{ number_format($product->price, 2) }}</p>

            <!-- Product Description -->
            <p class="text-gray-700 mb-4">
                {{ $product->description }}
            </p>

            <!-- Product Availability -->
            @if ($product->available)
                <p class="text-sm text-green-600 font-semibold">In Stock</p>
            @else
                <p class="text-sm text-red-600 font-semibold">Out of Stock</p>
            @endif

            <div class="text-sm text-green-600 font-semibold"> Update : {{$product->updated_at}}</div>
            <!-- Add to Cart Button (optional) -->
            <div class="mt-4">
                <button id="addCart" onclick="addCart('{{$product->id}}',this)" class=" bg-blue-500 hover:bg-red-500 text-black font-bold py-2 px-4 rounded">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
@endsection
