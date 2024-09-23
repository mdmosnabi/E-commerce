<div class="container mx-auto p-4">
    @if($products->isEmpty())
    <p>Your cart is empty.</p>
    @else
    <div class=" flex flex-wrap justify-center gap-4">
        @foreach($products as $product)
        <div class="bg-white w-52 border rounded-lg shadow-md p-4">
            <a href="{{ route('product.detail', $product->id) }}">
                <img src="http://127.0.0.1:8000/uploads/{{ $product->image }}" alt="{{ $product->name }}"
                    class="w-48 h-48 object-contain rounded-md mb-4">

                <h2 class="text-xl font-bold mb-2">{{ $product->name }}</h2>
                <p class="text-gray-600 mb-2 text-wrap">{{ $product->description }}</p>
                <p class="text-green-500 font-semibold mb-2">${{ number_format($product->price, 2) }}</p>
                <p class="text-sm {{ $product->available ? 'text-green-500' : 'text-red-500' }}">
                    {{ $product->available ? 'Available' : 'Out of Stock' }}
                </p>

            </a>
            <div class=" flex justify-around flex-wrap">
                <input class="" type="number" value='1'>
                <button onclick="removeCartItem('2')" class=" bg-gray-400 hover:bg-gray-700 text-white p-1 rounded-lg">Remove</button>
            </div>
            <a href=""></a>
        </div>
        @endforeach
    </div>
    <div class="flex justify-around flex-wrap">
        <div class=" p-2 bg-purple-400  text-blue-400">Total:100</div>
        <button class=" p-2 rounded-lg hover:bg-yellow-400 text-red-400">Make a order</button>
    </div>
    @endif
</div>