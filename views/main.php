<?php
$page_title = 'Dashboard - AirAgent Admin';
$page_description = 'Hệ thống quản lý các đại lý bán vé';
$current_page = 'main';
$css_files = ['../css/main.css'];
$js_files = ['../js/main.js'];

$username = 'Admin'; 
$role = 'Administrator';

require_once '../functions/agent_functions.php';

// Lấy danh sách agents từ database
$agents = getAllAgents();

// Tính toán 
$totalAgents = count($agents);
$activeAgents = 0;
$suspendedAgents = 0;
$totalSales = 0;
$currentMonth = date('n');

foreach ($agents as $agent) {
    if ($agent['currentState'] === 'active') {
        $activeAgents++;
    } elseif ($agent['currentState'] === 'suspended') {
        $suspendedAgents++;
    }
    $totalSales += (float)$agent['sales'];
}

// Include header
include '../includes/header.php';
?>
    <div class="row g-3 mb-4">
      <div class="col-sm-6 col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <small class="text-muted">Đại lý đang hoạt động</small>
                <div class="h4 mb-0"><?php echo $activeAgents; ?></div>
              </div>
              <div class="text-primary display-6"><i class="bi bi-people-fill"></i></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <small class="text-muted">Tổng số đại lý</small>
                <div class="h4 mb-0"><?php echo $totalAgents; ?></div>
              </div>
              <div class="text-success display-6"><i class="bi bi-building"></i></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-12 col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <small class="text-muted">Tổng doanh số</small>
                <div class="h5 mb-0"><?php echo number_format($totalSales, 0, ',', '.'); ?> VNĐ</div>
              </div>
              <div class="text-warning display-6"><i class="bi bi-currency-dollar"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="card-title mb-0">Danh sách đại lý</h5>
                  <div class="d-flex gap-2">
                  <a class="btn btn-outline-secondary btn-sm" href="../views/product/index.php"><i class="bi bi-download"></i> Sản phẩm</a>
                  <a class="btn btn-primary btn-sm" href="../views/agent/create_agent.php"><i class="bi bi-plus-lg"></i> Thêm đại lý</a>
                </div>
            </div>

            <form id="filterForm" class="row g-2 align-items-center mb-3" method="GET">
              <div class="col-md-6">
                <input class="form-control form-control-sm" type="search" 
                       value=""
                       placeholder="Tìm theo tên đại lý ..." />
              </div>
              <div class="col-auto">
                <select name="status" id="statusFilter" class="form-select form-select-sm">
                  <option value="">Tất cả trạng thái</option>
                  <option value="active">Hoạt động</option>
                  <option value="inactive">Ngưng hoạt động</option>
                  <option value="suspended">Tạm khóa</option>
                </select>
              </div>
              <div class="col-auto">
                <button class="btn btn-sm btn-outline-primary" type="submit"><i class="bi bi-search"></i> Tìm</button>
              </div>
              <div class="col-auto">
                <button class="btn btn-sm btn-outline-primary" type="submit"><i class="bi bi-search"></i>
                  <a href="../views/employee/index.php" style=" text-decoration: none;">Nhân viên</a>
                </button>
              </div>
              <?php if (!empty($searchQuery) || !empty($statusFilter)): ?>
              <div class="col-auto">
                <a href="main.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x-circle"></i> Xóa bộ lọc</a>
              </div>
              <?php endif; ?>
            </form>

            <div class="table-responsive" style="max-height:480px;">
              <table class="table table-hover align-middle small mb-0">
                <thead class="position-sticky top-0">
                  <tr>
                    <th>Mã</th>
                    <th>Tên đại lý</th>
                    <th>Người liên hệ</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Doanh số</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                <!-- Sửa phần table body -->
                  <tbody id="agentList">
                    <?php if (empty($agents)): ?>
                      <tr>
                        <td colspan="8" class="text-center text-muted">
                          <i class="bi bi-inbox me-2"></i>Chưa có đại lý nào
                        </td>
                      </tr>
                    <?php else: ?>
                      <?php foreach ($agents as $agent): ?>
                        <tr>
                          <td class="fw-semibold"><?php echo htmlspecialchars($agent['agent_code']); ?></td>
                          <td><?php echo htmlspecialchars($agent['agent_name']); ?></td>
                          <td><?php echo htmlspecialchars($agent['contactPerson']); ?></td>
                          <td><?php echo htmlspecialchars($agent['email']); ?></td>
                          <td><?php echo htmlspecialchars($agent['phoneNumber']); ?></td>
                          <td>
                            <?php
                            $statusClass = '';
                            $statusText = '';
                            switch ($agent['currentState']) {
                              case 'active':
                                $statusClass = 'bg-success';
                                $statusText = 'Hoạt động';
                                break;
                              case 'inactive':
                                $statusClass = 'bg-secondary';
                                $statusText = 'Ngưng hoạt động';
                                break;
                              case 'suspended':
                                $statusClass = 'bg-warning text-dark';
                                $statusText = 'Tạm khóa';
                                break;
                              default:
                                $statusClass = 'bg-light text-dark';
                                $statusText = 'Không xác định';
                            }
                            ?>
                            <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                          </td>
                          <td class="text-end"><?php echo number_format($agent['sales'], 0, ',', '.'); ?> VNĐ</td>
                          
                          <td>
                            <div class="btn-group" role="group">
                              <a href="agent/edit_agent.php?id=<?php echo $agent['id']; ?>" 
                                class="btn btn-sm btn-outline-primary"
                                title="Sửa thông tin">
                                <i class="bi bi-pencil"></i> Sửa
                              </a>
                              <a href="../handle/agent_process.php?action=delete&id=<?php echo $agent['id']; ?>" 
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Bạn có chắc muốn xóa đại lý này?')"
                                title="Xóa đại lý">
                                <i class="bi bi-trash"></i> Xóa
                              </a>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
              </table>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center">
              <div class="text-muted small">Hiển thị <?php echo count($agents); ?> đại lý</div>
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

      <!-- Right: Form / quick info -->
      <div class="col-lg-4">
        <div class="card shadow-sm" style="position: relative;">
          <div class="card-body">
            <h6 class="card-title">Tổng quan nhanh</h6>
            <ul class="list-unstyled small mb-3">
              <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Đại lý hoạt động: <strong><?php echo $activeAgents; ?></strong></li>
              <li class="mb-2"><i class="bi bi-exclamation-triangle text-warning me-2"></i> Đang tạm khóa: <strong><?php echo $suspendedAgents; ?></strong></li>
              <li class="mb-2"><i class="bi bi-graph-up text-primary me-2"></i> Tổng đại lý: <strong><?php echo $totalAgents; ?></strong></li>
              <li class="mb-2"><i class="bi bi-currency-dollar text-info me-2"></i> Tổng doanh số: <strong><?php echo number_format($totalSales, 0, ',', '.'); ?> VNĐ</strong></li>
            </ul>

            <div class="mb-3">
              <label class="form-label small">Lọc nhanh theo vùng</label>
              <select class="form-select form-select-sm">
                <option>Tất cả</option>
                <option>Miền Bắc</option>
                <option>Miền Trung</option>
                <option>Miền Nam</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label small">Chức vụ người dùng</label>
              <select class="form-select form-select-sm" id="userRoleSelect">
                <option value="">Chọn chức vụ</option>
                <option value="nhanvien">Nhân viên</option>
                <option value="quanly">Quản lý</option>
                <option value="tongquanly">Tổng quản lý</option>
                <option value="giamsat">Giám sát</option>
                <option value="ketoan">Kế toán</option>
              </select>
            </div>

            <div class="d-grid">
              <button class="btn btn-outline-danger btn-sm" >Tạm khóa nhiều</button>
            </div>
          </div>
        </div>

        <div class="mt-3 card shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Gợi ý</h6>
            <p class="small text-muted mb-0">Kết nối API để đồng bộ danh sách đại lý, tích hợp báo cáo hàng tháng và tạo hệ thống phân quyền cho đại lý</p>
          </div>
        </div>
      </div>
    </div>

<!-- Modal: Add / Edit Agent -->
<div class="modal fade" id="agentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="agentForm">
        <div class="modal-header">
          <h5 class="modal-title" id="agentModalTitle">Thêm đại lý mới</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Mã đại lý</label>
              <input type="text" class="form-control" id="agentCode" required>
            </div>
            <div class="col-md-8">
              <label class="form-label">Tên đại lý</label>
              <input type="text" class="form-control" id="agentName" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Người liên hệ</label>
              <input type="text" class="form-control" id="contactName">
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" id="email">
            </div>
            <div class="col-md-6">
              <label class="form-label">Điện thoại</label>
              <input type="tel" class="form-control" id="phone">
            </div>
            <div class="col-md-6">
              <label class="form-label">Trạng thái</label>
              <select class="form-select" id="status">
                <option value="active">Hoạt động</option>
                <option value="inactive">Ngưng hoạt động</option>
                <option value="suspended">Tạm khóa</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Ghi chú (tùy chọn)</label>
              <textarea class="form-control" id="note" rows="2"></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
// Page specific scripts


// Include footer
include '../includes/footer.php';
?>