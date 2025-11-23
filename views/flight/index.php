<?php
// Page configuration
$page_title = 'Quản lý chuyến bay - AirAgent Admin';
$page_description = 'Hệ thống quản lý thông tin chuyến bay';
$current_page = 'flight';
$css_files = ['../../css/main.css', '../../css/flights/index.css'];
$js_files = ['../../js/flights/index.js'];

$username = 'Admin';
$role = 'Administrator';

// Lấy data từ database
require_once '../../handle/flight_process.php';

$flights = handleGetAllFlights();

// Tính số lượng chuyến bay
$totalFlights = count($flights);
$activeFlights = $totalFlights;
$completedFlights = 0;

$show_page_title = true;
$page_subtitle = 'Danh sách và thông tin chi tiết chuyến bay';
$page_actions = '
  <a href="create_flight.php" class="btn btn-primary">
    <i class="bi bi-plus-lg me-2"></i>Thêm chuyến bay
  </a>
';

// Hiển thị thông báo
$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';

include '../../includes/header.php';
?>

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

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-4">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo $activeFlights; ?></div>
            <div class="stats-label">Chuyến bay hoạt động</div>
          </div>
          <div class="stats-icon text-success">
            <i class="bi bi-airplane-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-4">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo $totalFlights; ?></div>
            <div class="stats-label">Tổng chuyến bay</div>
          </div>
          <div class="stats-icon text-primary">
            <i class="bi bi-airplane-engines"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-4">
    <div class="card stats-card h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo $completedFlights; ?></div>
            <div class="stats-label">Chuyến bay hoàn thành</div>
          </div>
          <div class="stats-icon text-warning">
            <i class="bi bi-check-circle-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">
            <i class="bi bi-airplane me-2"></i>Danh sách chuyến bay
          </h5>
          <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" id="exportBtn">
              <i class="bi bi-download"></i> Xuất
            </button>
            <a href="create_flight.php" class="btn btn-primary btn-sm">
              <i class="bi bi-plus-lg"></i> Thêm mới
            </a>
          </div>
        </div>

        <!-- Filters -->
        <form id="filterForm" class="row g-2 align-items-end mb-4" method="GET">
          <div class="col-md-4">
            <label class="form-label small">Tìm kiếm</label>
            <input class="form-control form-control-sm" type="search" 
                   name="search" id="searchInput" 
                   placeholder="Mã, tên chuyến bay, điểm đi/đến..." />
          </div>
          <div class="col-md-3">
            <label class="form-label small">Hãng hàng không</label>
            <select name="airline" id="airlineFilter" class="form-select form-select-sm">
              <option value="">Tất cả</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label small">Trạng thái</label>
            <select name="status" id="statusFilter" class="form-select form-select-sm">
              <option value="">Tất cả</option>
              <option value="active">Hoạt động</option>
              <option value="completed">Hoàn thành</option>
            </select>
          </div>
          <div class="col-md-2">
            <button class="btn btn-sm btn-primary w-100" type="submit">
              <i class="bi bi-search"></i> Tìm
            </button>
          </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th width="5%">#</th>
                <th width="12%">Mã chuyến bay</th>
                <th width="20%">Tên chuyến bay</th>
                <th width="10%">Hãng HK</th>
                <th width="10%">Cơ trưởng</th>
                <th width="10%">Tiếp viên</th>
                <th width="10%">Điểm đi</th>
                <th width="10%">Điểm đến</th>
                <th width="10%">Thời gian</th>
                <th width="8%" class="text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($flights)): ?>
                <tr>
                  <td colspan="10" class="text-center py-4">
                    <i class="bi bi-inbox display-4 text-muted"></i>
                    <p class="text-muted mt-2">Chưa có chuyến bay nào</p>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($flights as $index => $flight): ?>
                  <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td>
                      <span class="badge bg-primary"><?php echo htmlspecialchars($flight['flight_code']); ?></span>
                    </td>
                    <td>
                      <strong><?php echo htmlspecialchars($flight['flight_name']); ?></strong>
                    </td>
                    <td><?php echo htmlspecialchars($flight['airline_code'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($flight['captain_code'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($flight['steward_code'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($flight['origin']); ?></td>
                    <td><?php echo htmlspecialchars($flight['destination']); ?></td>
                    <td>
                      <small class="text-muted">
                        <?php echo date('d/m/Y H:i', strtotime($flight['flight_time'])); ?>
                      </small>
                    </td>
                    <td class="text-center">
                      <div class="btn-group btn-group-sm">
                        <a href="edit_flight.php?id=<?php echo $flight['id']; ?>" 
                           class="btn btn-outline-primary" title="Chỉnh sửa">
                          <i class="bi bi-pencil"></i>
                        </a>
                        <a href="../../handle/flight_process.php?action=delete&id=<?php echo $flight['id']; ?>" 
                           class="btn btn-outline-danger"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa chuyến bay này?')" 
                           title="Xóa">
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
      </div>
    </div>
  </div>
</div>

<?php
include '../../includes/footer.php';
?>
