<?php
// Page configuration
$page_title = 'Quản lý tiếp viên - AirAgent Admin';
$page_description = 'Hệ thống quản lý thông tin tiếp viên';
$current_page = 'steward';
$css_files = ['../../css/stewards/steward.css'];
$js_files = ['../../js/stewards/steward.js'];

$username = 'Admin';
$role = 'Administrator';

// nhúng import functions để lấy data từ database
require_once '../../handle/steward_process.php';

$stewards = handleGetAllStewards();

// Tính số lượng tiếp viên
$totalStewards = count($stewards);

$activeStewards = $totalStewards;
$inactiveStewards = 0;

// Tính tuổi trung bình
$averageAge = 0;
$maleCount = 0;
$femaleCount = 0;

foreach ($stewards as $steward) {
    $averageAge += (int)$steward['age'];
    if ($steward['gender'] === 'Nam') {
        $maleCount++;
    } else {
        $femaleCount++;
    }
}

if ($totalStewards > 0) {
    $averageAge = round($averageAge / $totalStewards, 1);
}

$show_page_title = true;
$page_subtitle = 'Danh sách và thông tin chi tiết tiếp viên';
$page_actions = '
  <a href="create_steward.php" class="btn btn-primary">
    <i class="bi bi-plus-lg me-2"></i>Thêm tiếp viên
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
            <div class="stats-value"><?php echo $activeStewards; ?></div>
            <div class="stats-label">Tiếp viên đang làm</div>
          </div>
          <div class="stats-icon text-success">
            <i class="bi bi-person-badge-fill"></i>
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
            <div class="stats-value"><?php echo $totalStewards; ?></div>
            <div class="stats-label">Tổng tiếp viên</div>
          </div>
          <div class="stats-icon text-primary">
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
            <div class="stats-value"><?php echo $maleCount; ?> / <?php echo $femaleCount; ?></div>
            <div class="stats-label">Nam / Nữ</div>
          </div>
          <div class="stats-icon text-warning">
            <i class="bi bi-gender-ambiguous"></i>
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
            <i class="bi bi-calendar-check"></i>
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
            <i class="bi bi-person-badge me-2"></i>Danh sách tiếp viên
          </h5>
          <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" id="exportBtn">
              <i class="bi bi-download"></i> Export
            </button>
            <a href="create_steward.php" class="btn btn-primary btn-sm">
              <i class="bi bi-plus-lg"></i> Thêm mới
            </a>
          </div>
        </div>

        <!-- Filters -->
        <form id="filterForm" class="row g-2 align-items-end mb-3" method="GET">
          <div class="col-md-6">
            <label class="form-label small">Tìm kiếm</label>
            <input class="form-control form-control-sm" type="search" 
                   name="q" id="q" 
                   value=""
                   placeholder="Tên, mã tiếp viên..." />
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
            <label class="form-label small">Tuổi</label>
            <select name="age_range" id="ageFilter" class="form-select form-select-sm">
              <option value="">Tất cả</option>
              <option value="under_25">Dưới 25</option>
              <option value="25_35">25-35</option>
              <option value="35_45">35-45</option>
              <option value="over_45">Trên 45</option>
            </select>
          </div>
          <div class="col-md-2">
            <button class="btn btn-sm btn-outline-primary w-100" type="submit">
              <i class="bi bi-search"></i> Tìm
            </button>
          </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
          <table class="table table-hover align-middle steward-table">
            <thead class="table-light">
              <tr>
                <th style="width: 100px;">Mã TV</th>
                <th style="width: 250px;">Tên tiếp viên</th>
                <th style="width: 100px;">Tuổi</th>
                <th style="width: 120px;">Giới tính</th>
                <th style="width: 150px;">Hành động</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($stewards)): ?>
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">
                    <i class="bi bi-inbox me-2"></i>Chưa có tiếp viên nào
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($stewards as $steward): ?>
                  <tr data-steward-id="<?php echo $steward['id']; ?>">
                    <td>
                      <span class="steward-code"><?php echo htmlspecialchars($steward['steward_code']); ?></span>
                    </td>
                    <td>
                      <div class="steward-info">
                        <div class="fw-semibold"><?php echo htmlspecialchars($steward['steward_name']); ?></div>
                      </div>
                    </td>
                    <td class="text-center"><?php echo $steward['age']; ?> tuổi</td>
                    <td>
                      <span class="gender-badge <?php echo $steward['gender'] === 'Nam' ? 'male' : 'female'; ?>">
                        <i class="bi bi-<?php echo $steward['gender'] === 'Nam' ? 'gender-male' : 'gender-female'; ?>"></i>
                        <?php echo htmlspecialchars($steward['gender']); ?>
                      </span>
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary viewBtn" 
                                data-id="<?php echo $steward['id']; ?>" 
                                title="Xem chi tiết">
                          <i class="bi bi-eye"></i>
                        </button>
                        <a href="edit_steward.php?id=<?php echo $steward['id']; ?>" 
                           class="btn btn-sm btn-outline-secondary"
                           title="Chỉnh sửa">
                          <i class="bi bi-pencil"></i>
                        </a>
                        <a href="../../handle/steward_process.php?action=delete&id=<?php echo $steward['id']; ?>" 
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Bạn có chắc muốn xóa tiếp viên này?')"
                           title="Xóa tiếp viên">
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
            Hiển thị <?php echo count($stewards); ?> tiếp viên
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
            </div>
            <span class="stat-content">
              <span class="stat-number"><?php echo $activeStewards; ?></span>
              <span class="stat-label">Đang bay</span>
            </span>
          </div>
          
          <div class="stat-item">
            <div class="stat-icon text-danger">
              <i class="bi bi-x-circle-fill"></i>
            </div>
            <span class="stat-content">
              <span class="stat-number"><?php echo $inactiveStewards; ?></span>
              <span class="stat-label">Đã nghỉ</span>
            </span>
          </div>
          
          <div class="stat-item">
            <div class="stat-icon text-info">
              <i class="bi bi-calendar"></i>
            </div>
            <span class="stat-content">
              <span class="stat-number"><?php echo $averageAge; ?></span>
              <span class="stat-label">Tuổi TB</span>
            </span>
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
          <a href="create_steward.php" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-2"></i>Thêm tiếp viên
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

<!-- Modal Chi tiết -->
<div class="modal fade" id="stewardModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-person-badge-fill me-2"></i>Chi tiết tiếp viên
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="stewardDetails">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <a href="#" id="editStewardLink" class="btn btn-primary" style="text-decoration: none;">Chỉnh sửa</a>
      </div>
    </div>
  </div>
</div>

<?php
include '../../includes/footer.php';
?>
