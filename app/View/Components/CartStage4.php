<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartStage4 extends Component
{
    public mixed $cartItems;
    public string $paymentMethod;
    public string $deliveryMethod;

    /**
     * Create a new component instance.
     * @param mixed $cartItems
     * @param string $paymentMethod
     * @param string $deliveryMethod
     */
    public function __construct(mixed $cartItems, string $paymentMethod, string $deliveryMethod)
    {
        $this->cartItems = $cartItems;
        $this->paymentMethod = $paymentMethod;
        $this->deliveryMethod = $deliveryMethod;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-stage4');
    }
}
