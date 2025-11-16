/**
 * Create Captain Form JavaScript
 * Handles form validation and interactivity
 */

// Form validation
(function() {
    'use strict';

    // Fetch form
    const form = document.getElementById('createCaptainForm');

    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);

        // Real-time validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
            });
        });
    }
})();

/**
 * Validate individual field
 */
function validateField(field) {
    if (field.checkValidity()) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
    } else {
        field.classList.remove('is-valid');
        field.classList.add('is-invalid');
    }
}

/**
 * Auto-generate captain code
 */
document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generateCodeBtn');
    
    if (generateBtn) {
        generateBtn.addEventListener('click', function() {
            const captainCodeInput = document.getElementById('captainCode');
            const randomNum = Math.floor(Math.random() * 900000) + 100000;
            captainCodeInput.value = 'CT' + randomNum.toString().substring(0, 4);
            validateField(captainCodeInput);
        });
    }

    // Captain code format validation
    const captainCodeInput = document.getElementById('captainCode');
    if (captainCodeInput) {
        captainCodeInput.addEventListener('input', function() {
            let value = this.value.toUpperCase();
            
            // Auto-add CT prefix if user starts typing numbers
            if (value.length > 0 && !value.startsWith('CT')) {
                if (/^[0-9]/.test(value)) {
                    value = 'CT' + value;
                }
            }
            
            this.value = value;
        });
    }

    // Age validation
    const ageInput = document.getElementById('age');
    if (ageInput) {
        ageInput.addEventListener('input', function() {
            const age = parseInt(this.value);
            const feedbackDiv = this.nextElementSibling;
            
            if (age < 25) {
                this.setCustomValidity('Cơ trưởng phải từ 25 tuổi trở lên');
                if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                    feedbackDiv.textContent = 'Cơ trưởng phải từ 25 tuổi trở lên';
                }
            } else if (age > 65) {
                this.setCustomValidity('Tuổi không được vượt quá 65');
                if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                    feedbackDiv.textContent = 'Tuổi không được vượt quá 65';
                }
            } else {
                this.setCustomValidity('');
                if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                    feedbackDiv.textContent = 'Vui lòng nhập tuổi hợp lệ (25-65)';
                }
            }
        });
    }

    // Form submit confirmation
    const form = document.getElementById('createCaptainForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (form.checkValidity()) {
                const captainName = document.getElementById('captainName').value;
                const confirmed = confirm(`Bạn có chắc muốn tạo cơ trưởng "${captainName}"?`);
                
                if (!confirmed) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }
});

/**
 * Show success message
 */
function showSuccessMessage(message) {
    const alertHtml = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        alertContainer.innerHTML = alertHtml;
        alertContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            const alert = alertContainer.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }
}

/**
 * Show error message
 */
function showErrorMessage(message) {
    const alertHtml = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        alertContainer.innerHTML = alertHtml;
        alertContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

/**
 * Character counter for text inputs
 */
document.addEventListener('DOMContentLoaded', function() {
    const textInputs = document.querySelectorAll('input[maxlength], textarea[maxlength]');
    
    textInputs.forEach(input => {
        const maxLength = input.getAttribute('maxlength');
        if (maxLength) {
            const counter = document.createElement('div');
            counter.className = 'form-text text-end';
            counter.style.fontSize = '0.875rem';
            input.parentNode.appendChild(counter);
            
            const updateCounter = () => {
                const remaining = maxLength - input.value.length;
                counter.textContent = `Còn lại: ${remaining} ký tự`;
                counter.className = remaining < 10 ? 'form-text text-end text-warning' : 'form-text text-end text-muted';
            };
            
            input.addEventListener('input', updateCounter);
            updateCounter();
        }
    });
});

/**
 * Tooltip initialization
 */
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
