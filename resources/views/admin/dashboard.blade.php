@extends('admin.base')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold">Dashboard</h2>
    <p class="text-gray-600">Welcome to the admin dashboard!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card 1 -->
    <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold mb-2">All The Payment Request</h3>
        <p class="mb-4">View and manage all the payment request</p>
        <a href="{{ route('admin.paymentReq') }}" class="bg-white text-blue-500 px-4 py-2 rounded hover:bg-gray-100">Payment reuqest</a>
    </div>


    <!-- Card 3 -->
    <div class="bg-red-500 text-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold mb-2">  Here all pending order</h3>
        <p class="mb-4">lets update there stutas</p>
        <a href="{{ route('admin.pendingReq') }}" class="bg-white text-red-500 px-4 py-2 rounded hover:bg-gray-100">lets go</a>
    </div>


    <!-- Card 1 -->
    <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold mb-2"> Feature</h3>
        <p class="mb-4">about a line of Feature.</p>
        <a href="#" class="bg-white text-red-500 px-4 py-2 rounded hover:bg-gray-100">Go to  feature</a>
    </div>

    <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold mb-2">User</h3>
        <p class="mb-4">Add or Remove a user</p>
        <a href="{{ route('admin.user') }}" class="bg-white text-green-500 px-4 py-2 rounded hover:bg-gray-100">Lets go</a>
    </div>

    <div class="bg-red-500 text-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold mb-2"> Add a Category</h3>
        <p class="mb-4"> Lets Add a new Category</p>
        <a href="{{ route('admin.category') }}" class="bg-white text-red-500 px-4 py-2 rounded hover:bg-gray-100">Lets go</a>
    </div>

    <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold mb-2"> Add a new Product</h3>
        <p class="mb-4"> Let Sele a new Product.</p>
        <a href="{{ route('admin.product') }}" class="bg-white text-red-500 px-4 py-2 rounded hover:bg-gray-100">Lets go</a>
    </div>


</div>
@endsection
