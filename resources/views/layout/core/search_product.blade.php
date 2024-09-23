@extends('layout.base')
@section('title', 'Searching Result')
@section('content')
<div class="container mx-auto mt-4">
        <h1 class="text-2xl font-bold">Search Results for "{{ $searchQuery }}"</h1>

        @if($products->isEmpty())
            <p class="mt-4">No products found matching your search criteria.</p>
        @else
        <div class="container mx-auto p-4">
            <div class=" flex flex-wrap justify-center gap-4">
                @foreach($products as $product)
                    @include('layout.core.product_card')
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection