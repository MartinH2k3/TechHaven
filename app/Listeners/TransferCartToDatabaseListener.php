<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;
use App\Models\ShoppingCartProduct;
use Illuminate\Support\Facades\Auth;

class TransferCartToDatabaseListener
{
    public function handle(Login $event)
    {
        $userId = Auth::id();
        $cart = Session::get('shopping_cart', []);

        foreach ($cart as $item) {
            $cartItem = ShoppingCartProduct::updateOrCreate(
                [
                    'user_id' => $userId,
                    'product_id' => $item['product_id'],
                ],
                [
                    'product_count' => $item['product_count']
                ]
            );
        }

        Session::forget('shopping_cart'); // Clear the session cart
    }
}
