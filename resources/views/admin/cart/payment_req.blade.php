@extends('admin.base')

@section('title', 'Billing Address')

@section('content')
<div class="container mx-auto py-4">
    <h2 class="text-xl font-bold mb-4">Billing Address List</h2>

    @if($paymentReq->isEmpty())
        <p>No pending payment requests found.</p>
    @else
        <table class="table-auto w-full text-left">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Phone</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Present Address</th>
                    <th class="px-4 py-2">Permanent Address</th>
                    <th class="px-4 py-2">Payment Method</th>
                    <th class="px-4 py-2">Transaction ID</th>
                    <th class="px-4 py-2">Transaction Date</th>
                    <th class="px-4 py-2">Cart Key</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentReq as $req)
                <a href="{{ route('admin.cart.detail',['cart_key' => $req->cart_key])}}">
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.cart.detail',['cart_key' => $req->cart_key])}}" class="text-blue-500 hover:underline">{{ $req->name }}</a>
                        </td>
                        <td class="px-4 py-2">{{ $req->phone }}</td>
                        <td class="px-4 py-2">{{ $req->email }}</td>
                        <td class="px-4 py-2">{{ $req->present_address }}</td>
                        <td class="px-4 py-2">{{ $req->permanent_address }}</td>
                        <td class="px-4 py-2">{{ ucfirst($req->payment_method) }}</td>
                        <td class="px-4 py-2">{{ $req->transaction_id }}</td>
                        <td class="px-4 py-2">{{ $req->transaction_date }}</td>
                        <td class="px-4 py-2">{{ $req->cart_key }}</td>
                        <td class="px-4 py-2">
                            @if($req->is_accept)
                            <span class="text-green-500">Accepted</span>
                            @else
                            <span class="text-red-500">Pending</span>
                            @endif
                        </td>
                    </tr>
                </a>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
