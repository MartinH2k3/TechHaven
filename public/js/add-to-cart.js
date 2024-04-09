document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-cart-button-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // So the page doesn't refresh

            // Serialize form data
            const formData = new FormData(form);

            // Convert FormData to URLSearchParams for easy submission
            const searchParams = new URLSearchParams(formData);

            fetch(form.action, {
                method: 'POST',
                body: searchParams
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Product added to cart successfully!');
                })
                .catch(error => {
                    alert('Failed to add product to cart.');
                });
        });
    });
});
