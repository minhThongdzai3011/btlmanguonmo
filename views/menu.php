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
require_once '../functions/captain_function.php';
require_once '../functions/steward_funtion.php';
require_once '../functions/flight_functions.php';
require_once '../functions/airline_function.php';
require_once '../functions/user_function.php';

$products = getAllProducts();
$agents = getAllAgents();
$employees = getAllEmployees();
$captains = getAllCaptains();
$stewards = getAllStewards();
$flights = getAllFlights();
$airlines = getAllAirlines();
$users = getAllUsers();

// Tính toán thống kê
$totalProducts = count($products);
$totalAgents = count($agents);
$totalEmployees = count($employees);

// Tính tổng giá trị vé
$totalProductValue = 0;
foreach ($products as $product) {
    $totalProductValue += ($product['price_economy'] * $product['quantity_economy']) + 
                          ($product['price_vip'] * $product['quantity_vip']) + 
                          ($product['price_business'] * $product['quantity_business']);
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

// Tính toán captain statistics
$totalCaptains = count($captains);
$captainMaleCount = 0;
$captainFemaleCount = 0;
foreach ($captains as $captain) {
    if ($captain['gender'] === 'Nam') {
        $captainMaleCount++;
    } else {
        $captainFemaleCount++;
    }
}

// Tính toán steward statistics
$totalStewards = count($stewards);
$stewardMaleCount = 0;
$stewardFemaleCount = 0;
foreach ($stewards as $steward) {
    if ($steward['gender'] === 'Nam') {
        $stewardMaleCount++;
    } else {
        $stewardFemaleCount++;
    }
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
    <div class="col-xl-2 col-lg-4 col-md-6">
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
    <div class="col-xl-2 col-lg-4 col-md-6">
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
    <div class="col-xl-2 col-lg-4 col-md-6">
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

    <!-- Captains Card -->
    <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="stats-card stats-card-info" style="cursor: pointer;" onclick="window.location.href='captain/index.php'">
            <div class="stats-icon">
                <i class="bi bi-airplane-engines"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-number" data-target="<?php echo $totalCaptains; ?>">0</h3>
                <p class="stats-label">Cơ trưởng</p>
                <div class="stats-footer">
                    <span class="stats-text">
                        <?php echo $captainMaleCount; ?> Nam / <?php echo $captainFemaleCount; ?> Nữ
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stewards Card -->
    <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="stats-card stats-card-danger" style="cursor: pointer;" onclick="window.location.href='steward/index.php'">
            <div class="stats-icon">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-number" data-target="<?php echo $totalStewards; ?>">0</h3>
                <p class="stats-label">Tiếp viên</p>
                <div class="stats-footer">
                    <span class="stats-text">
                        <?php echo $stewardMaleCount; ?> Nam / <?php echo $stewardFemaleCount; ?> Nữ
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="stats-card stats-card-secondary">
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

<!-- User Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stats-card stats-card-info">
            <div class="stats-icon">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-number" data-target="<?php echo count($users); ?>">0</h3>
                <p class="stats-label">Người dùng</p>
                <div class="stats-footer">
                    <span class="stats-text">Tài khoản user hệ thống</span>
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
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="captains-tab" data-bs-toggle="tab" 
                                data-bs-target="#captains" type="button" role="tab">
                            <i class="bi bi-airplane-engines me-2"></i>Cơ trưởng
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="stewards-tab" data-bs-toggle="tab" 
                                data-bs-target="#stewards" type="button" role="tab">
                            <i class="bi bi-person-badge me-2"></i>Tiếp viên
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="flights-tab" data-bs-toggle="tab" 
                                data-bs-target="#flights" type="button" role="tab">
                            <i class="bi bi-airplane me-2"></i>Chuyến bay
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="airlines-tab" data-bs-toggle="tab" 
                                data-bs-target="#airlines" type="button" role="tab">
                            <i class="bi bi-airplane-engines-fill me-2"></i>Hãng hàng không
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
                                        <th>Cơ trưởng</th>
                                        <th>Tiếp viên</th>
                                        <th>Giá PT</th>
                                        <th>Giá VIP</th>
                                        <th>Giá BS</th>
                                        <th>Số lượng</th>
                                        <th>Tổng giá trị</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($products)): ?>
                                        <tr>
                                            <td colspan="13" class="text-center py-4">
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
                                                <td>
                                                    <small class="text-muted d-block"><?php echo htmlspecialchars($product['captain_code'] ?? 'N/A'); ?></small>
                                                    <strong><?php echo htmlspecialchars($product['captain_name'] ?? 'Chưa có'); ?></strong>
                                                </td>
                                                <td>
                                                    <small class="text-muted d-block"><?php echo htmlspecialchars($product['steward_code'] ?? 'N/A'); ?></small>
                                                    <strong><?php echo htmlspecialchars($product['steward_name'] ?? 'Chưa có'); ?></strong>
                                                </td>
                                                <td><?php echo number_format($product['price_economy'], 0, ',', '.'); ?></td>
                                                <td><?php echo number_format($product['price_vip'], 0, ',', '.'); ?></td>
                                                <td><?php echo number_format($product['price_business'], 0, ',', '.'); ?></td>
                                                <td>
                                                    <?php 
                                                    $totalQuantity = $product['quantity_economy'] + $product['quantity_vip'] + $product['quantity_business'];
                                                    $totalValue = ($product['price_economy'] * $product['quantity_economy']) + 
                                                                  ($product['price_vip'] * $product['quantity_vip']) + 
                                                                  ($product['price_business'] * $product['quantity_business']);
                                                    ?>
                                                    <div>
                                                        <strong><?php echo number_format($totalQuantity); ?> vé</strong>
                                                    </div>
                                                    <small class="text-muted">
                                                        PT: <?php echo $product['quantity_economy']; ?> | 
                                                        VIP: <?php echo $product['quantity_vip']; ?> | 
                                                        BS: <?php echo $product['quantity_business']; ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <strong>
                                                        <?php echo number_format($totalValue, 0, ',', '.'); ?> VNĐ
                                                    </strong>
                                                </td>
                                                <td>
                                                    <?php if ($totalQuantity > 30): ?>
                                                        <span class="badge bg-success">Còn nhiều</span>
                                                    <?php elseif ($totalQuantity > 10): ?>
                                                        <span class="badge bg-info">Còn hàng</span>
                                                    <?php elseif ($totalQuantity > 0): ?>
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
                            <a href="../views/agent/main.php" class="btn btn-success">
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

                    <!-- Captains Tab -->
                    <div class="tab-pane fade" id="captains" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="bi bi-airplane-engines me-2"></i>Danh sách cơ trưởng
                            </h5>
                            <a href="captain/index.php" class="btn btn-info">
                                <i class="bi bi-plus-lg me-2"></i>Quản lý cơ trưởng
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã cơ trưởng</th>
                                        <th>Tên cơ trưởng</th>
                                        <th>Tuổi</th>
                                        <th>Giới tính</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($captains)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="bi bi-inbox display-4 text-muted"></i>
                                                <p class="text-muted mt-2">Chưa có cơ trưởng nào</p>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($captains as $index => $captain): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><strong><?php echo htmlspecialchars($captain['captain_code']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($captain['captain_name']); ?></td>
                                                <td><?php echo htmlspecialchars($captain['age']); ?></td>
                                                <td>
                                                    <?php if (strtolower($captain['gender']) == 'nam' || strtolower($captain['gender']) == 'male'): ?>
                                                        <span class="badge bg-primary"><i class="bi bi-gender-male"></i> Nam</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger"><i class="bi bi-gender-female"></i> Nữ</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="captain/edit_captain.php?id=<?php echo $captain['id']; ?>" 
                                                           class="btn btn-outline-primary" title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="../handle/captain_process.php?action=delete&id=<?php echo $captain['id']; ?>" 
                                                           class="btn btn-outline-danger"
                                                           onclick="return confirm('Bạn có chắc chắn muốn xóa cơ trưởng này?')" 
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

                    <!-- Stewards Tab -->
                    <div class="tab-pane fade" id="stewards" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="bi bi-person-badge me-2"></i>Danh sách tiếp viên
                            </h5>
                            <a href="steward/index.php" class="btn btn-danger">
                                <i class="bi bi-plus-lg me-2"></i>Quản lý tiếp viên
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã tiếp viên</th>
                                        <th>Tên tiếp viên</th>
                                        <th>Tuổi</th>
                                        <th>Giới tính</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($stewards)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="bi bi-inbox display-4 text-muted"></i>
                                                <p class="text-muted mt-2">Chưa có tiếp viên nào</p>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($stewards as $index => $steward): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><strong><?php echo htmlspecialchars($steward['steward_code']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($steward['steward_name']); ?></td>
                                                <td><?php echo htmlspecialchars($steward['age']); ?></td>
                                                <td>
                                                    <?php if (strtolower($steward['gender']) == 'nam' || strtolower($steward['gender']) == 'male'): ?>
                                                        <span class="badge bg-primary"><i class="bi bi-gender-male"></i> Nam</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger"><i class="bi bi-gender-female"></i> Nữ</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="steward/edit_steward.php?id=<?php echo $steward['id']; ?>" 
                                                           class="btn btn-outline-primary" title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="../handle/steward_process.php?action=delete&id=<?php echo $steward['id']; ?>" 
                                                           class="btn btn-outline-danger"
                                                           onclick="return confirm('Bạn có chắc chắn muốn xóa tiếp viên này?')" 
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

                    <!-- Flights Tab -->
                    <div class="tab-pane fade" id="flights" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="bi bi-airplane me-2"></i>Danh sách chuyến bay
                            </h5>
                            <a href="flight/index.php" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-2"></i>Quản lý chuyến bay
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã chuyến bay</th>
                                        <th>Tên chuyến bay</th>
                                        <th>Hãng HK</th>
                                        <th>Cơ trưởng</th>
                                        <th>Tiếp viên</th>
                                        <th>Điểm đi</th>
                                        <th>Điểm đến</th>
                                        <th>Thời gian</th>
                                        <th>Thao tác</th>
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
                                                <td><strong><?php echo htmlspecialchars($flight['flight_code']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($flight['flight_name']); ?></td>
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
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="flight/edit_flight.php?id=<?php echo $flight['id']; ?>" 
                                                           class="btn btn-outline-primary" title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="../handle/flight_process.php?action=delete&id=<?php echo $flight['id']; ?>" 
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

                    <!-- Airlines Tab -->
                    <div class="tab-pane fade" id="airlines" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="bi bi-airplane-engines-fill me-2"></i>Danh sách hãng hàng không
                            </h5>
                            <a href="airline/index.php" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-2"></i>Quản lý hãng bay
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle data-table">
                                <thead>
                                    <tr>
                                        <th width="10%">#</th>
                                        <th width="20%">Mã hãng</th>
                                        <th width="50%">Tên hãng hàng không</th>
                                        <th width="20%" class="text-center">Thao tác</th>
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
                                                <td><strong><?php echo htmlspecialchars($airline['airline_name']); ?></strong></td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="airline/edit_airline.php?id=<?php echo $airline['id']; ?>" 
                                                           class="btn btn-outline-primary" title="Chỉnh sửa">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="../handle/airline_process.php?action=delete&id=<?php echo $airline['id']; ?>" 
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
