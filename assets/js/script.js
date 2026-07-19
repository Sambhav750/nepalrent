// ========================================
// NEPALRENT - Main JavaScript
// ========================================

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {

    // ========================================
    // 1. Dark/Light Mode Toggle
    // ========================================
    const darkModeToggle = document.getElementById('darkModeToggle');

    if (darkModeToggle) {
        // Check saved preference
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
            darkModeToggle.textContent = '☀️';
        }

        darkModeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');

            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                darkModeToggle.textContent = '☀️';
            } else {
                localStorage.setItem('theme', 'light');
                darkModeToggle.textContent = '🌙';
            }
        });
    }

    // ========================================
    // 2. Form Validation
    // ========================================
    const forms = document.querySelectorAll('.needs-validation');

    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // ========================================
    // 3. Confirm Delete
    // ========================================
    const deleteButtons = document.querySelectorAll('.confirm-delete');

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to delete this item?')) {
                event.preventDefault();
            }
        });
    });

    // ========================================
    // 4. Password Toggle (Show/Hide)
    // ========================================
    const togglePassword = document.querySelectorAll('.toggle-password');

    togglePassword.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const passwordField = this.previousElementSibling;

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.textContent = '🙈';
            } else {
                passwordField.type = 'password';
                this.textContent = '👁️';
            }
        });
    });

    // ========================================
    // 5. Scroll Animation
    // ========================================
    const revealElements = document.querySelectorAll('.reveal');

    function revealOnScroll() {
        revealElements.forEach(function(element) {
            const windowHeight = window.innerHeight;
            const elementTop = element.getBoundingClientRect().top;
            const revealPoint = 150;

            if (elementTop < windowHeight - revealPoint) {
                element.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll();

    // ========================================
    // 6. Date Picker - Set min date to today
    // ========================================
    const dateInputs = document.querySelectorAll('input[type="date"]');

    dateInputs.forEach(function(input) {
        if (!input.value) {
            const today = new Date().toISOString().split('T')[0];
            input.setAttribute('min', today);
        }
    });

    // ========================================
    // 7. Auto-dismiss Alerts
    // ========================================
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        }, 5000);
    });

    console.log('🚗 NepalRent - Online Car Rental System Loaded');

});