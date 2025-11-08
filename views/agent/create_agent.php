<?php
$page_title = 'Thêm đại lý mới - AirAgent Admin';
$page_description = 'Thêm đại lý bán vé mới vào hệ thống';
$current_page = 'create_agent';
$css_files = ['../../css/main.css', '../../css/create_agent.css'];
$js_files = ['../../js/create_agent.js'];

$username = 'Admin';
$role = 'Administrator'; 

// nhúng file
require_once '../../functions/agent_functions.php';

// THÊM: Biến để hiển thị thông báo
$success_message = '';
$error_message = '';

// THÊM: Xử lý form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_agent'])) {
    try {
        // Lấy dữ liệu từ form
        $agent_code = trim($_POST['agent_code'] ?? '');
        $agent_name = trim($_POST['agent_name'] ?? '');
        $contact_name = trim($_POST['contact_name'] ?? '');
        $contact_position = trim($_POST['contact_position'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $province = trim($_POST['province'] ?? '');
        $status = trim($_POST['status'] ?? 'active');
        $commission_rate = floatval($_POST['commission_rate'] ?? 5.0);
        $credit_limit = floatval($_POST['credit_limit'] ?? 0);
        $notes = trim($_POST['notes'] ?? '');

        if (empty($agent_code) || empty($agent_name) || empty($contact_name) || 
            empty($email) || empty($phone) || empty($address) || empty($province)) {
            throw new Exception('Vui lòng điền đầy đủ thông tin bắt buộc!');
        }

        if (!preg_match('/^AG[0-9]{3,6}$/', $agent_code)) {
            throw new Exception('Mã đại lý phải có định dạng AG + 3-6 chữ số (VD: AG001)');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Địa chỉ email không hợp lệ!');
        }

        if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
            throw new Exception('Số điện thoại phải có 10-11 chữ số!');
        }

        $full_address = $address . ', ' . $province;

        $result = addAgent(
            $agent_code,
            $agent_name, 
            $contact_name,
            $contact_position,
            $email,
            $phone,
            $full_address,
            $province,
            $status,
            $commission_rate,
            $credit_limit
        );

        if ($result) {
            $success_message = "Đã tạo đại lý '$agent_name' (mã: $agent_code) thành công!";
            
            $_POST = array();
        } else {
            throw new Exception('Không thể tạo đại lý. Mã đại lý có thể đã tồn tại!');
        }

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

$show_page_title = true;
$page_subtitle = 'Điền thông tin để tạo đại lý bán vé mới';
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

            <!-- Create Agent Form -->
            <form method="POST" action="" class="needs-validation" novalidate id="createAgentForm">
            <div class="row g-4">
                <!-- Agent Code -->
                <div class="col-md-4">
                <div class="form-floating">
                    <input 
                    type="text" 
                    class="form-control" 
                    id="agentCode" 
                    name="agent_code"
                    value="<?php echo htmlspecialchars($_POST['agent_code'] ?? ''); ?>"
                    placeholder="Mã đại lý"
                    required
                    pattern="^AG[0-9]{3,6}$"
                    title="Mã đại lý phải bắt đầu bằng AG và theo sau là 3-6 chữ số (VD: AG001)"
                    >
                    <label for="agentCode">
                    Mã đại lý <span class="required">*</span>
                    </label>
                    <div class="form-text">Định dạng: AG + số (VD: AG001, AG1234)</div>
                    <div class="invalid-feedback">
                    Vui lòng nhập mã đại lý hợp lệ
                    </div>
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
                    value="<?php echo htmlspecialchars($_POST['agent_name'] ?? ''); ?>"
                    placeholder="Tên đại lý"
                    required
                    maxlength="100"
                    >
                    <label for="agentName">
                    Tên đại lý <span class="required">*</span>
                    </label>
                    <div class="invalid-feedback">
                    Vui lòng nhập tên đại lý
                    </div>
                </div>
                </div>

                <!-- Contact Person -->
                <div class="col-md-6">
                <div class="form-floating">
                    <input 
                    type="text" 
                    class="form-control" 
                    id="contactName" 
                    name="contact_name"
                    value="<?php echo htmlspecialchars($_POST['contact_name'] ?? ''); ?>"
                    placeholder="Người liên hệ"
                    required
                    maxlength="50"
                    >
                    <label for="contactName">
                    Người liên hệ <span class="required">*</span>
                    </label>
                    <div class="invalid-feedback">
                    Vui lòng nhập tên người liên hệ
                    </div>
                </div>
                </div>

                <!-- Contact Position -->
                <div class="col-md-6">
                <div class="form-floating">
                    <select 
                    class="form-select" 
                    id="contactPosition" 
                    name="contact_position"
                    required
                    >
                    <option value="">Chọn chức vụ</option>
                    <option value="nhanvien" <?php echo (($_POST['contact_position'] ?? '') === 'nhanvien') ? 'selected' : ''; ?>>Nhân viên</option>
                    <option value="quanly" <?php echo (($_POST['contact_position'] ?? '') === 'quanly') ? 'selected' : ''; ?>>Quản lý</option>
                    <option value="tongquanly" <?php echo (($_POST['contact_position'] ?? '') === 'tongquanly') ? 'selected' : ''; ?>>Tổng quản lý</option>
                    <option value="giamsat" <?php echo (($_POST['contact_position'] ?? '') === 'giamsat') ? 'selected' : ''; ?>>Giám sát</option>
                    <option value="ketoan" <?php echo (($_POST['contact_position'] ?? '') === 'ketoan') ? 'selected' : ''; ?>>Kế toán</option>
                    </select>
                    <label for="contactPosition">Chức vụ <span class="required">*</span></label>
                    <div class="invalid-feedback">
                    Vui lòng chọn chức vụ
                    </div>
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
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                    placeholder="Email"
                    required
                    >
                    <label for="email">
                    Email <span class="required">*</span>
                    </label>
                    <div class="invalid-feedback">
                    Vui lòng nhập địa chỉ email hợp lệ
                    </div>
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
                    value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                    placeholder="Số điện thoại"
                    required
                    pattern="^[0-9]{10,11}$"
                    title="Số điện thoại phải có 10-11 chữ số"
                    >
                    <label for="phone">
                    Số điện thoại <span class="required">*</span>
                    </label>
                    <div class="invalid-feedback">
                    Vui lòng nhập số điện thoại hợp lệ (10-11 số)
                    </div>
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
                    ><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
                    <label for="address">
                    Địa chỉ <span class="required">*</span>
                    </label>
                    <div class="invalid-feedback">
                    Vui lòng nhập địa chỉ
                    </div>
                </div>
                </div>

                <!-- City and Province -->
                <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="province" name="province" required>
                    <option value="">Chọn tỉnh/thành phố</option>
                    <option value="hanoi">Hà Nội</option>
                    <option value="hcm">TP. Hồ Chí Minh</option>
                    <option value="danang">Đà Nẵng</option>
                    <option value="haiphong">Hải Phòng</option>
                    <option value="cantho">Cần Thơ</option>
                    <option value="other">Khác</option>
                    </select>
                    <label for="province">
                    Tỉnh/Thành phố <span class="required">*</span>
                    </label>
                    <div class="invalid-feedback">
                    Vui lòng chọn tỉnh/thành phố
                    </div>
                </div>
                </div>

                <!-- Status -->
                <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="status" name="status" required>
                    <option value="">Chọn trạng thái</option>
                    <option value="active" selected>Hoạt động</option>
                    <option value="inactive">Ngưng hoạt động</option>
                    <option value="suspended">Tạm khóa</option>
                    </select>
                    <label for="status">
                    Trạng thái <span class="required">*</span>
                    </label>
                    <div class="invalid-feedback">
                    Vui lòng chọn trạng thái
                    </div>
                </div>
                </div>

                <!-- Commission Rate -->
                <div class="col-md-6">
                <div class="form-floating">
                    <input 
                    type="number" 
                    class="form-control" 
                    id="commissionRate" 
                    name="commission_rate"
                    placeholder="Tỷ lệ hoa hồng (%)"
                    min="0"
                    max="100"
                    step="0.1"
                    value="5.0"
                    >
                    <label for="commissionRate">Tỷ lệ hoa hồng (%)</label>
                    <div class="form-text">Từ 0% đến 100%</div>
                </div>
                </div>

                <!-- Credit Limit -->
                <div class="col-md-6">
                <div class="form-floating">
                    <input 
                    type="number" 
                    class="form-control" 
                    id="creditLimit" 
                    name="credit_limit"
                    placeholder="Doanh thu dự kiến"
                    min="0"
                    step="1000000"
                    value="0"
                    >
                    <label for="creditLimit">Doanh thu dự kiến (VNĐ)</label>
                    <div class="form-text">Để trống hoặc 0 nếu không có doanh thu dự kiến</div>
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
                    ><?php echo htmlspecialchars($_POST['note'] ?? ''); ?></textarea>
                    <label for="notes">Ghi chú (tùy chọn)</label>
                    <div class="form-text">Thông tin bổ sung về đại lý</div>
                </div>
                </div>
            </div>

            <!-- Form Actions -->
            <hr class="my-4">
            <div class="row">
                <div class="col-12">
                <div class="d-flex flex-wrap gap-2 justify-content-between">
                    <div class="d-flex gap-2">
                    <button type="submit" name="create_agent" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle me-2"></i>
                        Tạo đại lý
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-lg" onclick="resetForm()">
                        <i class="bi bi-arrow-clockwise me-2"></i>
                        Làm mới
                    </button>
                    </div>
                    <div>
                    <a href="../main.php" class="btn btn-outline-dark btn-lg">
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
            <i class="bi bi-info-circle me-2"></i>Hướng dẫn
            </h6>
        </div>
        <div class="card-body">
            <div class="small">
            <div class="mb-3">
                <strong>Thông tin bắt buộc:</strong>
                <ul class="list-unstyled ms-2 mt-1">
                <li><i class="bi bi-dot"></i> Mã đại lý (định dạng AG + số)</li>
                <li><i class="bi bi-dot"></i> Tên đại lý</li>
                <li><i class="bi bi-dot"></i> Người liên hệ</li>
                <li><i class="bi bi-dot"></i> Email & Số điện thoại</li>
                <li><i class="bi bi-dot"></i> Địa chỉ & Tỉnh/TP</li>
                </ul>
            </div>
            
            <div class="mb-3">
                <strong>Lưu ý:</strong>
                <ul class="list-unstyled ms-2 mt-1">
                <li><i class="bi bi-dot"></i> Mã đại lý không được trùng</li>
                <li><i class="bi bi-dot"></i> Email phải là địa chỉ hợp lệ</li>
                <li><i class="bi bi-dot"></i> Tỷ lệ hoa hồng mặc định: 5%</li>
                </ul>
            </div>
            </div>
        </div>
        </div>

        <div class="card mt-3">
        <div class="card-body">
            <h6 class="card-title">
            <i class="bi bi-graph-up text-success me-2"></i>Thống kê nhanh
            </h6>
            <div class="small">
            <div class="d-flex justify-content-between mb-2">
                <span>Tổng đại lý:</span>
                <strong>124</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Đang hoạt động:</span>
                <strong class="text-success">116</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tạm khóa:</span>
                <strong class="text-warning">8</strong>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>

<?php
// Page specific scripts
$page_scripts = '
  // Form sẽ được khởi tạo bởi create_agent.js
  // Các function cần thiết đã có trong JS file
';

// Include footer
include '../../includes/footer.php';
?>
