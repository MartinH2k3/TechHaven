@props(['cartItems', 'paymentMethod', 'deliveryMethod'])
<!--Include the alert component.-->
@include('components.alert')
<div class="stage-content shopping-cart-container">
    <form class="summary-form" action="{{ route('cart.summary.order.submit') }}" method="POST">
        @csrf
        <div class="stage4-header-row stage4-row">
            <h2 class="stage4-title">Nákupný košík</h2>
            <span class="stage4-quantity">Počet</span>
            <span class="stage4-total">Cena</span>
        </div>
        @php
            $totalPrice = 0;
        @endphp

        @foreach($cartItems as $item)
            @php
                $itemTotalPrice = $item->product->price * $item->product_count;
                $totalPrice += $itemTotalPrice;
            @endphp
        <div class="stage4-row">
            <h5 class="stage4-title">{{ $item->product->product_name }}</h5>
            <span class="stage4-quantity">{{ $item->product_count }}</span>
            <span class="stage4-total">{{ $itemTotalPrice }} €</span>
        </div>
        @endforeach

        <div class="stage4-header-row stage4-row">
            <h2 class="stage4-title">Platba</h2>
        </div>
        <div class="stage4-row stage4-last-entry">
            <span class="stage4-method">{{ $paymentMethod }}</span>
            <span class="stage4-total">Zadarmo</span>
        </div>
        <div class="stage4-header-row stage4-row">
            <h2 class="stage4-title">Doprava</h2>
        </div>
        <div class="stage4-row stage4-last-entry">
            <span class="stage4-method">{{ $deliveryMethod }}</span>
            <span class="stage4-total">Zadarmo</span>
        </div>
        <div class="stage4-header-row stage4-last-entry stage4-row">
            <h2 class="stage4-title">Spolu</h2>
            <span class="stage4-total">{{ $totalPrice }} €</span>
        </div>
        <button type="submit" id="order-button">Objednať</button>
    </form>

</div>
