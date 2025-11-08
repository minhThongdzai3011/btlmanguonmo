<?php
// Page configuration
$page_title = 'Quản lý nhân viên - AirAgent Admin';
$page_description = 'Hệ thống quản lý thông tin nhân viên';
$current_page = 'employee';
$css_files = ['../../css/main.css', '../../css/employee.css'];
$js_files = ['../../js/employee.js'];

$username = 'Admin';
$role = 'Administrator';

// nhúng import functions để lấy data từ database
require_once '../../handle/employee_process.php';

$employees = handleGetAllEmployees();



// Tính số lượng nhân viên
$totalEmployees = count($employees);

$activeEmployees = $totalEmployees;
$inactiveEmployees = 0;
// Tính tổng lương và tuổi trung bình
$totalSalary = 0;
$averageAge = 0;

foreach ($employees as $employee) {
    $totalSalary += (float)$employee['salary'];
    $averageAge += (int)$employee['age'];
}

if ($totalEmployees > 0) {
    $averageAge = round($averageAge / $totalEmployees, 1);
}

$show_page_title = true;
$page_subtitle = 'Danh sách và thông tin chi tiết nhân viên';
$page_actions = '
  <a href="create_employee.php" class="btn btn-primary">
    <i class="bi bi-plus-lg me-2"></i>Thêm nhân viên
  </a>
';

include '../../includes/header.php';
?>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-3">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo $activeEmployees; ?></div>
            <div class="stats-label">Nhân viên đang làm</div>
          </div>
          <div class="stats-icon text-success">
            <i class="bi bi-people-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo $totalEmployees; ?></div>
            <div class="stats-label">Tổng nhân viên</div>
          </div>
          <div class="stats-icon text-primary">
            <i class="bi bi-person-badge"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo number_format($totalSalary, 0, ',', '.'); ?></div>
            <div class="stats-label">Tổng lương (VNĐ)</div>
          </div>
          <div class="stats-icon text-warning">
            <i class="bi bi-currency-dollar"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo $averageAge; ?></div>
            <div class="stats-label">Tuổi trung bình</div>
          </div>
          <div class="stats-icon text-info">
            <i class="bi bi-graph-up"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="row g-4">
  <!-- Left: Table & Filters -->
  <div class="col-lg-9">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">
            <i class="bi bi-people me-2"></i>Danh sách nhân viên
          </h5>
          <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" id="exportBtn">
              <i class="bi bi-download"></i> Export
            </button>
            <a href="create_employee.php" class="btn btn-primary btn-sm">
              <i class="bi bi-plus-lg"></i> Thêm mới
            </a>
          </div>
        </div>

        <!-- Filters -->
        <form id="filterForm" class="row g-2 align-items-end mb-3" method="GET">
          <div class="col-md-4">
            <label class="form-label small">Tìm kiếm</label>
            <input class="form-control form-control-sm" type="search" 
                   name="q" id="q" 
                   value=""
                   placeholder="Tên, mã NV, email, SĐT..." />
          </div>
          <div class="col-md-2">
            <label class="form-label small">Chức vụ</label>
            <select name="position" id="positionFilter" class="form-select form-select-sm">
              <option value="">Tất cả</option>
              <option value="Nhân viên bán hàng">Nhân viên bán hàng</option>
              <option value="Quản lý">Quản lý</option>
              <option value="Kế toán">Kế toán</option>
              <option value="Nhân viên hỗ trợ">Nhân viên hỗ trợ</option>
              <option value="Giám sát">Giám sát</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label small">Đại lý</label>
            <select name="agent" id="agentFilter" class="form-select form-select-sm">
              <option value="">Tất cả</option>
              <option value="AG001">AG001</option>
              <option value="AG002">AG002</option>
              <option value="AG003">AG003</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label small">Giới tính</label>
            <select name="gender" id="genderFilter" class="form-select form-select-sm">
              <option value="">Tất cả</option>
              <option value="Nam">Nam</option>
              <option value="Nữ">Nữ</option>
            </select>
          </div>
          <div class="col-md-2">
            <button class="btn btn-sm btn-outline-primary w-100" type="submit">
              <i class="bi bi-search"></i> Tìm
            </button>
          </div>
        </form>

        <?php if (!empty($searchQuery) || !empty($positionFilter) || !empty($agentFilter) || !empty($genderFilter)): ?>
        <div class="mb-3">
          <a href="index.php" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-x-circle"></i> Xóa bộ lọc
          </a>
        </div>
        <?php endif; ?>

        <!-- Table -->
        <div class="table-responsive">
          <table class="table table-hover align-middle employee-table">
            <thead class="table-light">
              <tr>
                <th style="width: 80px;">Mã NV</th>
                <th style="width: 180px;">Tên nhân viên</th>
                <th style="width: 80px;">Mã ĐL</th>
                <th style="width: 150px;">Tên đại lý</th>
                <th style="width: 120px;">Chức vụ</th>
                <th style="width: 60px;">Tuổi</th>
                <th style="width: 80px;">Giới tính</th>
                <th style="width: 120px;" class="text-end">Lương</th>
                <th style="width: 100px;">Hành động</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($employees)): ?>
                <tr>
                  <td colspan="9" class="text-center text-muted py-4">
                    <i class="bi bi-inbox me-2"></i>Chưa có nhân viên nào
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($employees as $employee): ?>
                  <tr data-employee-id="<?php echo $employee['id']; ?>">
                    <td>
                      <span class="employee-code"><?php echo htmlspecialchars($employee['employee_code']); ?></span>
                    </td>
                    <td>
                      <div class="employee-info">
                        <div class="fw-semibold"><?php echo htmlspecialchars($employee['employee_name']); ?></div>
                        <div class="text-muted small"><?php echo htmlspecialchars($employee['email']); ?></div>
                      </div>
                    </td>
                    <td>
                      <span class="agent-code"><?php echo htmlspecialchars($employee['agent_code']); ?></span>
                    </td>
                    <td><?php echo htmlspecialchars($employee['agent_name']); ?></td>
                    <td>
                      <span class="badge position-badge bg-secondary"><?php echo htmlspecialchars($employee['position']); ?></span>
                    </td>
                    <td class="text-center"><?php echo $employee['age']; ?></td>
                    <td>
                      <span class="gender-badge <?php echo $employee['gender'] === 'Nam' ? 'male' : 'female'; ?>">
                        <i class="bi bi-<?php echo $employee['gender'] === 'Nam' ? 'gender-male' : 'gender-female'; ?>"></i>
                        <?php echo htmlspecialchars($employee['gender']); ?>
                      </span>
                    </td>
                    <td class="text-end">
                      <span class="salary"><?php echo number_format($employee['salary'], 0, ',', '.'); ?> VNĐ</span>
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary viewBtn" 
                                data-id="<?php echo $employee['id']; ?>" 
                                title="Xem chi tiết">
                          <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary editBtn" 
                                data-id="<?php echo $employee['id']; ?>" 
                                title="Chỉnh sửa">
                                <a href="../employee/edit_employee.php?id=<?php echo $employee['id']; ?>" class="text-decoration-none">
                                  <i class="bi bi-pencil"></i>
                                </a>
                        </button>
                          <a href="../../handle/employee_process.php?action=delete&id=<?php echo $employee['id']; ?>" 
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Bạn có chắc muốn xóa nhân viên này?')"
                                title="Xóa nhân viên">
                                <i class="bi bi-trash"></i> 
                          </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
          <div class="text-muted small">
            Hiển thị <?php echo count($employees); ?> nhân viên
          </div>
          <nav>
            <ul class="pagination pagination-sm mb-0">
              <li class="page-item disabled"><a class="page-link">Trước</a></li>
              <li class="page-item active"><a class="page-link">1</a></li>
              <li class="page-item"><a class="page-link">2</a></li>
              <li class="page-item"><a class="page-link">Sau</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!-- Right: Quick Actions & Info -->
  <div class="col-lg-3">
    <div class="card">
      <div class="card-header">
        <h6 class="card-title mb-0">
          <i class="bi bi-speedometer2 me-2"></i>Thống kê nhanh
        </h6>
      </div>
      <div class="card-body">
        <div class="quick-stats">
          <div class="stat-item">
            <div class="stat-icon text-success">
              <i class="bi bi-check-circle-fill"></i>
              <span class="stat-content">
                <span class="stat-number"><?php echo $activeEmployees; ?></span>
                <span class="stat-label">Đang làm việc</span>
              </span>
            </div>
          </div>
          
          <div class="stat-item">
            <div class="stat-icon text-danger">
              <i class="bi bi-x-circle-fill"></i>
              <span class="stat-content">
              <span class="stat-number"><?php echo $inactiveEmployees; ?></span>
              <span class="stat-label">Đã nghỉ việc</span>
            </div>
            </span>
            </div>
            
          
          <div class="stat-item">
            <div class="stat-icon text-info">
              <i class="bi bi-calendar"></i>
            <span class="stat-content">
              <span class="stat-number"><?php echo $averageAge; ?></span>
              <span class="stat-label">Tuổi TB</span>
            </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">
        <h6 class="card-title mb-0">
          <i class="bi bi-tools me-2"></i>Thao tác nhanh
        </h6>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <a href="create_employee.php" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-2"></i>Thêm nhân viên
          </a>
          <button class="btn btn-outline-secondary btn-sm" id="importBtn">
            <i class="bi bi-upload me-2"></i>Import Excel
          </button>
          <button class="btn btn-outline-info btn-sm" id="reportBtn">
            <i class="bi bi-file-earmark-text me-2"></i>Báo cáo
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-person-circle me-2"></i>Chi tiết nhân viên
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="employeeDetails">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <a href="../employee/edit_employee.php" class="btn btn-primary" style="text-decoration: none;">Chỉnh sửa</a>
      </div>
    </div>
  </div>
</div>

<?php

include '../../includes/footer.php';
?>
