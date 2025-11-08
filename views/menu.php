<?php
$page_title = 'Tổng quan - AirAgent Admin';
$page_description = 'Quản lý tổng quan về vé máy bay, đại lý và nhân viên';
$current_page = 'menu';
$css_files = ['../css/main.css', '../css/menu.css'];
$js_files = ['https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', '../js/menu.js'];

$username = 'Admin';
$role = 'Administrator';

// Lấy dữ liệu từ database
require_once '../functions/product.function.php';
require_once '../functions/agent_functions.php';
require_once '../functions/employee_function.php';

$products = getAllProducts();
$agents = getAllAgents();
$employees = getAllEmployees();

// Tính toán thống kê
$totalProducts = count($products);
$totalAgents = count($agents);
$totalEmployees = count($employees);

// Tính tổng giá trị vé
$totalProductValue = 0;
foreach ($products as $product) {
    $totalProductValue += $product['price'] * $product['quantity'];
}

// Tính tổng doanh thu đại lý
$totalAgentSales = 0;
foreach ($agents as $agent) {
    $totalAgentSales += floatval($agent['sales']);
}

// Tính tổng lương nhân viên
$totalEmployeeSalary = 0;
foreach ($employees as $employee) {
    $totalEmployeeSalary += floatval($employee['salary']);
}

// Page header settings
$show_page_title = true;
$page_subtitle = 'Xem tổng quan thống kê và quản lý hệ thống';

// Include header
include '../includes/header.php';
?>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <!-- Products Card -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stats-card stats-card-primary">
            <div class="stats-icon">
                <i class="bi bi-ticket-perforated"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-number" data-target="<?php echo $totalProducts; ?>">0</h3>
                <p class="stats-label">Tổng số vé</p>
                <div class="stats-footer">
                    <span class="stats-value">
                        <?php echo number_format($totalProductValue, 0, ',', '.'); ?> VNĐ
                    </span>
                    <span class="stats-text">Tổng giá trị</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Agents Card -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stats-card stats-card-success">
            <div class="stats-icon">
                <i class="bi bi-building"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-number" data-target="<?php echo $totalAgents; ?>">0</h3>
                <p class="stats-label">Đại lý</p>
                <div class="stats-footer">
                    <span class="stats-value">
                        <?php echo number_format($totalAgentSales, 0, ',', '.'); ?> VNĐ
                    </span>
                    <span class="stats-text">Doanh thu</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees Card -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stats-card stats-card-warning">
            <div class="stats-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-number" data-target="<?php echo $totalEmployees; ?>">0</h3>
                <p class="stats-label">Nhân viên</p>
                <div class="stats-footer">
                    <span class="stats-value">
                        <?php echo number_format($totalEmployeeSalary, 0, ',', '.'); ?> VNĐ
                    </span>
                    <span class="stats-text">Tổng lương</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stats-card stats-card-info">
            <div class="stats-icon">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-number" data-target="<?php echo round(($totalAgentSales / 1000000), 1); ?>">0</h3>
                <p class="stats-label">Doanh thu (Triệu)</p>
                <div class="stats-footer">
                    <span class="stats-badge stats-badge-success">
                        <i class="bi bi-arrow-up"></i> 12.5%
                    </span>
                    <span class="stats-text">So với tháng trước</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-4">
    <!-- Revenue Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up me-2"></i>Doanh thu theo tháng
                </h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <!-- Products Distribution Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Phân bố vé
                </h5>
            </div>
            <div class="card-body">
                <canvas id="productsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Additional Charts Row -->
<div class="row g-4 mb-4">
    <!-- Agent Performance Chart -->
    <div class="col-xl-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-bar-chart me-2"></i>Top 5 đại lý doanh thu cao
                </h5>
            </div>
            <div class="card-body">
                <canvas id="agentChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <!-- Employee Salary Distribution -->
    <div class="col-xl-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-people-fill me-2"></i>Phân bố lương nhân viên
                </h5>
            </div>
            <div class="card-body">
                <canvas id="salaryChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Tabs -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="menuTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="products-tab" data-bs-toggle="tab" 
                                data-bs-target="#products" type="button" role="tab">
                            <i class="bi bi-ticket-perforated me-2"></i>Vé máy bay
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="agents-tab" data-bs-toggle="tab" 
                                data-bs-target="#agents" type="button" role="tab">
                            <i class="bi bi-building me-2"></i>Đại lý
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="employees-tab" data-bs-toggle="tab" 
                                data-bs-target="#employees" type="button" role="tab">
                            <i class="bi bi-people me-2"></i>Nhân viên
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="menuTabsContent">
                    
                    <!-- Products Tab -->
                    <div class="tab-pane fade show active" id="products" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="bi bi-ticket-perforated me-2"></i>Danh sách vé máy bay
                            </h5>
                            <a href="../views/product/index.php" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-2"></i>Quản lý vé
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã vé</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Hình ảnh</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Tổng giá trị</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($products)): ?>
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <i class="bi bi-inbox display-4 text-muted"></i>
                                                <p class="text-muted mt-2">Chưa có vé nào</p>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($products as $index => $product): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><strong><?php echo htmlspecialchars($product['product_code']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                                <td>
                                                    <?php if (!empty($product['image'])): ?>
                                                        <img src="../img/<?php echo htmlspecialchars($product['image']); ?>" 
                                                             alt="Product" class="table-img">
                                                    <?php else: ?>
                                                        <span class="text-muted">Không có ảnh</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        <?php echo number_format($product['quantity']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong>
                                                        <?php echo number_format($product['price'] * $product['quantity'], 0, ',', '.'); ?> VNĐ
                                                    </strong>
                                                </td>
                                                <td>
                                                    <?php if ($product['quantity'] > 10): ?>
                                                        <span class="badge bg-success">Còn hàng</span>
                                                    <?php elseif ($product['quantity'] > 0): ?>
                                                        <span class="badge bg-warning">Sắp hết</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Hết hàng</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="product/edit_product.php?id=<?php echo $product['id']; ?>" 
                                                           class="btn btn-outline-primary" title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="../handle/product_process.php?action=delete&id=<?php echo $product['id']; ?>" 
                                                           class="btn btn-outline-danger"
                                                           onclick="return confirm('Bạn có chắc chắn muốn xóa vé này?')" 
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

                    <!-- Agents Tab -->
                    <div class="tab-pane fade" id="agents" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="bi bi-building me-2"></i>Danh sách đại lý
                            </h5>
                            <a href="main.php" class="btn btn-success">
                                <i class="bi bi-plus-lg me-2"></i>Quản lý đại lý
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã đại lý</th>
                                        <th>Tên đại lý</th>
                                        <th>Người liên hệ</th>
                                        <th>Email</th>
                                        <th>Điện thoại</th>
                                        <th>Doanh thu</th>
                                        <th>Hoa hồng</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($agents)): ?>
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <i class="bi bi-inbox display-4 text-muted"></i>
                                                <p class="text-muted mt-2">Chưa có đại lý nào</p>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($agents as $index => $agent): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><strong><?php echo htmlspecialchars($agent['agent_code']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($agent['agent_name']); ?></td>
                                                <td>
                                                    <div>
                                                        <?php echo htmlspecialchars($agent['contactPerson']); ?>
                                                        <?php if (!empty($agent['position'])): ?>
                                                            <br><small class="text-muted"><?php echo htmlspecialchars($agent['position']); ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($agent['email']); ?></td>
                                                <td><?php echo htmlspecialchars($agent['phoneNumber']); ?></td>
                                                <td><?php echo number_format($agent['sales'], 0, ',', '.'); ?> VNĐ</td>
                                                <td><?php echo number_format($agent['commissionRate'], 1); ?>%</td>
                                                <td>
                                                    <?php 
                                                    $state = strtolower($agent['currentState']);
                                                    if ($state == 'active' || $state == 'hoạt động'): 
                                                    ?>
                                                        <span class="badge bg-success">Hoạt động</span>
                                                    <?php elseif ($state == 'inactive' || $state == 'ngừng'): ?>
                                                        <span class="badge bg-danger">Ngừng</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning"><?php echo htmlspecialchars($agent['currentState']); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="agent/edit_agent.php?id=<?php echo $agent['id']; ?>" 
                                                           class="btn btn-outline-primary" title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="../handle/agent_process.php?action=delete&id=<?php echo $agent['id']; ?>" 
                                                           class="btn btn-outline-danger"
                                                           onclick="return confirm('Bạn có chắc chắn muốn xóa đại lý này?')" 
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

                    <!-- Employees Tab -->
                    <div class="tab-pane fade" id="employees" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="bi bi-people me-2"></i>Danh sách nhân viên
                            </h5>
                            <a href="../views/employee/index.php" class="btn btn-warning">
                                <i class="bi bi-plus-lg me-2"></i>Quản lý nhân viên
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã NV</th>
                                        <th>Tên nhân viên</th>
                                        <th>Đại lý</th>
                                        <th>Chức vụ</th>
                                        <th>Tuổi</th>
                                        <th>Giới tính</th>
                                        <th>Email</th>
                                        <th>Điện thoại</th>
                                        <th>Lương</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($employees)): ?>
                                        <tr>
                                            <td colspan="11" class="text-center py-4">
                                                <i class="bi bi-inbox display-4 text-muted"></i>
                                                <p class="text-muted mt-2">Chưa có nhân viên nào</p>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($employees as $index => $employee): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><strong><?php echo htmlspecialchars($employee['employee_code']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($employee['employee_name']); ?></td>
                                                <td>
                                                    <div>
                                                        <small class="text-muted"><?php echo htmlspecialchars($employee['agent_code']); ?></small>
                                                        <?php if (!empty($employee['agent_name'])): ?>
                                                            <br><?php echo htmlspecialchars($employee['agent_name']); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($employee['position']); ?></td>
                                                <td><?php echo htmlspecialchars($employee['age']); ?></td>
                                                <td>
                                                    <?php if (strtolower($employee['gender']) == 'nam' || strtolower($employee['gender']) == 'male'): ?>
                                                        <i class="bi bi-gender-male text-primary"></i> Nam
                                                    <?php else: ?>
                                                        <i class="bi bi-gender-female text-danger"></i> Nữ
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($employee['email']); ?></td>
                                                <td><?php echo htmlspecialchars($employee['phone']); ?></td>
                                                <td><?php echo number_format($employee['salary'], 0, ',', '.'); ?> VNĐ</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="employee/edit_employee.php?id=<?php echo $employee['id']; ?>" 
                                                           class="btn btn-outline-primary" title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="../handle/employee_process.php?action=delete&id=<?php echo $employee['id']; ?>" 
                                                           class="btn btn-outline-danger"
                                                           onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')" 
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
    </div>
</div>

<?php
// Include footer
include '../includes/footer.php';
?>

<!-- Chart Data Script -->
<script>
// Prepare data for charts
const chartData = {
    products: <?php echo json_encode($products); ?>,
    agents: <?php echo json_encode($agents); ?>,
    employees: <?php echo json_encode($employees); ?>,
    stats: {
        totalProducts: <?php echo $totalProducts; ?>,
        totalAgents: <?php echo $totalAgents; ?>,
        totalEmployees: <?php echo $totalEmployees; ?>,
        totalProductValue: <?php echo $totalProductValue; ?>,
        totalAgentSales: <?php echo $totalAgentSales; ?>,
        totalEmployeeSalary: <?php echo $totalEmployeeSalary; ?>
    }
};
</script>
