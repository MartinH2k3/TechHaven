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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateTotalPrice = (newTotalPrice) => {
            const totalContainer = document.querySelector('.shopping-cart-sum .stage1-total');
            totalContainer.textContent = `Celková cena: ${newTotalPrice} €`;
        };

        // Update quantity
        document.querySelectorAll('.product-count-input').forEach(input => {
            input.addEventListener('change', function() {
                const productId = this.dataset.productId;
                const productCount = this.value;
                const itemRow = this.closest('.stage1-row'); // Get the closest stage1-row

                fetch('{{ route("cart.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Ensure CSRF token is included
                    },
                    body: `product_id=${productId}&product_count=${productCount}`
                })
                    .then(response => response.json())
                    .then(data => {
                        // Update the total price for the item directly
                        if(data.success) {
                            const totalSpan = itemRow.querySelector('.stage1-total');
                            totalSpan.textContent = `${data.newItemTotal} €`; // Update the item's total price
                            document.querySelector('.shopping-cart-sum .stage1-total').textContent = `Celková cena: ${data.newTotalPrice} €`;
                        } else {
                            console.error('Failed to update quantity. Server responded with an error.');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating cart:', error);
                    });
            });
        });

        // Remove items
        document.querySelectorAll('.stage1-remove button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                const itemRow = this.closest('.stage1-row');

                fetch('{{ route("cart.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Ensure CSRF token is included
                    },
                    body: `product_id=${productId}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            itemRow.remove(); // Remove the item row from the DOM
                            document.querySelector('.shopping-cart-sum .stage1-total').textContent = `Celková cena: ${data.newTotalPrice} €`; // Update the grand total price
                        } else {
                            console.error('Failed to remove product from cart. Server responded with an error.');
                        }
                    })
                    .catch(error => {
                        console.error('Error removing item:', error);
                    });
            });
        });
    });
</script>





