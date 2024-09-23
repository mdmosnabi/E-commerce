@extends('layout.base')
@section('title', 'home')
@section('content')
<div class="container mx-auto p-4">
    <div class=" flex flex-wrap justify-center gap-4">
        @foreach($products as $product)
            @include('layout.core.product_card')
        @endforeach
    </div>
</div>
@endsection
