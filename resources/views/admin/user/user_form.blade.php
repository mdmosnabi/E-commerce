@extends('admin.base')

@section('title', 'User Control')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-md">
    <h1 class="text-2xl font-bold mb-6">{{ isset($user) ? 'Edit User' : 'Create User' }}</h1>

    <form action="{{ route('admin.user.edit') }}" method="POST">
        @csrf
        
        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="{{ old('name', $user->name ?? '') }}" 
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                required
            >
        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="{{ old('email', $user->email ?? '') }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                required
            >
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input 
                type="password"
                name="password" 
                id="password" 
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                placeholder="{{ isset($user) ? 'Leave blank if not changing' : 'Enter password' }}"
            >
        </div>
        @if($user)
        <input type="hidden" name="id" value="{{ $user->id }}">
        @endif

        <!-- Submit Button -->
        <div class="flex items-center justify-between">
            <button 
                type="submit" 
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
                {{ isset($user) ? 'Update User' : 'Create User' }}
            </button>
        </div>
    </form>
</div>

@endsection
