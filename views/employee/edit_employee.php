<?php
// Page configuration
$page_title = 'Chỉnh sửa nhân viên - AirAgent Admin';
$page_description = 'Cập nhật thông tin nhân viên';
$current_page = 'edit_employee';
$css_files = ['../../css/main.css', '../../css/employees/create_employees.css'];
$js_files = ['../../js/employees/create_employee.js'];

$username = 'Admin';
$role = 'Administrator';

require_once '../../functions/employee_function.php';

// hiển thị thông báo
$success_message = '';
$error_message = '';

$employee_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($employee_id <= 0) {
    header('Location: index.php?error=ID nhân viên không hợp lệ');
    exit;
}

$employee = getEmployeeById($employee_id);
if (!$employee) {
    header('Location: index.php?error=Không tìm thấy nhân viên');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_employee'])) {
    try {
        $employee_code = trim($_POST['employee_code'] ?? '');
        $employee_name = trim($_POST['employee_name'] ?? '');
        $agent_code = trim($_POST['agent_code'] ?? '');
        $birth_date = trim($_POST['birth_date'] ?? '');
        $position = trim($_POST['position'] ?? ''); 
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? ''); 
        $address = trim($_POST['address'] ?? '');
        $age = intval($_POST['age'] ?? 0);
        $gender = trim($_POST['gender'] ?? '');
        $salary = floatval($_POST['salary'] ?? 0);

        if (empty($employee_code) || empty($employee_name) || empty($agent_code) || 
            empty($birth_date) || empty($position) || empty($email) || 
            empty($phone) || empty($address) || $age <= 0 || empty($gender) || $salary <= 0) {
            throw new Exception('Vui lòng điền đầy đủ thông tin bắt buộc!');
        }

        $result = updateEmployee(
            $employee_id, 
            $employee_code, 
            $employee_name, 
            $agent_code, 
            $birth_date, 
            $position,    
            $email, 
            $phone,       
            $address, 
            $age, 
            $gender, 
            $salary
        );

        if ($result) {
            $success_message = "Đã cập nhật thông tin nhân viên '$employee_name' thành công!";
            
            
            $employee = getEmployeeById($employee_id);
        } else {
            throw new Exception('Không thể cập nhật nhân viên. Vui lòng thử lại!');
        }

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}


// Page header settings
$show_page_title = true;
$page_subtitle = 'Cập nhật thông tin nhân viên: ' . htmlspecialchars($employee['employee_name']);
$page_actions = '
  <a href="index.php" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-2"></i>Quay lại
  </a>
';

// Include header
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

        <!-- Edit Employee Form -->
        <form method="POST" action="" class="needs-validation" novalidate id="editEmployeeForm">
          <input type="hidden" name="id" value="<?php echo $employee_id; ?>">
          
          <div class="row g-4">
            
            <!-- Employee Code (Readonly) -->
            <div class="col-md-4">
              <div class="form-floating">
                <input 
                  type="text" 
                  class="form-control" 
                  id="employeeCode" 
                  name="employee_code"
                  value="<?php echo htmlspecialchars($employee['employee_code']); ?>"
                  placeholder="Mã nhân viên"
                  required
                  readonly
                >
                <label for="employeeCode">Mã nhân viên <span class="required">*</span></label>
                <div class="form-text">Mã nhân viên không thể thay đổi</div>
              </div>
            </div>

            <!-- Employee Name -->
            <div class="col-md-8">
              <div class="form-floating">
                <input 
                  type="text" 
                  class="form-control" 
                  id="employeeName" 
                  name="employee_name"
                  value="<?php echo htmlspecialchars($employee['employee_name']); ?>"
                  placeholder="Tên nhân viên"
                  required
                  maxlength="100"
                >
                <label for="employeeName">Tên nhân viên <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng nhập tên nhân viên</div>
              </div>
            </div>

            <!-- Agent Code -->
            <div class="col-md-4">
              <div class="form-floating">
                <input 
                  type="text" 
                  class="form-control" 
                  id="agentCode" 
                  name="agent_code"
                  value="<?php echo htmlspecialchars($employee['agent_code']); ?>"
                  placeholder="Mã đại lý"
                  required
                  pattern="^AG[0-9]{3,6}$"
                  title="Mã đại lý phải bắt đầu bằng AG và theo sau là 3-6 chữ số (VD: AG001)"
                >
                <label for="agentCode">Mã đại lý <span class="required">*</span></label>
                <div class="form-text">Định dạng: AG + số</div>
                <div class="invalid-feedback">Vui lòng nhập mã đại lý hợp lệ</div>
              </div>
            </div>

            <!-- Position -->
            <div class="col-md-4">
            <div class="form-floating">
                <select class="form-select" id="position" name="position" required>
                <option value="">Chọn chức vụ</option>
                <option value="nhanvien" <?php echo ($employee['contact_position'] === 'nhanvien') ? 'selected' : ''; ?>>Nhân viên</option>
                <option value="quanly" <?php echo ($employee['contact_position'] === 'quanly') ? 'selected' : ''; ?>>Quản lý</option>
                <option value="tongquanly" <?php echo ($employee['contact_position'] === 'tongquanly') ? 'selected' : ''; ?>>Tổng quản lý</option>
                <option value="giamsat" <?php echo ($employee['contact_position'] === 'giamsat') ? 'selected' : ''; ?>>Giám sát</option>
                <option value="ketoan" <?php echo ($employee['contact_position'] === 'ketoan') ? 'selected' : ''; ?>>Kế toán</option>
                </select>
                <label for="position">Chức vụ <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng chọn chức vụ</div>
            </div>
            </div>

            <!-- Birth Date -->
            <div class="col-md-4">
              <div class="form-floating">
                <input 
                  type="date" 
                  class="form-control" 
                  id="birthDate" 
                  name="birth_date"
                  value="<?php echo htmlspecialchars($employee['birth_date']); ?>"
                  placeholder="Ngày sinh"
                  required
                >
                <label for="birthDate">Ngày sinh <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng chọn ngày sinh hợp lệ</div>
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
                  value="<?php echo htmlspecialchars($employee['email']); ?>"
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
                  name="phone"
                  value="<?php echo htmlspecialchars($employee['phone']); ?>"
                  placeholder="Số điện thoại"
                  required
                  pattern="^[0-9]{10,11}$"
                  title="Số điện thoại phải có 10-11 chữ số"
                >
                <label for="phone">Số điện thoại <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng nhập số điện thoại hợp lệ (10-11 số)</div>
              </div>
            </div>

            <!-- Address -->
            <div class="col-12">
              <div class="form-floating">
                <textarea 
                  class="form-control" 
                  id="address" 
                  name="address"
                  placeholder="Địa chỉ"
                  style="height: 80px"
                  required
                  maxlength="200"
                ><?php echo htmlspecialchars($employee['address']); ?></textarea>
                <label for="address">Địa chỉ <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng nhập địa chỉ</div>
              </div>
            </div>

            <!-- Age -->
            <div class="col-md-4">
              <div class="form-floating">
                <input 
                  type="number" 
                  class="form-control" 
                  id="age" 
                  name="age"
                  value="<?php echo htmlspecialchars($employee['age']); ?>"
                  placeholder="Tuổi"
                  required
                  min="18"
                  max="65"
                >
                <label for="age">Tuổi <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng nhập tuổi hợp lệ (18-65)</div>
              </div>
            </div>

            <!-- Gender -->
            <div class="col-md-4">
              <div class="form-floating">
                <select class="form-select" id="gender" name="gender" required>
                  <option value="">Chọn giới tính</option>
                  <option value="Nam" <?php echo ($employee['gender'] === 'Nam') ? 'selected' : ''; ?>>Nam</option>
                  <option value="Nữ" <?php echo ($employee['gender'] === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                  <option value="Khác" <?php echo ($employee['gender'] === 'Khác') ? 'selected' : ''; ?>>Khác</option>
                </select>
                <label for="gender">Giới tính <span class="required">*</span></label>
                <div class="invalid-feedback">Vui lòng chọn giới tính</div>
              </div>
            </div>

            <!-- Salary -->
            <div class="col-md-4">
              <div class="form-floating">
                <input 
                  type="number" 
                  class="form-control" 
                  id="salary" 
                  name="salary"
                  value="<?php echo htmlspecialchars($employee['salary']); ?>"
                  placeholder="Mức lương"
                  min="1000000"
                  step="100000"
                  required
                >
                <label for="salary">Mức lương (VNĐ) <span class="required">*</span></label>
                <div class="form-text">Tối thiểu 1,000,000 VNĐ</div>
                <div class="invalid-feedback">Vui lòng nhập mức lương hợp lệ</div>
              </div>
            </div>

          </div>

          <!-- Form Actions -->
          <hr class="my-4">
          <div class="row">
            <div class="col-12">
              <div class="d-flex flex-wrap gap-2 justify-content-between">
                <div class="d-flex gap-2">
                  <button type="submit" name="update_employee" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Cập nhật nhân viên
                  </button>
                  <a href="index.php" class="btn btn-outline-secondary btn-lg">
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

  <!-- Side Panel -->
  <div class="col-12 col-lg-4 col-xl-3 mt-4 mt-lg-0">
    <div class="card">
      <div class="card-header bg-light">
        <h6 class="card-title mb-0">
          <i class="bi bi-info-circle me-2"></i>Hướng dẫn
        </h6>
      </div>
      <div class="card-body">
        <div class="small">
          <div class="mb-3">
            <strong>Thông tin có thể chỉnh sửa:</strong>
            <ul class="list-unstyled ms-2 mt-1">
              <li><i class="bi bi-dot"></i> Tên nhân viên</li>
              <li><i class="bi bi-dot"></i> Mã đại lý</li>
              <li><i class="bi bi-dot"></i> Chức vụ & Ngày sinh</li>
              <li><i class="bi bi-dot"></i> Email & Số điện thoại</li>
              <li><i class="bi bi-dot"></i> Địa chỉ, Tuổi & Giới tính</li>
              <li><i class="bi bi-dot"></i> Mức lương</li>
            </ul>
          </div>
          
          <div class="mb-3">
            <strong>Lưu ý:</strong>
            <ul class="list-unstyled ms-2 mt-1">
              <li><i class="bi bi-dot"></i> Mã nhân viên <span class="text-danger">không thể thay đổi</span></li>
              <li><i class="bi bi-dot"></i> Email phải là địa chỉ hợp lệ</li>
              <li><i class="bi bi-dot"></i> Tuổi từ 18-65</li>
              <li><i class="bi bi-dot"></i> Lương tối thiểu 1,000,000 VNĐ</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-body">
        <h6 class="card-title">
          <i class="bi bi-person-badge text-primary me-2"></i>Thông tin nhân viên
        </h6>
        <div class="small">
          <div class="d-flex justify-content-between mb-2">
            <span>Mã NV:</span>
            <strong><?php echo htmlspecialchars($employee['employee_code']); ?></strong>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span>Mã đại lý:</span>
            <strong><?php echo htmlspecialchars($employee['agent_code']); ?></strong>
          </div>
          <div class="d-flex justify-content-between">
            <span>Lương hiện tại:</span>
            <strong class="text-success"><?php echo number_format($employee['salary'], 0, ',', '.'); ?> VNĐ</strong>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include '../../includes/footer.php';
?>