// Create Product Form JavaScript
document.addEventListener('DOMContentLoaded', function() {
  // DOM Elements
  const form = document.getElementById('createProductForm');
  const uploadArea = document.getElementById('uploadArea');
  const imageFile = document.getElementById('imageFile');
  const selectFileBtn = document.getElementById('selectFileBtn');
  const imagePreview = document.getElementById('imagePreview');
  const previewImg = document.getElementById('previewImg');
  const removeImageBtn = document.getElementById('removeImageBtn');
  const submitBtn = document.getElementById('submitBtn');

  let hasImage = false;

  // File Selection
  selectFileBtn.addEventListener('click', function() {
    imageFile.click();
  });

  // Upload Area Click
  uploadArea.addEventListener('click', function(e) {
    if (e.target !== selectFileBtn) {
      imageFile.click();
    }
  });

  // Drag and Drop Events
  uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    uploadArea.classList.add('drag-over');
  });

  uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    uploadArea.classList.remove('drag-over');
  });

  uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    uploadArea.classList.remove('drag-over');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      imageFile.files = files;
      handleFileSelect(files[0]);
    }
  });

  // File Input Change
  imageFile.addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
      handleFileSelect(e.target.files[0]);
    }
  });

  // Remove Image Button
  removeImageBtn.addEventListener('click', function() {
    clearImagePreview();
    imageFile.value = '';
  });

  // Handle File Selection
  function handleFileSelect(file) {
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
      showAlert('danger', 'Chỉ chấp nhận file ảnh định dạng JPG, PNG, hoặc GIF!');
      imageFile.value = '';
      return;
    }

    // Validate file size (5MB)
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if (file.size > maxSize) {
      showAlert('danger', 'Kích thước file không được vượt quá 5MB!');
      imageFile.value = '';
      return;
    }

    // Read and preview the file
    const reader = new FileReader();
    reader.onload = function(e) {
      previewImg.src = e.target.result;
      imagePreview.style.display = 'block';
      hasImage = true;
    };
    reader.readAsDataURL(file);
  }

  // Clear Image Preview
  function clearImagePreview() {
    imagePreview.style.display = 'none';
    previewImg.src = '';
    hasImage = false;
  }

  // Show Alert
  function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.setAttribute('role', 'alert');
    alertDiv.innerHTML = `
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    const container = document.querySelector('.col-lg-8');
    container.insertBefore(alertDiv, container.firstChild);

    // Auto dismiss after 5 seconds
    setTimeout(() => {
      alertDiv.remove();
    }, 5000);
  }

  // Form Validation
  form.addEventListener('submit', function(e) {
    // Bootstrap form validation
    if (!form.checkValidity()) {
      e.preventDefault();
      e.stopPropagation();
      form.classList.add('was-validated');
      return;
    }

    // Check if image is provided
    if (!hasImage) {
      e.preventDefault();
      showAlert('danger', 'Vui lòng chọn hình ảnh sản phẩm!');
      return;
    }

    // Show loading state
    submitBtn.disabled = true;
    submitBtn.classList.add('loading');
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';
  });

  // Format price input (optional - for display only)
  const priceInput = document.getElementById('price');
  
  // Remove formatting on focus to allow editing
  priceInput.addEventListener('focus', function() {
    this.value = this.value.replace(/\./g, '');
  });

  // Add formatting on blur (optional - for Vietnamese format)
  priceInput.addEventListener('blur', function() {
    const value = this.value.replace(/\./g, '');
    if (value && !isNaN(value)) {
      // Format with dot as thousand separator (Vietnamese style)
      // this.value = parseInt(value).toLocaleString('vi-VN');
    }
  });
});
