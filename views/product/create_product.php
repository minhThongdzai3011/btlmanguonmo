<?php
$page_title = 'Thêm sản phẩm mới - AirAgent Admin';
$page_description = 'Tạo sản phẩm vé máy bay mới';
$current_page = 'product';
$css_files = ['../../css/main.css', '../../css/products/create_product.css'];
$js_files = ['../../js/products/create_product.js'];

$username = 'Admin';
$role = 'Administrator'; 

// THÊM: Biến để hiển thị thông báo
$success_message = '';
$error_message = '';

$show_page_title = true;
$page_subtitle = 'Nhập thông tin sản phẩm vé máy bay';
$page_actions = '
  <a href="index.php" class="btn btn-secondary">
    <i class="bi bi-arrow-left me-2"></i>Quay lại
  </a>
';

// Hiển thị thông báo lỗi nếu có
$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';

include '../../includes/header.php';
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      <?php echo htmlspecialchars($error); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      <?php echo htmlspecialchars($success); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <i class="bi bi-plus-circle me-2"></i>Thông tin sản phẩm
        </h5>
      </div>
      <div class="card-body">
        <form id="createProductForm" action="../../handle/product_process.php?action=create" method="POST" enctype="multipart/form-data">
          
          <!-- Product Code -->
          <div class="mb-3">
            <label for="product_code" class="form-label">
              Mã sản phẩm <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="product_code" name="product_code" 
                   placeholder="VD: VN123" required>
            <div class="invalid-feedback">Vui lòng nhập mã sản phẩm</div>
          </div>

          <!-- Product Name -->
          <div class="mb-3">
            <label for="product_name" class="form-label">
              Tên sản phẩm <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="product_name" name="product_name" 
                   placeholder="VD: Vé máy bay Hà Nội - Sài Gòn" required>
            <div class="invalid-feedback">Vui lòng nhập tên sản phẩm</div>
          </div>

          <!-- Price -->
          <div class="mb-3">
            <label for="price" class="form-label">
              Giá (VNĐ) <span class="text-danger">*</span>
            </label>
            <input type="number" class="form-control" id="price" name="price" 
                   placeholder="VD: 1500000" min="0" required>
            <div class="invalid-feedback">Vui lòng nhập giá sản phẩm</div>
          </div>

          <!-- Quantity -->
          <div class="mb-3">
            <label for="quantity" class="form-label">
              Số lượng <span class="text-danger">*</span>
            </label>
            <input type="number" class="form-control" id="quantity" name="quantity" 
                   placeholder="VD: 100" min="0" required>
            <div class="invalid-feedback">Vui lòng nhập số lượng</div>
          </div>

          <!-- Image Upload Section -->
          <div class="mb-3">
            <label class="form-label">
              Hình ảnh sản phẩm <span class="text-danger">*</span>
            </label>
            
            <!-- Upload Area -->
            <div class="upload-area" id="uploadArea">
              <input type="file" class="d-none" id="imageFile" name="imageFile" 
                     accept="image/jpeg,image/png,image/jpg,image/gif" required>
              <div class="upload-content">
                <i class="bi bi-cloud-upload upload-icon"></i>
                <p class="mb-2">Kéo thả ảnh vào đây hoặc</p>
                <button type="button" class="btn btn-primary btn-sm" id="selectFileBtn">
                  Chọn file
                </button>
                <small class="text-muted d-block mt-2">
                  Hỗ trợ: JPG, PNG, GIF (Tối đa 5MB)
                </small>
              </div>
            </div>
            
            <!-- Image Preview -->
            <div id="imagePreview" class="image-preview mt-3" style="display: none;">
              <div class="preview-header">
                <span>Xem trước:</span>
                <button type="button" class="btn btn-sm btn-danger" id="removeImageBtn">
                  <i class="bi bi-x-lg"></i> Xóa
                </button>
              </div>
              <img id="previewImg" src="" alt="Preview">
            </div>
          </div>

          <!-- Submit Buttons -->
          <div class="d-flex gap-2 justify-content-end">
            <a href="index.php" class="btn btn-secondary">
              <i class="bi bi-x-lg me-2"></i>Hủy
            </a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
              <i class="bi bi-check-lg me-2"></i>Tạo sản phẩm
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
// Include footer
include '../../includes/footer.php';
?>
