<?php
// Page configuration
$page_title = 'Thêm hãng hàng không mới - AirAgent Admin';
$page_description = 'Thêm thông tin hãng hàng không mới vào hệ thống';
$current_page = 'airline';
$css_files = ['../../css/main.css', '../../css/airlines/create_airline.css'];
$js_files = ['../../js/airlines/create_airline.js'];

$username = 'Admin';
$role = 'Administrator';

$show_page_title = true;
$page_subtitle = 'Điền thông tin chi tiết về hãng hàng không';
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
  <div class="col-12 col-lg-8 mx-auto">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
          <i class="bi bi-airplane-engines me-2"></i>Thông tin hãng hàng không
        </h5>
      </div>
      <div class="card-body">
        <form id="createAirlineForm" action="../../handle/airline_process.php?action=create" method="POST">
          
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
                     placeholder="VD: VN, QH, VJ..." 
                     maxlength="10"
                     required>
              <div class="form-text">
                Mã viết tắt của hãng (2-10 ký tự, thường là 2 ký tự)
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
                     placeholder="VD: Vietnam Airlines, Bamboo Airways..." 
                     maxlength="255"
                     required>
              <div class="form-text">
                Tên đầy đủ của hãng hàng không
              </div>
            </div>
          </div>

          <!-- Ghi chú -->
          <div class="alert alert-info">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Lưu ý:</strong> Vui lòng kiểm tra kỹ thông tin trước khi lưu. Mã hãng nên tuân theo chuẩn IATA (2 ký tự) hoặc ICAO (3 ký tự).
          </div>

          <!-- Buttons -->
          <div class="d-flex justify-content-between">
            <a href="index.php" class="btn btn-outline-secondary">
              <i class="bi bi-x-lg me-2"></i>Hủy
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-lg me-2"></i>Lưu hãng hàng không
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Quick Reference Card -->
    <div class="card mt-3">
      <div class="card-body">
        <h6 class="card-title">
          <i class="bi bi-lightbulb me-2"></i>Tham khảo
        </h6>
        <div class="row">
          <div class="col-md-6">
            <p class="mb-1"><strong>Mã IATA (2 ký tự):</strong></p>
            <ul class="small mb-0">
              <li>VN - Vietnam Airlines</li>
              <li>QH - Bamboo Airways</li>
              <li>VJ - VietJet Air</li>
              <li>BL - Pacific Airlines</li>
            </ul>
          </div>
          <div class="col-md-6">
            <p class="mb-1"><strong>Mã ICAO (3 ký tự):</strong></p>
            <ul class="small mb-0">
              <li>HVN - Vietnam Airlines</li>
              <li>BAV - Bamboo Airways</li>
              <li>VJC - VietJet Air</li>
              <li>PIC - Pacific Airlines</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include '../../includes/footer.php';
?>
