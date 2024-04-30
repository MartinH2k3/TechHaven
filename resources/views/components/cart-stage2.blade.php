<div class="stage-container shopping-cart-container">
    <form class="cart-form" action="{{ route('cart.paymentDelivery.submit') }}" method="POST">
        @csrf
        <h2 class="stage2-header">Platba</h2>
        <div class="payment-method">
            <input type="radio" name="payment_method" value="Google Pay" id="stage2-google-pay" checked>
            <label for="stage2-google-pay">Google Pay</label>
        </div>
        <div class="payment-method">
            <input type="radio" name="payment_method" value="Pay Pal" id="stage2-paypal">
            <label for="stage2-paypal">Pay Pal</label>
        </div>
        <div class="payment-method">
            <input type="radio" name="payment_method" value="Pri doručení" id="stage2-upon-delivery">
            <label for="stage2-upon-delivery">Pri doručení</label>
        </div>
        <h2 class="stage2-header">Doprava</h2>
        <div class="delivery-method">
            <input type="radio" name="delivery_method" value="SPS" id="stage2-sps" checked>
            <label for="stage2-sps">SPS</label>
            <input type="radio" name="delivery_method" value="DHL" id="stage2-dhl">
            <label for="stage2-dhl">DHL</label>
        </div>
        <button type="submit" class="submit-button">Uložiť</button>
    </form>
</div>
