<?php
namespace App\Http\Controllers;

// laravel import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

// model import
use App\Models\BillingAddress;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;



class CoreController extends Controller
{
    public function home(Request $request)
    {
        $products = Product::all();
        return view('layout.core.home', ['products' => $products]);
    }
    public function detail($id) {
        $product = Product::findOrFail($id);
        return view('layout.core.product_detail', compact('product'));
    }

    public function account()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Retrieve all carts for the authenticated user's email
            $carts = Cart::where('user_email', $user->email)->get(); // Use `get()` to retrieve multiple carts
            
            // Retrieve cart items (if needed) for each cart
            // You can retrieve related CartItem objects, but this is optional
            // $cartItems = $carts->isNotEmpty() ? CartItem::whereIn('cart_key', $carts->pluck('key'))->with('product')->get() : collect();
            $cartItems = collect();
            
            return view('auth.account', [
                'carts' => $carts,         // Pass the carts as a collection
                'cartItems' => $cartItems  // Pass the related cart items
            ])->with('success', 'Order placed successfully!');
        } else {
            return redirect()->route('login')->with('message', 'Please log in to view your account.');
        }
    }



    public function cart($id){
        echo'nothing';
        return ;
    }

    public function category($id) {
        if ($id == 1) {
            $products = Product::where('category', 'food')->get();
        } 
        else if ($id == 2) {
            $products = Product::where('category', 'toy')->get();
        } 
        else if ($id == 3) {
            $products = Product::where('category', 'motor cycle')->get();
        } 
        else {
            $products = collect(); // Return an empty collection if no category matches
        }
    
        return view('layout.core.home', ['products' => $products]);
    }

    public function getCartItems(Request $request)
    {
        // Retrieve the cartItems from the request
        $cartItems = $request->input('cartItems', []);

        // Fetch the products based on the given cartItems
        $products = Product::whereIn('id', $cartItems)->get();

        // Return the view with the product list
        return response()->json($products);
    }

    public function generateCustomKey($length = 15) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';  // All alphabet characters
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }

    public function makeOrder(Request $request)
    {
        // Retrieve the currently authenticated user
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to place an order.');
        }

        // Validate the incoming data (ensure it's an array of items with id and quantity)
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:product,id', // Ensure product ID exists
            'items.*.quantity' => 'required|integer|min:1',         // Quantity should be at least 1
            'items.*.name' => 'required' ,
        ]);

        // Generate a unique key for the cart
        $uniqueKey =$this->generateCustomKey();

        // Create a new Cart record for the user
        $cart = Cart::create([
            'user_name' => $user->name,
            'user_email' => $user->email,
            'unique_key' => $uniqueKey,
        ]);

        $total = 0;
        // Loop through the items and create CartItem records
        foreach ($request->items as $item) {
            CartItem::create([
                'cart_key' => $cart->unique_key,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'name' => $item['name'],
            ]);
            $product = Product::where('id',$item['id'])->first();
            $total += $product->price*$item['quantity'];
        }
        if ($total > 0) {
            $cart->total = $total;
            $cart->save();
        }

        // Example of fetching cart items through the relationship:
        $cartItems = $cart->cartItems;

        // Redirect to the account page after order creation
        return redirect()->route('account');
    }
    
    public function getCartItem($cart_key)
    {
        // Fetch the cart items based on the cart key
        $cartItems = CartItem::where('cart_key', $cart_key)->get();
        $paymentAddress = BillingAddress::where('cart_key', $cart_key)->first();

        // Prepare the response data
        $response = [
            'cart_items' => $cartItems,
            'billing_address' => $paymentAddress ? $paymentAddress : null
        ];

        // Return the response as JSON
        return response()->json($response);
    }

    public function deleteCart($cart_key)
    {
        // Wrap the delete operations in a transaction
        DB::beginTransaction();

        try {
            // Find the Cart by cart_key
            $cart = Cart::where('unique_key', $cart_key)->first();

            if ($cart) {
                // Delete all associated CartItem records in a single query
                CartItem::where('cart_key', $cart_key)->delete();

                // Check if any BillingAddress records exist before deleting
                BillingAddress::where('cart_key', $cart_key)->delete();

                // Delete the Cart record
                $cart->delete();

                // Commit the transaction after successful deletion
                DB::commit();

                // Add a success message
                session()->flash('success', 'Cart and associated items deleted successfully.');
            } else {
                // Rollback transaction if Cart not found
                DB::rollBack();
                
                // Handle the case where the Cart is not found
                session()->flash('error', 'Cart not found.');
            }
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollBack();
            
            // Log the error for debugging
            \Log::error('Error deleting cart: ' . $e->getMessage());

            // Flash an error message to the session
            session()->flash('error', 'An error occurred while deleting the cart.');
        }

        // Redirect to the account route
        return redirect()->route('account');
    }


    public function payAddress($cart_key){
        return view('layout.core.payment_address',['cart_key'=>$cart_key]);
    }

    public function saveBillingAddress(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'present_address' => 'required|string',
            'permanent_address' => 'required|string',
            'payment_method' => 'required|string',
            'transaction_id' => 'required|string',
            'transaction_date' => 'required|date',
            'cart_key' => 'required|string',
        ]);

        // Try to find an existing BillingAddress by cart_key
        $billingAddress = BillingAddress::where('cart_key', $request->cart_key)->first();

        if ($billingAddress) {
            // If a BillingAddress exists, update it
            $billingAddress->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'present_address' => $request->present_address,
                'permanent_address' => $request->permanent_address,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'transaction_date' => $request->transaction_date,
            ]);

            // Redirect back with a success message
            return redirect()->route('account')->with('success', 'Billing Address Created Successfully');
        } else {
            // If no BillingAddress exists, create a new one
            BillingAddress::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'present_address' => $request->present_address,
                'permanent_address' => $request->permanent_address,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'transaction_date' => $request->transaction_date,
                'cart_key' => $request->cart_key,
            ]);

            // Redirect back with a success message
            return redirect()->route('account')->with('success', 'Billing Address Created Successfully');
        }
    }


    public function contact(){
        return view('chat.contact');
    }

    public function search(Request $request)
    {
        // Validate the search query
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        // Get the search query from the request
        $searchQuery = $request->input('query');

        // Search for products where the name or description matches the query
        $products = Product::where('name', 'like', '%' . $searchQuery . '%')
            ->orWhere('description', 'like', '%' . $searchQuery . '%')
            ->get();

        // Return the search results to the view
        return view('layout.core.search_product', compact('products', 'searchQuery'));
    }

    
}