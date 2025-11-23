<?php
// Page configuration
$page_title = 'Quản lý hãng hàng không - AirAgent Admin';
$page_description = 'Hệ thống quản lý thông tin hãng hàng không';
$current_page = 'airline';
$css_files = ['../../css/main.css', '../../css/airlines/index.css'];
$js_files = ['../../js/airlines/index.js'];

$username = 'Admin';
$role = 'Administrator';

// Lấy data từ database
require_once '../../handle/airline_process.php';

$airlines = handleGetAllAirlines();

// Tính số lượng
$totalAirlines = count($airlines);

$show_page_title = true;
$page_subtitle = 'Danh sách và thông tin chi tiết hãng hàng không';
$page_actions = '
  <a href="create_airline.php" class="btn btn-primary">
    <i class="bi bi-plus-lg me-2"></i>Thêm hãng bay
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
            <div class="stats-value"><?php echo $totalAirlines; ?></div>
            <div class="stats-label">Tổng hãng hàng không</div>
          </div>
          <div class="stats-icon text-primary">
            <i class="bi bi-airplane-engines-fill"></i>
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
            <div class="stats-value"><?php echo $totalAirlines; ?></div>
            <div class="stats-label">Hãng hoạt động</div>
          </div>
          <div class="stats-icon text-success">
            <i class="bi bi-check-circle-fill"></i>
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
            <div class="stats-value">0</div>
            <div class="stats-label">Chuyến bay hôm nay</div>
          </div>
          <div class="stats-icon text-warning">
            <i class="bi bi-calendar-check"></i>
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
            <i class="bi bi-airplane-engines me-2"></i>Danh sách hãng hàng không
          </h5>
          <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" id="exportBtn">
              <i class="bi bi-download"></i> Xuất
            </button>
            <a href="create_airline.php" class="btn btn-primary btn-sm">
              <i class="bi bi-plus-lg"></i> Thêm mới
            </a>
          </div>
        </div>

        <!-- Filters -->
        <form id="filterForm" class="row g-2 align-items-end mb-4" method="GET">
          <div class="col-md-6">
            <label class="form-label small">Tìm kiếm</label>
            <input class="form-control form-control-sm" type="search" 
                   name="search" id="searchInput" 
                   placeholder="Mã, tên hãng..." />
          </div>
          <div class="col-md-4">
            <label class="form-label small">Sắp xếp</label>
            <select name="sort" id="sortFilter" class="form-select form-select-sm">
              <option value="name_asc">Tên A-Z</option>
              <option value="name_desc">Tên Z-A</option>
              <option value="code_asc">Mã tăng dần</option>
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
                <th width="15%">Mã hãng</th>
                <th width="60%">Tên hãng hàng không</th>
                <th width="10%" class="text-center">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($airlines)): ?>
                <tr>
                  <td colspan="4" class="text-center py-4">
                    <i class="bi bi-inbox display-4 text-muted"></i>
                    <p class="text-muted mt-2">Chưa có hãng hàng không nào</p>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($airlines as $index => $airline): ?>
                  <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td>
                      <span class="badge bg-primary fs-6"><?php echo htmlspecialchars($airline['airline_code']); ?></span>
                    </td>
                    <td>
                      <strong><?php echo htmlspecialchars($airline['airline_name']); ?></strong>
                    </td>
                    <td class="text-center">
                      <div class="btn-group btn-group-sm">
                        <a href="edit_airline.php?id=<?php echo $airline['id']; ?>" 
                           class="btn btn-outline-primary" title="Chỉnh sửa">
                          <i class="bi bi-pencil"></i>
                        </a>
                        <a href="../../handle/airline_process.php?action=delete&id=<?php echo $airline['id']; ?>" 
                           class="btn btn-outline-danger"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa hãng hàng không này?')" 
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
