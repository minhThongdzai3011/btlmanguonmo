<?php
$page_title = 'Chỉnh sửa sản phẩm - AirAgent Admin';
$page_description = 'Cập nhật thông tin sản phẩm vé máy bay';
$current_page = 'product';
$css_files = ['../../css/main.css', '../../css/products/edit_product.css'];
$js_files = ['../../js/products/edit_product.js'];

$username = 'Admin';
$role = 'Administrator';

// Lấy ID từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    header("Location: index.php?error=ID sản phẩm không hợp lệ");
    exit();
}

// Lấy thông tin sản phẩm
require_once '../../handle/product_process.php';
$product = handleGetProductById($product_id);

if (!$product) {
    header("Location: index.php?error=Không tìm thấy sản phẩm");
    exit();
}

// Page header settings
$show_page_title = true;
$page_subtitle = 'Cập nhật thông tin sản phẩm vé máy bay';
$page_actions = '
  <a href="index.php" class="btn btn-secondary">
    <i class="bi bi-arrow-left me-2"></i>Quay lại
  </a>
';

// Hiển thị thông báo lỗi nếu có
$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';

// Include header
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
          <i class="bi bi-pencil-square me-2"></i>Chỉnh sửa sản phẩm
        </h5>
      </div>
      <div class="card-body">
        <form id="editProductForm" action="../../handle/product_process.php?action=edit" method="POST" enctype="multipart/form-data">
          
          <!-- Hidden ID -->
          <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
          
          <!-- Product Code -->
          <div class="mb-3">
            <label for="product_code" class="form-label">
              Mã sản phẩm <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="product_code" name="product_code" 
                   value="<?php echo htmlspecialchars($product['product_code']); ?>" required>
            <div class="invalid-feedback">Vui lòng nhập mã sản phẩm</div>
          </div>

          <!-- Product Name -->
          <div class="mb-3">
            <label for="product_name" class="form-label">
              Tên sản phẩm <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="product_name" name="product_name" 
                   value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            <div class="invalid-feedback">Vui lòng nhập tên sản phẩm</div>
          </div>

          <!-- Price -->
          <div class="mb-3">
            <label for="price" class="form-label">
              Giá (VNĐ) <span class="text-danger">*</span>
            </label>
            <input type="number" class="form-control" id="price" name="price" 
                   value="<?php echo $product['price']; ?>" min="0" required>
            <div class="invalid-feedback">Vui lòng nhập giá sản phẩm</div>
          </div>

          <!-- Quantity -->
          <div class="mb-3">
            <label for="quantity" class="form-label">
              Số lượng <span class="text-danger">*</span>
            </label>
            <input type="number" class="form-control" id="quantity" name="quantity" 
                   value="<?php echo $product['quantity']; ?>" min="0" required>
            <div class="invalid-feedback">Vui lòng nhập số lượng</div>
          </div>

          <!-- Current Image -->
          <div class="mb-3">
            <label class="form-label">Hình ảnh hiện tại</label>
            <div class="current-image-container">
              <?php 
              $imagePath = '../../img/' . $product['image'];
              if (!empty($product['image']) && file_exists($imagePath)): 
              ?>
                <img src="<?php echo $imagePath; ?>" alt="Current product image" class="current-image">
              <?php else: ?>
                <div class="no-image-placeholder">
                  <i class="bi bi-image"></i>
                  <p>Không có ảnh</p>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- New Image Upload -->
          <div class="mb-3">
            <label class="form-label">
              Thay đổi hình ảnh (không bắt buộc)
            </label>
            
            <div class="upload-area" id="uploadArea">
              <input type="file" class="d-none" id="imageFile" name="imageFile" 
                     accept="image/jpeg,image/png,image/jpg,image/gif">
              <div class="upload-content">
                <i class="bi bi-cloud-upload upload-icon"></i>
                <p class="mb-2">Kéo thả ảnh mới vào đây hoặc</p>
                <button type="button" class="btn btn-primary btn-sm" id="selectFileBtn">
                  Chọn file mới
                </button>
                <small class="text-muted d-block mt-2">
                  Hỗ trợ: JPG, PNG, GIF (Tối đa 5MB)
                </small>
              </div>
            </div>

            <!-- Hidden input to store current image path -->
            <input type="hidden" id="image" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
            
            <!-- New Image Preview -->
            <div id="imagePreview" class="image-preview mt-3" style="display: none;">
              <div class="preview-header">
                <span>Ảnh mới:</span>
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
              <i class="bi bi-check-lg me-2"></i>Cập nhật
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
