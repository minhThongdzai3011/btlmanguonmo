// Create Agent Form JavaScript
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById("createAgentForm");
  
  // Auto-generate agent code suggestion
  generateAgentCode();
  
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
});

function generateAgentCode() {
  // Auto-suggest next agent code
  const agentCodeInput = document.getElementById('agentCode');
  if (agentCodeInput) {
    const currentCount = 124; // This should come from PHP/Database
    const nextCode = 'AG' + String(currentCount + 1).padStart(3, '0');
    agentCodeInput.placeholder = `Gợi ý: ${nextCode}`;
  }
}

function resetForm() {
  const form = document.getElementById("createAgentForm");
  if (form) {
    form.reset();
    form.classList.remove("was-validated");
    
    // Reset to default values
    const statusSelect = document.getElementById("status");
    const commissionInput = document.getElementById("commissionRate");
    const creditInput = document.getElementById("creditLimit");
    
    if (statusSelect) statusSelect.value = "active";
    if (commissionInput) commissionInput.value = "5.0";
    if (creditInput) creditInput.value = "0";
    
    // Re-generate agent code suggestion
    generateAgentCode();
  }
}

function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}