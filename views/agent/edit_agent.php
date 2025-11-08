<?php
$page_title = 'Chỉnh sửa đại lý - AirAgent Admin';
$page_description = 'Cập nhật thông tin đại lý';
$current_page = 'edit_agent';
$css_files = ['../../css/main.css', '../../css/create_agent.css'];
$js_files = ['../../js/create_agent.js'];

$username = 'Admin';
$role = 'Administrator';

// Include functions
require_once '../../functions/agent_functions.php';

// Biến để hiển thị thông báo
$success_message = '';
$error_message = '';

$agent_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($agent_id <= 0) {
    header('Location: ../main.php?error=ID đại lý không hợp lệ');
    exit;
}

// Lấy thông tin đại lý hiện tại
$agent = getAgentById($agent_id);
if (!$agent) {
    header('Location: ../main.php?error=Không tìm thấy đại lý');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_agent'])) {
    try {
        $agent_code = trim($_POST['agent_code'] ?? '');
        $agent_name = trim($_POST['agent_name'] ?? '');
        $contact_person = trim($_POST['contact_person'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phoneNumber = trim($_POST['phoneNumber'] ?? '');
        $currentState = trim($_POST['currentState'] ?? '');
        $sales = floatval($_POST['sales'] ?? 0); 
        $commissionRate = floatval($_POST['commissionRate'] ?? 5.0); 
        $note = trim($_POST['note'] ?? ''); 

        // Validation - BỎ $note và $sales khỏi required
        if (empty($agent_code) || empty($agent_name) || empty($contact_person) || 
            empty($email) || empty($phoneNumber) || empty($currentState) || empty($position)) {
            throw new Exception('Vui lòng điền đầy đủ thông tin bắt buộc!');
        }

        // Kiểm tra email hợp lệ
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Địa chỉ email không hợp lệ!');
        }

        // GỌI FUNCTION UPDATE với thứ tự đúng
        $result = updateAgent(
            $agent_id, 
            $agent_code, 
            $agent_name, 
            $contact_person, 
            $email, 
            $phoneNumber, 
            $currentState, 
            $note, 
            $sales, 
            $commissionRate, 
            $position
        );

        if ($result) {
            $success_message = "Đã cập nhật thông tin đại lý '$agent_name' thành công!";
            
            $agent = getAgentById($agent_id);
        } else {
            throw new Exception('Không thể cập nhật đại lý. Vui lòng thử lại!');
        }

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

$show_page_title = true;
$page_subtitle = 'Cập nhật thông tin đại lý: ' . htmlspecialchars($agent['agent_name']);
$page_actions = '
  <a href="../main.php" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-2"></i>Quay lại
  </a>
';

include '../../includes/header.php';
?>

<div class="row justify-content-center">
  <div class="col-12 col-lg-8 col-xl-7">
    <div class="card form-card">
      <div class="card-body p-4">
        
        <!-- Success/Error Messages -->
        <div id="alertContainer">
          <?php if (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="bi bi-check-circle-fill me-2"></i>
              <?php echo htmlspecialchars($success_message); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>
              <?php echo htmlspecialchars($error_message); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
        </div>

        <!-- Edit Agent Form -->
        <form method="POST" action="" class="needs-validation" novalidate id="editAgentForm">
          <input type="hidden" name="id" value="<?php echo $agent_id; ?>">
          <input type="hidden" name="action" value="edit">
          
          <div class="row g-4">
            
            <!-- Agent Code -->
            <div class="col-md-4">
              <div class="form-floating">
                <input 
                  type="text" 
                  class="form-control" 
                  id="agentCode" 
                  name="agent_code"
                  value="<?php echo htmlspecialchars($agent['agent_code']); ?>"
                  placeholder="Mã đại lý"
                  required
                  readonly
                >
                <label for="agentCode">Mã đại lý <span class="required">*</span></label>
                <div class="form-text">Mã đại lý không thể thay đổi</div>
              </div>
            </div>

            <!-- Agent Name -->
            <div class="col-md-8">
              <div class="form-floating">
                <input 
                  type="text" 
                  class="form-control" 
                  id="agentName" 
                  name="agent_name"
                  value="<?php echo htmlspecialchars($agent['agent_name']); ?>"
                  placeholder="Tên đại lý"
                  required
                  maxlength="100"
                >
                <label for="agentName">Tên đại lý <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng nhập tên đại lý</div>
              </div>
            </div>

            <!-- Contact Person -->
            <div class="col-md-6">
              <div class="form-floating">
                <input 
                  type="text" 
                  class="form-control" 
                  id="contactPerson" 
                  name="contact_person"
                  value="<?php echo htmlspecialchars($agent['contactPerson']); ?>"
                  placeholder="Người liên hệ"
                  required
                  maxlength="50"
                >
                <label for="contactPerson">Người liên hệ <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng nhập tên người liên hệ</div>
              </div>
            </div>

            <!-- Position -->
            <div class="col-md-6">
              <div class="form-floating">
                <select class="form-select" id="position" name="position" required>
                  <option value="">Chọn chức vụ</option>
                  <option value="nhanvien" <?php echo ($agent['position'] === 'nhanvien') ? 'selected' : ''; ?>>Nhân viên</option>
                  <option value="quanly" <?php echo ($agent['position'] === 'quanly') ? 'selected' : ''; ?>>Quản lý</option>
                  <option value="tongquanly" <?php echo ($agent['position'] === 'tongquanly') ? 'selected' : ''; ?>>Tổng quản lý</option>
                  <option value="giamsat" <?php echo ($agent['position'] === 'giamsat') ? 'selected' : ''; ?>>Giám sát</option>
                  <option value="ketoan" <?php echo ($agent['position'] === 'ketoan') ? 'selected' : ''; ?>>Kế toán</option>
                </select>
                <label for="position">Chức vụ <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng chọn chức vụ</div>
              </div>
            </div>

            <!-- Email -->
            <div class="col-md-6">
              <div class="form-floating">
                <input 
                  type="email" 
                  class="form-control" 
                  id="email" 
                  name="email"
                  value="<?php echo htmlspecialchars($agent['email']); ?>"
                  placeholder="Email"
                  required
                >
                <label for="email">Email <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng nhập địa chỉ email hợp lệ</div>
              </div>
            </div>

            <!-- Phone -->
            <div class="col-md-6">
              <div class="form-floating">
                <input 
                  type="tel" 
                  class="form-control" 
                  id="phone" 
                  name="phoneNumber"
                  value="<?php echo htmlspecialchars($agent['phoneNumber']); ?>"
                  placeholder="Số điện thoại"
                  required
                  pattern="^[0-9]{10,11}$"
                >
                <label for="phone">Số điện thoại <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng nhập số điện thoại hợp lệ (10-11 số)</div>
              </div>
            </div>

            <!-- Status -->
            <div class="col-md-6">
              <div class="form-floating">
                <select class="form-select" id="status" name="currentState" required>
                  <option value="">Chọn trạng thái</option>
                  <option value="active" <?php echo ($agent['currentState'] === 'active') ? 'selected' : ''; ?>>Hoạt động</option>
                  <option value="inactive" <?php echo ($agent['currentState'] === 'inactive') ? 'selected' : ''; ?>>Ngưng hoạt động</option>
                  <option value="suspended" <?php echo ($agent['currentState'] === 'suspended') ? 'selected' : ''; ?>>Tạm khóa</option>
                </select>
                <label for="status">Trạng thái <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng chọn trạng thái</div>
              </div>
            </div>

            <!-- Commission Rate -->
            <div class="col-md-6">
              <div class="form-floating">
                <input 
                  type="number" 
                  class="form-control" 
                  id="commissionRate" 
                  name="commissionRate"
                  value="<?php echo htmlspecialchars($agent['commissionRate'] ?? 5.0); ?>"
                  placeholder="Tỷ lệ hoa hồng"
                  min="0"
                  max="100"
                  step="0.1"
                >
                <label for="commissionRate">Tỷ lệ hoa hồng (%)</label>
              </div>
            </div>

            <!-- Sales -->
            <div class="col-md-6">
              <div class="form-floating">
                <input 
                  type="number" 
                  class="form-control" 
                  id="sales" 
                  name="sales"
                  value="<?php echo htmlspecialchars($agent['sales']); ?>"
                  placeholder="Doanh thu"
                  min="0"
                  step="1000000"
                >
                <label for="sales">Doanh thu (VNĐ)</label>
              </div>
            </div>

            <!-- Notes -->
            <div class="col-12">
              <div class="form-floating">
                <textarea 
                  class="form-control" 
                  id="note" 
                  name="note"
                  placeholder="Ghi chú"
                  style="height: 80px"
                  maxlength="300"
                ><?php echo htmlspecialchars($agent['note'] ?? ''); ?></textarea>
                <label for="note">Ghi chú (tùy chọn)</label>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <hr class="my-4">
          <div class="row">
            <div class="col-12">
              <div class="d-flex flex-wrap gap-2 justify-content-between">
                <div class="d-flex gap-2">
                  <button type="submit" name="update_agent" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Cập nhật
                  </button>
                  <a href="../main.php" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Hủy bỏ
                  </a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
include '../../includes/footer.php';
?>