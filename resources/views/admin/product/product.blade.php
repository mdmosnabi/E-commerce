@extends('admin.base')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Product Management</h1>

    <!-- Create New Product Button -->
    <div class="mt-4">
        <a href="{{ route('admin.product.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add New Product</a>
    </div>

    <!-- Display All Products -->
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Stock</th>
                <th class="px-4 py-2">Category</th>
                <th class="px-4 py-2">Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($product as $prod)
            <tr>
                <td class="border px-4 py-2">{{ $prod->id }}</td>
                <td class="border px-4 py-2">{{ $prod->name }}</td>
                <td class="border px-4 py-2">{{ $prod->price }}</td>
                <td class="border px-4 py-2">{{ $prod->description }}</td>
                <td class="border px-4 py-2">{{ $prod->available }}</td>
                <td class="border px-4 py-2">{{ $prod->category }}</td>
                <td class="border px-4 py-2">{{ $prod->image }}</td>
                <td class="border px-4 py-2">
                    <!-- Delete Button -->
                    <form action="{{ route('admin.product.create') }}" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="{{$prod->id}}">
                        <button type="submit" class=" bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Edit</button>
                    </form>

                    <form action="{{ route('admin.product.create') }}" method="post" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{$prod->id}}">
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    
</div>
@endsection
