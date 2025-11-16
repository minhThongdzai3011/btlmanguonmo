<?php
$page_title = 'Chỉnh sửa cơ trưởng - AirAgent Admin';
$page_description = 'Cập nhật thông tin cơ trưởng';
$current_page = 'captain';
$css_files = ['../../css/main.css', '../../css/captains/edit_captain.css'];
$js_files = ['../../js/captains/edit_captain.js'];

$username = 'Admin';
$role = 'Administrator';

// Lấy ID từ URL
$captain_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($captain_id <= 0) {
    header("Location: index.php?error=ID cơ trưởng không hợp lệ");
    exit();
}

// Lấy thông tin cơ trưởng
require_once '../../handle/captain_process.php';
$captain = handleGetCaptainById($captain_id);

if (!$captain) {
    header("Location: index.php?error=Không tìm thấy cơ trưởng");
    exit();
}

// Breadcrumbs
$breadcrumbs = [
  ['title' => 'Quản lý cơ trưởng', 'url' => 'index.php'],
  ['title' => 'Chỉnh sửa cơ trưởng', 'url' => '']
];

// Page header settings
$show_page_title = true;
$page_subtitle = 'Cập nhật thông tin cơ trưởng';
$page_actions = '
  <a href="index.php" class="btn btn-outline-secondary">
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
  <div class="col-12 col-lg-8 col-xl-7">
    <div class="card form-card">
      <!-- Form Body -->
      <div class="card-body p-4">
        <!-- Success/Error Messages -->
        <div id="alertContainer">
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
        </div>

        <!-- Edit Captain Form -->
        <form method="POST" action="../../handle/captain_process.php?action=edit" class="needs-validation" novalidate id="editCaptainForm">
          <!-- Hidden ID -->
          <input type="hidden" name="id" value="<?php echo $captain['id']; ?>">
          
          <div class="row g-4">
            <!-- Captain Code -->
            <div class="col-md-4">
              <div class="form-floating">
                <input 
                  type="text" 
                  class="form-control" 
                  id="captainCode" 
                  name="captain_code"
                  value="<?php echo htmlspecialchars($captain['captain_code']); ?>"
                  placeholder="Mã cơ trưởng"
                  required
                  pattern="^CT[0-9]{3,6}$"
                  title="Mã cơ trưởng phải bắt đầu bằng CT và theo sau là 3-6 chữ số (VD: CT001)"
                >
                <label for="captainCode">
                  Mã cơ trưởng <span class="required">*</span>
                </label>
                <div class="form-text">Định dạng: CT + số (VD: CT001, CT1234)</div>
                <div class="invalid-feedback">
                  Vui lòng nhập mã cơ trưởng hợp lệ
                </div>
              </div>
            </div>

            <!-- Captain Name -->
            <div class="col-md-8">
              <div class="form-floating">
                <input 
                  type="text" 
                  class="form-control" 
                  id="captainName" 
                  name="captain_name"
                  value="<?php echo htmlspecialchars($captain['captain_name']); ?>"
                  placeholder="Tên cơ trưởng"
                  required
                  maxlength="100"
                >
                <label for="captainName">
                  Tên cơ trưởng <span class="required">*</span>
                </label>
                <div class="invalid-feedback">
                  Vui lòng nhập tên cơ trưởng
                </div>
              </div>
            </div>

            <!-- Age -->
            <div class="col-md-6">
              <div class="form-floating">
                <input 
                  type="number" 
                  class="form-control" 
                  id="age" 
                  name="age"
                  value="<?php echo $captain['age']; ?>"
                  placeholder="Tuổi"
                  required
                  min="25"
                  max="65"
                >
                <label for="age">
                  Tuổi <span class="required">*</span>
                </label>
                <div class="form-text">Độ tuổi từ 25-65</div>
                <div class="invalid-feedback">
                  Vui lòng nhập tuổi hợp lệ (25-65)
                </div>
              </div>
            </div>

            <!-- Gender -->
            <div class="col-md-6">
              <div class="form-floating">
                <select class="form-select" id="gender" name="gender" required>
                  <option value="">Chọn giới tính</option>
                  <option value="Nam" <?php echo ($captain['gender'] === 'Nam') ? 'selected' : ''; ?>>Nam</option>
                  <option value="Nữ" <?php echo ($captain['gender'] === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                </select>
                <label for="gender">
                  Giới tính <span class="required">*</span>
                </label>
                <div class="invalid-feedback">
                  Vui lòng chọn giới tính
                </div>
              </div>
            </div>

          </div>

          <!-- Form Actions -->
          <hr class="my-4">
          <div class="row">
            <div class="col-12">
              <div class="d-flex flex-wrap gap-2 justify-content-between">
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-2"></i>
                    Cập nhật
                  </button>
                  <button type="reset" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-clockwise me-2"></i>
                    Khôi phục
                  </button>
                </div>
                <div>
                  <a href="index.php" class="btn btn-outline-dark btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>
                    Quay lại
                  </a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Side Panel -->
  <div class="col-12 col-lg-4 col-xl-3 mt-4 mt-lg-0">
    <div class="card">
      <div class="card-header bg-light">
        <h6 class="card-title mb-0">
          <i class="bi bi-info-circle me-2"></i>Thông tin hiện tại
        </h6>
      </div>
      <div class="card-body">
        <div class="small">
          <div class="mb-3">
            <strong>Mã cơ trưởng:</strong>
            <div class="text-primary"><?php echo htmlspecialchars($captain['captain_code']); ?></div>
          </div>
          <div class="mb-3">
            <strong>Tên cơ trưởng:</strong>
            <div><?php echo htmlspecialchars($captain['captain_name']); ?></div>
          </div>
          <div class="mb-3">
            <strong>Tuổi:</strong>
            <div><?php echo $captain['age']; ?> tuổi</div>
          </div>
          <div class="mb-3">
            <strong>Giới tính:</strong>
            <div>
              <i class="bi bi-gender-<?php echo $captain['gender'] === 'Nam' ? 'male' : 'female'; ?> me-1"></i>
              <?php echo $captain['gender']; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header bg-light">
        <h6 class="card-title mb-0">
          <i class="bi bi-exclamation-triangle me-2"></i>Lưu ý
        </h6>
      </div>
      <div class="card-body">
        <div class="small">
          <ul class="list-unstyled ms-2">
            <li><i class="bi bi-dot"></i> Kiểm tra kỹ thông tin trước khi lưu</li>
            <li><i class="bi bi-dot"></i> Mã cơ trưởng không nên thay đổi</li>
            <li><i class="bi bi-dot"></i> Thay đổi sẽ ảnh hưởng đến dữ liệu liên quan</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
// Include footer
include '../../includes/footer.php';
?>
