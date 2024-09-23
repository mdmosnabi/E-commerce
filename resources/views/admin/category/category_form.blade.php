@extends('admin.base')

@section('title', 'Category Management')

@section('content')
<div class="container mx-auto py-4">
    <h2 class="text-xl font-bold mb-4">
        {{ isset($category) ? 'Edit Category' : 'Create New Category' }}
    </h2>

    <!-- Display form for adding or editing a category -->
    <form action="{{ route('admin.category.edit') }}" method="post">
        @csrf
        <div class="mb-4">
            <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category Name</label>
            <input 
                type="text" 
                name="category" 
                id="category" 
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="{{ old('category', isset($category) ? $category->category : '') }}" 
                required
            >
            @error('category')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <!-- Hidden input for the category ID when editing -->
        @if(isset($category))
            <input type="hidden" name="id" value="{{ $category->id }}">
        @endif

        <!-- Submit button -->
        <div class="flex items-center justify-between">
            <button 
                type="submit" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
                {{ isset($category) ? 'Update Category' : 'Create Category' }}
            </button>
        </div>
    </form>

</div>
@endsection
