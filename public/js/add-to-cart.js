$(document).ready(function() {
    $('.add-to-cart-button-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                // Handle success (e.g., show a message, update cart count)
                alert('Product added to cart successfully!');
            },
            error: function(error) {
                // Handle error
                alert('Failed to add product to cart.');
            }
        });
    });
});
