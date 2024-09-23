@extends('admin.base')

@section('title', 'Payment Request Details')

@section('content')
<div class="container mx-auto py-4">
    <h2 class="text-xl font-bold mb-4">Payment Request Details</h2>

    {{-- Billing Address Section --}}
    @if($billingAddress)
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Billing Address</h3>
        <table class="table-auto w-full text-left">
            <tr>
                <th class="px-4 py-2">Name</th>
                <td class="px-4 py-2">{{ $billingAddress->name }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">Phone</th>
                <td class="px-4 py-2">{{ $billingAddress->phone }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">Email</th>
                <td class="px-4 py-2">{{ $billingAddress->email }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">Present Address</th>
                <td class="px-4 py-2">{{ $billingAddress->present_address }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">Permanent Address</th>
                <td class="px-4 py-2">{{ $billingAddress->permanent_address }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">Payment Method</th>
                <td class="px-4 py-2">{{ ucfirst($billingAddress->payment_method) }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">Transaction ID</th>
                <td class="px-4 py-2">{{ $billingAddress->transaction_id }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">Transaction Date</th>
                <td class="px-4 py-2">{{ $billingAddress->transaction_date }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">Status</th>
                <td class="px-4 py-2">
                    @if($billingAddress->is_accept)
                        <span class="text-green-500">Accepted</span>
                    @else
                        <span class="text-red-500">Pending</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    @else
        <p>No billing address details available.</p>
    @endif

    {{-- Cart Section --}}
    @if($cart)
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Cart Information</h3>
        <table class="table-auto w-full text-left">
            <tr>
                <th class="px-4 py-2">Cart Key</th>
                <td class="px-4 py-2">{{ $cart->unique_key }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">User Name</th>
                <td class="px-4 py-2">{{ $cart->user_name }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">User Email</th>
                <td class="px-4 py-2">{{ $cart->user_email }}</td>
            </tr>
            <tr>
                <th class="px-4 py-2">Total</th>
                <td class="px-4 py-2">{{ $cart->total }}</td>
            </tr>
        </table>
    </div>
    @else
        <p>No cart information available.</p>
    @endif

    {{-- Cart Items Section --}}
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Cart Items</h3>
        @if($cartItem->isEmpty())
            <p>No items in the cart.</p>
        @else
        <table class="table-auto w-full text-left">
            <thead>
                <tr id='productTR' class="bg-gray-200">
                    <th class="px-4 py-2">Product ID</th>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItem as $item)
                <tr id="" class="border-b">
                    <td class="commonpid px-4 py-2">{{ $item->product_id }}</td>
                    <td class="px-4 py-2">{{ $item->name }}</td>
                    <td class="px-4 py-2">{{ $item->quantity }}</td>
                    <td id="{{ $item->product_id }}" class="px-4 py-2">
                    </td>
                    <td data-qty="{{ $item->quantity }}" id="pr{{ $item->product_id }}" class="px-4 py-2">
                    </td>
                </tr>
                @endforeach
                <tr><td></td><td></td><td></td><td></td>
                   <td id='fortotal' class="px-4 py-2"></td>
                </tr>
            </tbody>
        </table>
        @endif
    </div>

    {{-- Back Button --}}
    <div class=" flex justify-between">
        <a href="{{ route('admin.paymentReq') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Back to Payment Requests</a>
        <form action="{{ route('admin.cart.accept') }}" method="GET">
            @if($cart)
                <input type="hidden" name="cart_key" value="{{ $cart->unique_key }}">
            @else
                <p>No active cart found.</p>
            @endif
            <button type="submit" 
                class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                 Accept Payment Request</button>
        </form>
    </div>
</div>
@endsection
