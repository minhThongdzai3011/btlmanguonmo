// Create Employee Form JavaScript
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById("createEmployeeForm");
  
  // Auto-generate employee code suggestion
  generateEmployeeCode();
  
  // Form validation
  form.addEventListener("submit", function(event) {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add("was-validated");
  });

  // Phone number formatting
  const phoneInput = document.getElementById("phone");
  phoneInput?.addEventListener("input", function(e) {
    // Remove non-digits
    let value = e.target.value.replace(/\D/g, "");
    e.target.value = value;
  });

  // Email validation
  const emailInput = document.getElementById("email");
  emailInput?.addEventListener("blur", function(e) {
    const email = e.target.value;
    if (email && !isValidEmail(email)) {
      e.target.setCustomValidity("Địa chỉ email không hợp lệ");
    } else {
      e.target.setCustomValidity("");
    }
  });

  // Auto calculate age from birth date
  const birthDateInput = document.getElementById("birthDate");
  const ageInput = document.getElementById("age");
  
  birthDateInput?.addEventListener("change", function(e) {
    const birthDate = new Date(e.target.value);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    
    if (ageInput && age >= 18 && age <= 65) {
      ageInput.value = age;
    }
  });
});

function generateEmployeeCode() {
  // Auto-suggest next employee code
  const employeeCodeInput = document.getElementById('employeeCode');
  if (employeeCodeInput) {
    const currentCount = 124; // This should come from PHP/Database
    const nextCode = 'NV' + String(currentCount + 1).padStart(3, '0');
    employeeCodeInput.placeholder = `Gợi ý: ${nextCode}`;
  }
}

function resetForm() {
  const form = document.getElementById("createEmployeeForm");
  if (form) {
    form.reset();
    form.classList.remove("was-validated");
    
    // Re-generate employee code suggestion
    generateEmployeeCode();
  }
}

function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}