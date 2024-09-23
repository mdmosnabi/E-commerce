@extends('admin.base')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Product Management</h1>

    <!-- Product Form -->
    <form action="{{ route('admin.product.create')}}" method="post" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
        @csrf
        @if($product)
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700" for="name">Product Name</label>
                <input value="{{ $product->name }}" type="text" name="name" placeholder="Name of product" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
                <textarea name="description" placeholder="Add description" rows="3" 
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $product->description }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="price">Price</label>
                <input value="{{ $product->price }}" name="price" type="number" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="available">Available</label>
                <input name="available" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" 
                       {{ $product->available ? 'checked' : '' }}>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="image">Product Image</label>
                <input name="image" type="file" 
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="category">Category</label>
                <select name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach($category as $item)
                    <option value="{{ $item->id }}" {{ $product->category_id == $item->id ? 'selected' : '' }}>
                        {{ $item->category }}
                    </option>
                    @endforeach
                </select>
            </div>
            <input value="{{ $product->id }}" name="id" type="hidden">
        </div>
        @else
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700" for="name">Product Name</label>
                <input type="text" name="name" placeholder="Name of product" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
                <textarea name="description" placeholder="Add description" rows="3" 
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="price">Price</label>
                <input name="price" type="number" 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="available">Available</label>
                <input name="available" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="image">Product Image</label>
                <input name="image" type="file" 
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700" for="category">Category</label>
                <select name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach($category as $item)
                    <option value="{{ $item->id }}">{{ $item->category }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        <div class="mt-6">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">Submit</button>
        </div>
    </form>
</div>
@endsection
