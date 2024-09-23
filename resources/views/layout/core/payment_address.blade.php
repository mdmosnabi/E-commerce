@extends('layout.base')

@section('title', 'Account')

@section('content')

<div class=" w-full md:w-2/3 lg:w-1/2 mx-auto">
    <!-- write a form for payment request -->
    <form action="{{ route('save.billing.address') }}" method="post" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg space-y-6">
        @csrf
        <h2 class="text-2xl font-semibold mb-4 text-center">Billing Address</h2>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Your name"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Your phone number"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Your email"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
        </div>

        <!-- Present Address -->
        <div>
            <label for="present_address" class="block text-sm font-medium text-gray-700">Present Address</label>
            <textarea id="present_address" name="present_address" rows="3" placeholder="Your present address"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required></textarea>
        </div>

        <!-- Permanent Address -->
        <div>
            <label for="permanent_address" class="block text-sm font-medium text-gray-700">Permanent Address</label>
            <textarea id="permanent_address" name="permanent_address" rows="3" placeholder="Your permanent address"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required></textarea>
        </div>

        <!-- Payment Method -->
        <div>
            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
            <select id="payment_method" name="payment_method"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
                <option value="" disabled selected>Select your payment method</option>
                <option value="bkash">Bkash</option>
                <option value="nagad">Nagad</option>
                <option value="roket">Roket</option>
                <option value="upai">Upai</option>
                <option value="paypal">PayPal</option>
                <option value="payoneer">Payoneer</option>
                <option value="city-bank">City Bank</option>
                <option value="other">Other</option>
            </select>
        </div>

        <!-- Payment Transaction ID -->
        <div>
            <label for="transaction_id" class="block text-sm font-medium text-gray-700">Payment Transaction ID</label>
            <input type="text" id="transaction_id" name="transaction_id" placeholder="Transaction ID"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
        </div>

        <!-- Transaction Date -->
        <div>
            <label for="transaction_date" class="block text-sm font-medium text-gray-700">Transaction Date</label>
            <input type="date" id="transaction_date" name="transaction_date"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
        </div>

        <!-- Hidden Cart Key -->
        <input type="hidden" id="cart_key" name="cart_key" value="{{ $cart_key }}">

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">Submit
                Payment</button>
        </div>
    </form>

</div>

@endsection