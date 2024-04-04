<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ShoppingCartProduct;

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

    public function showCart(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cartItems = collect();

        if (Auth::check()) {
            // Fetch cart items from database for the logged-in user
            $userId = Auth::id();
            $cartItems = ShoppingCartProduct::with('product')
                ->where('user_id', $userId)
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

        return view('customer.cart', compact('cartItems'));
    }
}
