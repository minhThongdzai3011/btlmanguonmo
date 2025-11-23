<?php
// Page configuration
$page_title = 'Chỉnh sửa hãng hàng không - AirAgent Admin';
$page_description = 'Cập nhật thông tin hãng hàng không';
$current_page = 'airline';
$css_files = ['../../css/main.css', '../../css/airlines/edit_airline.css'];
$js_files = ['../../js/airlines/edit_airline.js'];

$username = 'Admin';
$role = 'Administrator';

// Lấy ID từ URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header("Location: index.php?error=" . urlencode("ID không hợp lệ"));
    exit();
}

// Lấy thông tin airline
require_once '../../functions/airline_function.php';
$airline = getAirlineById($id);

if (!$airline) {
    header("Location: index.php?error=" . urlencode("Không tìm thấy hãng hàng không"));
    exit();
}

$show_page_title = true;
$page_subtitle = 'Cập nhật thông tin hãng hàng không';
$page_actions = '
  <a href="index.php" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-2"></i>Quay lại
  </a>
';

// Hiển thị thông báo lỗi
$error = isset($_GET['error']) ? $_GET['error'] : '';

include '../../includes/header.php';
?>

<?php if ($error): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <i class="bi bi-exclamation-triangle-fill me-2"></i>
  <?php echo htmlspecialchars($error); ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row">
  <!-- Form chỉnh sửa -->
  <div class="col-12 col-lg-8">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
          <i class="bi bi-pencil me-2"></i>Chỉnh sửa thông tin
        </h5>
      </div>
      <div class="card-body">
        <form id="editAirlineForm" action="../../handle/airline_process.php?action=edit" method="POST">
          
          <!-- Hidden ID -->
          <input type="hidden" name="id" value="<?php echo $airline['id']; ?>">
          
          <!-- Mã hãng hàng không -->
          <div class="row mb-3">
            <div class="col-12">
              <label for="airline_code" class="form-label">
                Mã hãng hàng không <span class="text-danger">*</span>
              </label>
              <input type="text" 
                     class="form-control" 
                     id="airline_code" 
                     name="airline_code" 
                     value="<?php echo htmlspecialchars($airline['airline_code']); ?>"
                     placeholder="VD: VN, QH, VJ..." 
                     maxlength="10"
                     required>
              <div class="form-text">
                Mã viết tắt của hãng (2-10 ký tự)
              </div>
            </div>
          </div>

          <!-- Tên hãng hàng không -->
          <div class="row mb-3">
            <div class="col-12">
              <label for="airline_name" class="form-label">
                Tên hãng hàng không <span class="text-danger">*</span>
              </label>
              <input type="text" 
                     class="form-control" 
                     id="airline_name" 
                     name="airline_name" 
                     value="<?php echo htmlspecialchars($airline['airline_name']); ?>"
                     placeholder="VD: Vietnam Airlines, Bamboo Airways..." 
                     maxlength="255"
                     required>
              <div class="form-text">
                Tên đầy đủ của hãng hàng không
              </div>
            </div>
          </div>

          <!-- Ghi chú -->
          <div class="alert alert-warning">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <strong>Lưu ý:</strong> Thay đổi mã hãng có thể ảnh hưởng đến các chuyến bay đã gán hãng này.
          </div>

          <!-- Buttons -->
          <div class="d-flex justify-content-between">
            <a href="index.php" class="btn btn-outline-secondary">
              <i class="bi bi-x-lg me-2"></i>Hủy
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-lg me-2"></i>Cập nhật
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Sidebar thông tin hiện tại -->
  <div class="col-12 col-lg-4">
    <div class="card">
      <div class="card-header bg-light">
        <h6 class="card-title mb-0">
          <i class="bi bi-info-circle me-2"></i>Thông tin hiện tại
        </h6>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="text-muted small">ID</label>
          <div class="fw-bold">#<?php echo $airline['id']; ?></div>
        </div>
        
        <div class="mb-3">
          <label class="text-muted small">Mã hãng</label>
          <div>
            <span class="badge bg-primary fs-6">
              <?php echo htmlspecialchars($airline['airline_code']); ?>
            </span>
          </div>
        </div>
        
        <div class="mb-3">
          <label class="text-muted small">Tên hãng</label>
          <div class="fw-bold"><?php echo htmlspecialchars($airline['airline_name']); ?></div>
        </div>

        <hr>

        <div class="d-grid gap-2">
          <a href="index.php" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-list-ul"></i> Xem danh sách
          </a>
          <a href="../../handle/airline_process.php?action=delete&id=<?php echo $airline['id']; ?>" 
             class="btn btn-outline-danger btn-sm"
             onclick="return confirm('Bạn có chắc chắn muốn xóa hãng hàng không này?')">
            <i class="bi bi-trash"></i> Xóa hãng bay
          </a>
        </div>
      </div>
    </div>

    <!-- Quick Tips -->
    <div class="card mt-3">
      <div class="card-body">
        <h6 class="card-title">
          <i class="bi bi-lightbulb me-2"></i>Mẹo
        </h6>
        <ul class="small mb-0">
          <li>Sử dụng mã IATA chuẩn (2 ký tự) hoặc ICAO (3 ký tự)</li>
          <li>Kiểm tra kỹ trước khi lưu thay đổi</li>
          <li>Mã hãng không nên trùng với hãng khác</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php
include '../../includes/footer.php';
?>
