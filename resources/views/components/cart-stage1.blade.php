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
                <form class="stage1-quantity">
                    @csrf
                    <label>
                        <input name="product-count" class="product-count-input" data-product-id="{{ $item->product_id }}" value="{{ $item->product_count }}" min="1" max="50" type="number">
                    </label>
                </form>
                <form class="stage1-remove">
                    @csrf
                    <button type="submit" data-product-id="{{ $item->product_id }}"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
            <span class="stage1-total">{{ $itemTotalPrice }} €</span>
        </div>
    @endforeach

    <div class="stage1-row shopping-cart-sum">
        <h5 class="stage1-title">Celková cena: </h5>
        <span class="stage1-total">{{ $totalPrice }} €</span>
    </div>
</div>

<script src="{{ asset('js/modify-cart.js') }}"></script>

