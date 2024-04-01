<?php

namespace App\Http\Controllers;

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
}
