document.addEventListener('DOMContentLoaded', (event) => {
    const overlay = document.getElementById('overlay');
    const hoverForOverlay = document.querySelectorAll('#nav-bar .category-box');
    const loginCheckbox = document.getElementById('login-toggle');

    // Function to toggle overlay visibility
    function toggleOverlay(show) {
        overlay.style.display = show ? 'block' : 'none';
    }

    // Hover events for each hover-border element
    hoverForOverlay.forEach(border => {
        border.addEventListener('mouseenter', () => toggleOverlay(true));
        border.addEventListener('mouseleave', () => {
            if (!loginCheckbox.checked) {
                toggleOverlay(false);
            }
        });
    });

    // Checkbox change event
    loginCheckbox.addEventListener('change', () => {
        toggleOverlay(loginCheckbox.checked);
    });

    // Escape key event
    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape") { // For older browsers, you might need e.keyCode === 27
            loginCheckbox.checked = false;
            toggleOverlay(false);
        }
    });

});