/**
 * This script handles the removal of product images.
 * It listens for click events on all elements with the class '.remove-image-button'.
 * When such an element is clicked, it sends a DELETE request to the server to remove the corresponding image.
 * After the image is successfully removed, the page is refreshed.
 */

// Select all elements with the class '.remove-image-button'
document.querySelectorAll('.remove-image-button').forEach(button => {

    // Add a click event listener to each button
    button.addEventListener('click', function(event) {

        // Prevent the default action of the click event
        event.preventDefault();

        // Find the closest parent element with the class '.product-image'
        const imageElement = event.target.closest('.product-image');

        // Extract the image ID from the data-image-id attribute of the image element
        const imageId = imageElement.dataset.imageId;

        // Send a DELETE request to the server to remove the image
        fetch(`/admin/remove_image/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(() => {
            // Refresh the page after the image is deleted
            location.reload();
        });
    });
});
