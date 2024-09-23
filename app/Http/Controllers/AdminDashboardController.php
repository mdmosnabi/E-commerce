<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\BillingAddress;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;

class AdminDashboardController extends Controller
{
    // Show the dashboard view
    public function index()
    {
        return view('admin.dashboard');
    }

    public function serveAdminJs()
    {
        // You can return a JavaScript file securely here
        return response()->view('admin.js.admin_scripts')->header('Content-Type', 'application/javascript');
    }

    // product controll

    public function product(Request $request){
        $product = Product::all();
        return view('admin.product.product' , compact('product'));
    }

    public function productAdd(Request $request)
    {
        $category = Category::all();

        if ($request->isMethod('post')) {
            // Validate input
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'category' => 'required', // Ensure the category exists
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
            ]);

            // Check if the request contains an ID (for update)
            if ($request->input('id')) {
                // Update the existing product
                $product = Product::find($request->input('id'));

                if ($product) {
                    // Update product fields
                    $product->name = $request->input('name');
                    $product->description = $request->input('description');
                    $product->price = $request->input('price');
                    $product->available = $request->has('available') ? 1 : 0;
                    $product->category = $request->input('category');
                    $product->updated_at = now();

                    // Handle file upload for the image
                    if ($request->hasFile('image')) {
                        // Delete the old image if it exists
                        if ($product->image && file_exists(public_path('uploads/images/' . $product->image))) {
                            unlink(public_path('uploads/images/' . $product->image));
                        }

                        // Get the uploaded file and generate a unique name
                        $file = $request->file('image');
                        $filename ='images/'.uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/images'), $filename);

                        // Update the product's image field
                        $product->image = $filename;
                    }

                    $product->save(); // Save updated product
                } else {
                    return redirect()->route('admin.product')->withErrors('Product not found.');
                }
            } else {
                // Create a new product
                $product = new Product();
                $product->name = $request->input('name');
                $product->description = $request->input('description');
                $product->price = $request->input('price');
                $product->available = $request->has('available') ? 1 : 0;
                $product->category = $request->input('category');

                // Handle file upload for the image
                if ($request->hasFile('image')) {
                    // Get the uploaded file and generate a unique name
                    $file = $request->file('image');
                    $filename ='images/'.uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/images'), $filename);

                    // Save the image path in the database
                    $product->image = $filename;
                }

                $product->save(); // Save the new product
            }

            return redirect()->route('admin.product');
        } elseif ($request->isMethod('delete')) {
            // Delete the product
            $product = Product::find($request->input('id'));

            if ($product) {
                // Optional: Delete the image from storage
                if ($product->image && file_exists(public_path('uploads/images/' . $product->image))) {
                    unlink(public_path('uploads/images/' . $product->image));
                }

                $product->delete();
            }

            return redirect()->route('admin.product');
        } elseif ($request->isMethod('get') && $request->input('id')) {
            // Find the product by ID for editing
            $product = Product::find($request->input('id'));
            return view('admin.product.product_form', ['product' => $product, 'category' => $category]);
        }

        // Show the form for new product creation
        return view('admin.product.product_form', ['product' => null, 'category' => $category]);
    }



    // User controll  
    public function user(Request $request){
        $user = User::all();
        return view('admin.user.user' , compact('user'));
    }

    public function userEdit(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'nullable',
            ]);
            // Update existing user
            if ($request->input('id')) {
                $user = User::find($request->input('id'));
                if ($user) {
                    $user->name = $request->input('name'); // Corrected to update the user's name
                    $user->email = $request->input('email');
                    if ($request->input('password')) {
                        $user->password = Hash::make($request->input('password')); // Correct Hash::make usage
                    }
                    $user->save();
                }
                return redirect()->route('admin.user');
            }
            // Create new user
            else {
                $user = new User();
                $user->name = $request->input('name'); // Set user name properly during creation
                $user->email = $request->input('email');
                if ($request->input('password')) {
                    $user->password = Hash::make($request->input('password')); // Hash the password during creation
                }
                $user->save();
                return redirect()->route('admin.user');
            }
        }
        elseif ($request->isMethod('delete')) {
            // Delete user
            $user = User::find($request->input('id'));
            if ($user) {
                $user->delete();
            }
            return redirect()->route('admin.user');
        }
        elseif ($request->isMethod('get') && $request->input('id')) {
            // Edit user - show the form with user data
            $user = User::find($request->input('id'));
            return view('admin.user.user_form', compact('user'));
        }

        // For new user creation - empty user object
        $user = null;
        return view('admin.user.user_form', compact('user'));
    }

    //  controll Category
    public function category(Request $request){
        $category = Category::all();
        return view('admin.category.category' , compact('category'));
    }

    public function categoryEdit(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'category' => 'required|string|max:255',
            ]);

            // Update existing category
            if ($request->input('id')) {
                $category = Category::find($request->input('id'));
                if ($category) {
                    $category->category = $request->input('category');
                    $category->save();
                }
                return redirect()->route('admin.category');
            }
            // Create new category
            else {
                $category = new Category();
                $category->category = $request->input('category');
                $category->save();
                return redirect()->route('admin.category');
            }
        }
        elseif ($request->isMethod('delete')) {
            // Delete category
            $category = Category::find($request->input('id'));
            if ($category) {
                $category->delete();
            }
            return redirect()->route('admin.category');
        }
        elseif ($request->isMethod('get') && $request->input('id')) {
            // Edit category - show the form with category data
            $category = Category::find($request->input('id'));
            return view('admin.category.category_form', compact('category'));
        }

        // For new category creation - empty category object
        $category = null;
        return view('admin.category.category_form', compact('category'));
    }


    public function paymentReq(){
        $paymentReq = BillingAddress::where('is_accept',0)->paginate(10);
        return view('admin.cart.payment_req',compact('paymentReq'));
    }
    public function pendingReq(){
        $paymentReq = BillingAddress::where('is_accept',1)->get();
        return view('admin.cart.payment_req',compact('paymentReq'));
    }

    public function paymentReqDetail($cart_key){
        // Fetch the BillingAddress where cart_key matches
        $BillingAddress = BillingAddress::where('cart_key', $cart_key)->first();
        
        // Fetch the Cart where cart_key matches
        $Cart = Cart::where('unique_key', $cart_key)->first();
        
        // Fetch all CartItems that match the cart_key
        $CartItem = CartItem::where('cart_key', $cart_key)->get();
    
        // Return the view with all the data
        return view('admin.cart.detail', [
            'billingAddress' => $BillingAddress,
            'cart' => $Cart,
            'cartItem' => $CartItem,
        ]);
    }

    public function detailProduct(Request $request) {
        // Check if the request method is POST
        if ($request->isMethod('post')) {
            // Retrieve the array of product IDs from the request
            $productIds = $request->input('products'); // 'products' is the key from the frontend
    
            // Fetch the products that match the given product IDs
            $products = Product::whereIn('id', $productIds)->get(); // Assuming 'id' is the field for product IDs
    
            // Return the products in a JSON response
            return response()->json($products);
        } else {
            // If it's not a POST request, return an error or appropriate response
            return response()->json(['error' => 'Invalid request method'], 405); // 405 Method Not Allowed
        }
    }

    public function PreqAccept(Request $request)
    {
        // Check if cart_key is passed as a query parameter
        if ($request->input('cart_key')) {
            // Find the billing address by the cart key
            $billingAddress = BillingAddress::where('cart_key', $request->input('cart_key'))->first();

            if ($billingAddress) {
                // Update the is_accept field and save
                $billingAddress->is_accept = 1;
                $billingAddress->save();
                
                // Redirect to the admin payment request route
                return redirect()->route('admin.paymentReq')->with('success', 'Payment request accepted successfully.');
            }

            // Billing address not found
            return redirect()->back()->with('error', 'Billing address not found.');
        }

        // cart_key not provided in the request
        return redirect()->back()->with('error', 'Invalid request, cart_key is required.');
    }

    public function categoryAdd(Request $request){
        $category = null ;
        return view('admin.category.category_form' ,compact('category'));
    }

}
