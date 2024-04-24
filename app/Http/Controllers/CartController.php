<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\ShoppingCartProduct;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function addToCart(Request $request): void
    {
        $productId = $request->input('product_id');
        $productCount = $request->input('product_count', 1);

        if (Auth::check()) {
            // User is logged in, add or update the cart item in the database
            $userId = Auth::id();
            $cartItem = ShoppingCartProduct::where('user_id', $userId)->where('product_id', $productId)->first();

            if ($cartItem) {
                // If found, increment the product count
                $cartItem->increment('product_count', $productCount);
            } else {
                // If not found, create a new cart item
                ShoppingCartProduct::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'product_count' => $productCount
                ]);
            }

        } else {
        // User is not logged in, handle the cart in session
            $cart = Session::get('shopping_cart', []);

            $index = array_search($productId, array_column($cart, 'product_id'));

            if ($index !== false) {
                $cart[$index]['product_count'] += $productCount;
            } else {
                $cart[] = ['product_id' => $productId, 'product_count' => $productCount];
            }

            Session::put('shopping_cart', $cart);
        }
    }

    public function updateQuantity(Request $request)
    {
        $productId = $request->product_id;
        $newQuantity = $request->product_count;

        if (Auth::check()) {
            $cartItem = ShoppingCartProduct::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();
            if ($cartItem) {
                $cartItem->update(['product_count' => $newQuantity]);
            }
        } else {
            $cart = session()->get('shopping_cart', []);
            $found = false;

            foreach ($cart as $index => $item) {
                if ($item['product_id'] == $productId) {
                    $cart[$index]['product_count'] = $newQuantity;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $cart[] = ['product_id' => $productId, 'product_count' => $newQuantity];
            }

            session()->put('shopping_cart', $cart);
        }

        return response()->json(['message' => 'Quantity updated']);
    }

    public function removeFromCart(Request $request)
    {
        $productId = $request->product_id;

        if (Auth::check()) {
            ShoppingCartProduct::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $cart = session()->get('shopping_cart', []);
            $newCart = [];

            foreach ($cart as $item) {
                if ($item['product_id'] != $productId) {
                    $newCart[] = $item;  // Only keep items that don't match the ID to remove
                }
            }

            session()->put('shopping_cart', $newCart);
        }

        return response()->json(['message' => 'Product removed']);
    }

    private function getCartItems(): Collection|\Illuminate\Support\Collection|array
    {
        $cartItems = collect();

        if (Auth::check()) {
            // Fetch cart items from database for the logged-in user
            $userId = Auth::id();
            return ShoppingCartProduct::with('product')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Fetch cart items from session for guests
            $cart = Session::get('shopping_cart', []);
            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $cartItems->push((object)[
                        'product' => $product,
                        'product_count' => $item['product_count'],
                        'product_id' => $item['product_id']
                    ]);
                }
            }
        }

        return $cartItems;
    }

    public function showCart(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cartItems = $this->getCartItems();
//        $paymentMethod = session()->get('payment_method', 'denent_method');
//        $deliveryMethod = session()->get('delivery_method');
        $paymentMethod = session()->has('payment_method') ? session()->get('payment_method', 'default_payment_method') : 'default_payment_method' ;
        $deliveryMethod = session()->has('delivery_method') ? session()->get('delivery_method') : 'default_delivery_method';


        return view('customer.cart', compact('cartItems', 'paymentMethod', 'deliveryMethod'));
    }

    public function refreshCart(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cartItems = $this->getCartItems();
        return view('components.cart-stage1', ['cartItems' => $cartItems]);
    }

    public function submitPaymentAndDelivery(Request $request): JsonResponse
    {
        // Validate the request data for payment, delivery method if enum
        $request->validate([
            'payment_method' => [
                'required',
                Rule::in(Order::PAYMENT_METHODS),
            ],
            'delivery_method' => [
                'required',
                Rule::in(Order::DELIVERY_METHODS),
            ],
        ]);

        error_log($request->input('payment_method'));
        error_log($request->input('delivery_method'));
        $paymentMethod = $request->input('payment_method');
        $deliveryMethod = $request->input('delivery_method');
        error_log($paymentMethod);
        error_log($deliveryMethod);

        session()->put('payment_method', $paymentMethod);
        session()->put('delivery_method', $deliveryMethod);

        return response()->json(['message' => 'Payment and delivery method saved.']);
    }

    public function submitAddress(Request $request): JsonResponse
    {
        $validatedDataAddress = $request->validate([
            'first_name' => 'required|string|max:64',
            'last_name' => 'required|string|max:64',
            'street_address' => 'required|string|max:100',
            'street_number' => 'required|integer',
            'city' => 'required|string|max:40',
            'post_code' => 'required|string|max:5',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
        ]);

        session()->put('delivery_details', $validatedDataAddress);

        return response()->json(['message' => 'Address saved.']);
    }
    public function createOrder(Request $request): JsonResponse
    {

        // Get the cart items
        $cartItems = $this->getCartItems();

        // Calculate the total price
        $totalPrice = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->product->price * $item->product_count);
        }, 0);

        // Create the order
        $order = Order::create([
            'id' => Str::uuid(),
            'owner_id' => Auth::check() ? Auth::id() : null,
            'status' => 'pending',
            'total_price' => $totalPrice,
            'payment_method' => session()->get('payment_method'),
            'delivery_method' => session()->get('delivery_method'),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'street_address' => $request->street_address,
            'street_number' => $request->street_number,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ]);

        // Add the cart items to the order
        foreach ($cartItems as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,//orderid sa nastavi automaticky
                'quantity' => $cartItem->product_count,
                'price' => $cartItem->product->price,
            ]);
        }


        // Clear the cart
        if (Auth::check()) {
            ShoppingCartProduct::where('user_id', Auth::id())->delete();
        } else {
            Session::forget('shopping_cart');
        }

        return response()->json(['message' => 'Order created']);
    }

}
