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
        .then(response => response.json())
        .then(data => {
            refreshCartComponent();
        })
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
        .then(response => response.json())
        .then(data => {
            refreshCartComponent();
        })
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
            setupEventListeners(); // Re-setup event listeners after updating HTML
        })
        .catch(error => {
            console.error('Error refreshing cart:', error);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    setupEventListeners();
});
