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
    <button id="addCart" onclick="addCart('{{$product->id}}',this)"
        class=" bg-blue-500 hover:bg-red-500 my-2 text-black px-1 rounded">
        Add to Cart
    </button>
</div>