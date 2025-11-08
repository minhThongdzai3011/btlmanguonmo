document.addEventListener('DOMContentLoaded', function() {
  // Get DOM elements
  const uploadArea = document.getElementById('uploadArea');
  const imageFile = document.getElementById('imageFile');
  const selectFileBtn = document.getElementById('selectFileBtn');
  const imagePreview = document.getElementById('imagePreview');
  const previewImg = document.getElementById('previewImg');
  const removeImageBtn = document.getElementById('removeImageBtn');
  const editProductForm = document.getElementById('editProductForm');
  const imageInput = document.getElementById('image');

  // Track if new image is selected
  let hasNewImage = false;

  // Click on upload area to select file
  uploadArea.addEventListener('click', function() {
    imageFile.click();
  });

  // Select file button
  selectFileBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    imageFile.click();
  });

  // File input change event
  imageFile.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      handleFile(file);
    }
  });

  // Drag and drop events
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

    const file = e.dataTransfer.files[0];
    if (file) {
      handleFile(file);
    }
  });

  // Remove new image button
  removeImageBtn.addEventListener('click', function() {
    imageFile.value = '';
    imagePreview.style.display = 'none';
    previewImg.src = '';
    hasNewImage = false;
  });

  // Handle file validation and preview
  function handleFile(file) {
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
      alert('Chỉ chấp nhận file ảnh định dạng JPG, PNG, GIF');
      return;
    }

    // Validate file size (5MB)
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if (file.size > maxSize) {
      alert('Kích thước file không được vượt quá 5MB');
      return;
    }

    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
      previewImg.src = e.target.result;
      imagePreview.style.display = 'block';
      hasNewImage = true;
    };
    reader.readAsDataURL(file);
  }

  // Form validation
  editProductForm.addEventListener('submit', function(e) {
    // Get form values
    const productCode = document.getElementById('product_code').value.trim();
    const productName = document.getElementById('product_name').value.trim();
    const price = document.getElementById('price').value;
    const quantity = document.getElementById('quantity').value;

    // Validate required fields
    if (!productCode || !productName || !price || !quantity) {
      e.preventDefault();
      alert('Vui lòng điền đầy đủ thông tin bắt buộc');
      return false;
    }

    // Validate price
    if (parseFloat(price) < 0) {
      e.preventDefault();
      alert('Giá sản phẩm phải lớn hơn hoặc bằng 0');
      return false;
    }

    // Validate quantity
    if (parseInt(quantity) < 0) {
      e.preventDefault();
      alert('Số lượng phải lớn hơn hoặc bằng 0');
      return false;
    }

    // If has new image, form will submit with file
    // If no new image, form will submit with existing image path (hidden input)
    
    // Add Bootstrap validation classes
    editProductForm.classList.add('was-validated');
    
    return true;
  });

  // Real-time validation
  const requiredInputs = editProductForm.querySelectorAll('input[required]');
  requiredInputs.forEach(input => {
    input.addEventListener('blur', function() {
      if (this.value.trim() === '') {
        this.classList.add('is-invalid');
      } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
      }
    });

    input.addEventListener('input', function() {
      if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
      }
    });
  });

  // Price validation
  const priceInput = document.getElementById('price');
  priceInput.addEventListener('input', function() {
    if (parseFloat(this.value) < 0) {
      this.setCustomValidity('Giá phải lớn hơn hoặc bằng 0');
      this.classList.add('is-invalid');
    } else {
      this.setCustomValidity('');
      this.classList.remove('is-invalid');
      if (this.value !== '') {
        this.classList.add('is-valid');
      }
    }
  });

  // Quantity validation
  const quantityInput = document.getElementById('quantity');
  quantityInput.addEventListener('input', function() {
    if (parseInt(this.value) < 0) {
      this.setCustomValidity('Số lượng phải lớn hơn hoặc bằng 0');
      this.classList.add('is-invalid');
    } else {
      this.setCustomValidity('');
      this.classList.remove('is-invalid');
      if (this.value !== '') {
        this.classList.add('is-valid');
      }
    }
  });
});
