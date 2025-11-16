/**
 * Edit Steward Form JavaScript
 * Handles form validation and interactivity for editing steward
 */

// Store original values for comparison
let originalValues = {};

// Form validation
(function() {
    'use strict';

    // Fetch form
    const form = document.getElementById('editStewardForm');

    if (form) {
        // Store original form values
        storeOriginalValues(form);

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
                checkFormChanges();
            });

            input.addEventListener('change', function() {
                checkFormChanges();
            });
        });
    }
})();

/**
 * Store original form values
 */
function storeOriginalValues(form) {
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (input.type === 'checkbox' || input.type === 'radio') {
            originalValues[input.name] = input.checked;
        } else {
            originalValues[input.name] = input.value;
        }
    });
}

/**
 * Check if form has changes
 */
function checkFormChanges() {
    const form = document.getElementById('editStewardForm');
    if (!form) return;

    let hasChanges = false;
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        let currentValue;
        if (input.type === 'checkbox' || input.type === 'radio') {
            currentValue = input.checked;
        } else {
            currentValue = input.value;
        }

        if (originalValues[input.name] !== currentValue) {
            hasChanges = true;
        }
    });

    // Update submit button state
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        if (hasChanges) {
            submitBtn.classList.remove('btn-primary');
            submitBtn.classList.add('btn-success');
            submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Lưu thay đổi';
        } else {
            submitBtn.classList.remove('btn-success');
            submitBtn.classList.add('btn-primary');
            submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Cập nhật';
        }
    }

    return hasChanges;
}

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

document.addEventListener('DOMContentLoaded', function() {
    // Steward code format validation
    const stewardCodeInput = document.getElementById('stewardCode');
    if (stewardCodeInput) {
        stewardCodeInput.addEventListener('input', function() {
            let value = this.value.toUpperCase();
            
            // Auto-add TV prefix if user starts typing numbers
            if (value.length > 0 && !value.startsWith('TV')) {
                if (/^[0-9]/.test(value)) {
                    value = 'TV' + value;
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
            const feedbackDiv = this.nextElementSibling?.nextElementSibling;
            
            if (age < 20) {
                this.setCustomValidity('Tiếp viên phải từ 20 tuổi trở lên');
                if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                    feedbackDiv.textContent = 'Tiếp viên phải từ 20 tuổi trở lên';
                }
            } else if (age > 50) {
                this.setCustomValidity('Tuổi không được vượt quá 50');
                if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                    feedbackDiv.textContent = 'Tuổi không được vượt quá 50';
                }
            } else {
                this.setCustomValidity('');
                if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                    feedbackDiv.textContent = 'Vui lòng nhập tuổi hợp lệ (20-50)';
                }
            }
        });
    }

    // Form submit confirmation
    const form = document.getElementById('editStewardForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (form.checkValidity()) {
                const hasChanges = checkFormChanges();
                
                if (!hasChanges) {
                    e.preventDefault();
                    showErrorMessage('Không có thay đổi nào để lưu!');
                    return false;
                }

                const stewardName = document.getElementById('stewardName').value;
                const confirmed = confirm(`Bạn có chắc muốn cập nhật thông tin tiếp viên "${stewardName}"?`);
                
                if (!confirmed) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }

    // Reset button - restore original values
    const resetBtn = form?.querySelector('button[type="reset"]');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const confirmed = confirm('Bạn có chắc muốn khôi phục giá trị ban đầu?');
            if (confirmed) {
                const inputs = form.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = originalValues[input.name] || false;
                    } else {
                        input.value = originalValues[input.name] || '';
                    }
                    input.classList.remove('is-valid', 'is-invalid');
                });
                form.classList.remove('was-validated');
                checkFormChanges();
            }
        });
    }

    // Warn user before leaving if there are unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (checkFormChanges()) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    });

    // Disable beforeunload warning on form submit
    if (form) {
        form.addEventListener('submit', function() {
            window.removeEventListener('beforeunload', arguments.callee);
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
 * Highlight changed fields
 */
function highlightChangedFields() {
    const form = document.getElementById('editStewardForm');
    if (!form) return;

    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        let currentValue;
        if (input.type === 'checkbox' || input.type === 'radio') {
            currentValue = input.checked;
        } else {
            currentValue = input.value;
        }

        if (originalValues[input.name] !== currentValue) {
            input.style.borderColor = '#ffc107';
            input.style.backgroundColor = '#fff3cd';
        } else {
            input.style.borderColor = '';
            input.style.backgroundColor = '';
        }
    });
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
