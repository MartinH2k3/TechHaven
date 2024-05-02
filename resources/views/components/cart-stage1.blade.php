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
            <span class="stage1-price">{{ number_format($item->product->price, 2) }} €</span>
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
            <span class="stage1-total">{{ number_format($itemTotalPrice, 2) }} €</span>
        </div>
    @endforeach

    <div class="stage1-row shopping-cart-sum">
        <h5 class="stage1-title">Celková cena: </h5>
        <span class="stage1-total">{{ number_format($totalPrice, 2) }} €</span>
    </div>
</div>

<script>
    function setupEventListeners() {
        // for some reason they need to be refreshed after each update
        document.querySelectorAll('.product-count-input').forEach(input => {
            input.removeEventListener('change', handleQuantityChange);
            input.addEventListener('change', handleQuantityChange);
            input.form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                handleQuantityChange(input);
            });
            input.form.removeEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                handleQuantityChange(input);
            });
        });

        document.querySelectorAll('.stage1-remove button').forEach(button => {
            button.removeEventListener('click', handleItemRemoval);
            button.addEventListener('click', handleItemRemoval);
        });
    }

    function handleQuantityChange() {

        const input = this;
        const productId = input.dataset.productId;
        const productCount = input.value;

        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: `product_id=${productId}&product_count=${productCount}`
        })
            .then(() => refreshCartComponent()) // promise is not used here, so no need to pass data
            .catch(error => {
                console.error('Error updating cart:', error);
            });
    }

    function handleItemRemoval(e) {
        e.preventDefault();
        const button = this;
        const productId = button.dataset.productId;

        fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: `product_id=${productId}`
        })
            .then(() => refreshCartComponent()) // same here
            .catch(error => {
                console.error('Error removing item:', error);
            });
    }

    function refreshCartComponent() {
        fetch('{{ route("cart.refresh") }}')
            .then(response => response.text())
            .then(html => {
                const cartContainer = document.querySelector('.cart-stage-container');
                cartContainer.innerHTML = html;
                setupEventListeners();
            })
            .catch(error => {
                console.error('Error refreshing cart:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        setupEventListeners();
    });

</script>

