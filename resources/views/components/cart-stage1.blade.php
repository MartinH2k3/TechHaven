@props(['cartItems'])

<div class="stage-container shopping-cart-container">
    <div id="stage1-labels" class="stage1-row">
        <h2 class="stage1-title">Nákupný košík</h2>
        <span class="stage1-price">Cena</span>
        <span class="stage1-quantity">Počet</span>
        <span class="stage1-total">Spolu</span>
    </div>

    @php
        $totalPrice = 0;
    @endphp

    @foreach($cartItems as $item)
        @php
            $itemTotalPrice = $item->product->price * $item->product_count;
            $totalPrice += $itemTotalPrice;
        @endphp
        <div class="stage1-row">
            <h5 class="stage1-title">{{ $item->product->product_name }}</h5>
            <span class="stage1-price">{{ $item->product->price }} €</span>
            <div class="stage1-quantity-div">
                <label class="stage1-quantity">
                    <input class="product-quantity-input" data-product-id="{{ $item->product_id }}" value="{{ $item->product_count }}" min="1" max="50" type="number">
                </label>
                <span class="stage1-remove" data-product-id="{{ $item->product_id }}"><i class="fas fa-trash-alt"></i></span>
            </div>
            <span class="stage1-total">{{ $itemTotalPrice }} €</span>
        </div>
    @endforeach

    <div class="stage1-row shopping-cart-sum">
        <span class="stage1-total">Celková cena: {{ $totalPrice }} €</span>
    </div>
</div>
