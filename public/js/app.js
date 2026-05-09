// Lilus Kitchen - Public JavaScript

document.addEventListener("DOMContentLoaded", function () {
    // Mobile Navigation Toggle
    const navbarToggle = document.getElementById("navbarToggle");
    const navbarMenu = document.getElementById("navbarMenu");

    if (navbarToggle && navbarMenu) {
        navbarToggle.addEventListener("click", function () {
            navbarMenu.classList.toggle("active");
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.style.opacity = "0";
            alert.style.transform = "translateY(-10px)";
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Add to Cart AJAX (optional enhancement)
    const addToCartForms = document.querySelectorAll(".add-to-cart-form");
    addToCartForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            // Add visual feedback
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.textContent;
            btn.textContent = "Added!";
            btn.disabled = true;

            setTimeout(() => {
                btn.textContent = originalText;
                btn.disabled = false;
            }, 1500);
        });
    });
});
