@extends('layout.base')

@section('title', 'Account')

@section('content')
<div class="bg-gradient-to-br from-blue-100 to-blue-300 flex items-center justify-center py-12">
    <div class="w-full md:w-2/3 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-8">
            <h1 class="text-3xl font-bold text-center text-gray-800">User Account</h1>

            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                @csrf
                <div class=" flex justify-center">
                    <button type="submit"
                    class=" px-20 bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Logout
                    </button>
                </div>
            </form>

            @if(Auth::check())
            <!-- User is logged in -->
            <p class="mt-6 text-center text-lg text-gray-600">Hello, <span
                    class="font-semibold text-blue-600">{{ Auth::user()->name }}</span>! You are logged in.</p>

            <!-- Display cart items if any -->
            @if($carts->count() > 0)
            <h2 class="mt-6 text-xl font-semibold text-gray-700">Your Order</h2>
            <ul class="mt-4 space-y-4">
                @foreach($carts as $cart)
                <li class=" bg-gray-50 p-4 rounded-lg shadow-sm">
                    <div>
                        <p class="font-semibold">{{ $cart->user_name }}</p>
                        <p class="text-gray-600">Email: {{ $cart->user_email }}</p>
                        <p class="text-gray-600">Created at: {{ $cart->created_at }}</p>
                        <p class="text-gray-600">Total: {{ $cart->total }}</p>
                        <button onclick="showCartItem('{{ $cart->unique_key }}',this)"
                           class=" button bg-red-500 text-gray-600">Show Details</button>

                        <div class="hidden button bg-green" id="{{ $cart->unique_key }}">
                        </div>

                        
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <p class="mt-6 text-center text-gray-600"><a href="/">You have no order. Go to shop...</a></p>
            @endif


            @else
            <!-- User is not logged in -->
            <div class="mt-6 text-center">
                <h2 class="text-lg font-semibold text-gray-700">You are not logged in.</h2>
                <p class="mt-4 text-gray-600">Please log in or register to access your account.</p>

                <div class="mt-8">
                    <a href="{{ route('login') }}"
                        class="inline-block w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="inline-block w-full bg-gray-200 text-gray-700 py-3 mt-4 rounded-lg hover:bg-gray-300 transition ease-in-out duration-200">
                        Register
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection