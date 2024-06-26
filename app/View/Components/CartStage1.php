<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartStage1 extends Component
{
    public mixed $cartItems;

    /**
     * Create a new component instance.
     *
     * @param  mixed  $cartItems
     * @return void
     */
    public function __construct(mixed $cartItems)
    {
        $this->cartItems = $cartItems;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-stage1');
    }
}
