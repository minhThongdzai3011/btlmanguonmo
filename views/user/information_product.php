<?php
session_start();

// Lấy username từ session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Khách';

// Lấy ID từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    header("Location: ../user.php?error=ID không hợp lệ");
    exit();
}

// Lấy thông tin product và flight
require_once '../../functions/product.function.php';
require_once '../../functions/flight_functions.php';
require_once '../../functions/airline_function.php';
require_once '../../functions/captain_function.php';
require_once '../../functions/steward_funtion.php';

$product = getProductById($product_id);

if (!$product) {
    header("Location: ../user.php?error=Không tìm thấy sản phẩm");
    exit();
}

// Lấy thông tin captain và steward
$captain = null;
$steward = null;
if (!empty($product['captain_code'])) {
    $captains = getAllCaptains();
    foreach ($captains as $c) {
        if ($c['captain_code'] == $product['captain_code']) {
            $captain = $c;
            break;
        }
    }
}
if (!empty($product['steward_code'])) {
    $stewards = getAllStewards();
    foreach ($stewards as $s) {
        if ($s['steward_code'] == $product['steward_code']) {
            $steward = $s;
            break;
        }
    }
}

// Tính tổng số vé còn lại
$totalQuantity = $product['quantity_economy'] + $product['quantity_vip'] + $product['quantity_business'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Chuyến bay - <?php echo htmlspecialchars($product['product_name']); ?> - SkyLine Travel</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/723/723955.png" type="image/png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/user/information_product.css">
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-plane me-2 text-warning"></i> SkyLine Travel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="user.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="booking_history.php">Lịch sử đặt vé</a></li>
                    <li class="nav-item ms-lg-3">
                        <div class="dropdown">
                            <a class="btn btn-primary rounded-pill px-4 fw-bold dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Xin chào, <?= htmlspecialchars($username) ?>!
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                <li><a class="dropdown-item" href="/manguonmo/handle/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container booking-container">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="user.php">Danh sách vé</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết đặt vé</li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- CỘT TRÁI: THÔNG TIN CHUYẾN BAY & PHI HÀNH ĐOÀN -->
            <div class="col-lg-8">
                
                <!-- 1. Hình ảnh & Thông tin cơ bản -->
                <div class="flight-image-box mb-4">
                    <img src="../../img/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                    <div class="flight-status-badge">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo $totalQuantity > 0 ? 'Còn vé' : 'Hết vé'; ?>
                    </div>
                    
                    <div class="flight-info-overlay">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-primary text-white border border-white border-opacity-25 px-3 py-2 me-2">
                                <?php echo htmlspecialchars($product['product_code']); ?>
                            </span>
                        </div>

                        <h2 class="mb-1 fw-bold">
                            <?php echo htmlspecialchars($product['product_name']); ?>
                        </h2>
                        <p class="mb-0 opacity-75 small font-monospace">
                            <i class="fas fa-barcode me-2"></i>Mã sản phẩm: 
                            <span class="fw-bold text-warning"><?php echo htmlspecialchars($product['product_code']); ?></span>
                        </p>
                    </div>
                </div>

                <!-- 2. Chi tiết lịch trình -->
                <div class="info-card">
                    <h4 class="section-title"><i class="far fa-clock"></i> Thông tin chuyến bay</h4>
                    <div class="row text-center">
                        <div class="col-md-12">
                            <p class="lead"><?php echo htmlspecialchars($product['product_name']); ?></p>
                            <p class="text-muted">Vui lòng liên hệ để biết thêm thông tin về lịch trình bay chi tiết</p>
                        </div>
                    </div>
                </div>

                <!-- 3. Thông tin Phi hành đoàn (Cơ trưởng & Tiếp viên) -->
                <div class="info-card">
                    <h4 class="section-title"><i class="fas fa-user-tie"></i> Thông Tin Phi Hành Đoàn</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3">Cơ Trưởng (Captain)</h6>
                            <div class="crew-list-item">
                                <div class="crew-avatar"><i class="fas fa-user-pilot"></i></div>
                                <div>
                                    <h5 class="mb-0 fw-bold">
                                        <?php echo $captain ? htmlspecialchars($captain['captain_name']) : 'Chưa có thông tin'; ?>
                                    </h5>
                                    <small class="text-muted">Mã số: 
                                        <span class="text-dark fw-bold">
                                            <?php echo $captain ? htmlspecialchars($captain['captain_code']) : 'N/A'; ?>
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase small fw-bold mb-3">Tiếp Viên Trưởng (Head Attendant)</h6>
                            <div class="crew-list-item">
                                <div class="crew-avatar"><i class="fas fa-user-tie"></i></div>
                                <div>
                                    <h5 class="mb-0 fw-bold">
                                        <?php echo $steward ? htmlspecialchars($steward['steward_name']) : 'Chưa có thông tin'; ?>
                                    </h5>
                                    <small class="text-muted">Mã số: 
                                        <span class="text-dark fw-bold">
                                            <?php echo $steward ? htmlspecialchars($steward['steward_code']) : 'N/A'; ?>
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- CỘT PHẢI: CHỌN VÉ & THANH TOÁN -->
            <div class="col-lg-4">
                <div class="info-card bg-white h-100">
                    <h4 class="section-title"><i class="fas fa-ticket-alt"></i> Chọn Hạng Vé</h4>
                    
                    <form id="bookingForm" method="POST" action="../../handle/bookinghistory_process.php?action=create">
                        <!-- Hidden fields -->
                        <input type="hidden" name="booking_code" value="<?php echo htmlspecialchars($product['product_code']); ?>">
                        <input type="hidden" name="booking_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
                        <input type="hidden" id="selectedType" name="type" value="economy">
                        <input type="hidden" id="selectedPrice" name="price" value="<?php echo $product['price_economy']; ?>">
                        <input type="hidden" id="bookingQuantity" name="quantity" value="1">
                        
                        <!-- Loại Vé: Phổ Thông -->
                        <label class="ticket-class-option selected w-100" 
                               onclick="selectClass(this, <?php echo $product['price_economy']; ?>, 'economy')" 
                               data-class="economy" data-price="<?php echo $product['price_economy']; ?>">
                            <input type="radio" name="ticketClass" value="economy" checked>
                            <span class="class-name text-success">Vé Phổ Thông (Economy)</span>
                            <span class="class-price"><?php echo number_format($product['price_economy'], 0, ',', '.'); ?> ₫</span>
                            <div class="small text-muted mt-1">
                                <i class="fas fa-check me-1"></i>Còn lại: <?php echo $product['quantity_economy']; ?> vé
                            </div>
                            <i class="fas fa-check-circle check-icon"></i>
                        </label>

                        <!-- Loại Vé: Thương Gia -->
                        <label class="ticket-class-option w-100" 
                               onclick="selectClass(this, <?php echo $product['price_business']; ?>, 'business')"
                               data-class="business" data-price="<?php echo $product['price_business']; ?>">
                            <input type="radio" name="ticketClass" value="business">
                            <span class="class-name text-primary">Vé Thương Gia (Business)</span>
                            <span class="class-price"><?php echo number_format($product['price_business'], 0, ',', '.'); ?> ₫</span>
                            <div class="small text-muted mt-1">
                                <i class="fas fa-check me-1"></i>Còn lại: <?php echo $product['quantity_business']; ?> vé
                            </div>
                            <i class="fas fa-check-circle check-icon"></i>
                        </label>

                        <!-- Loại Vé: VIP -->
                        <label class="ticket-class-option w-100" 
                               onclick="selectClass(this, <?php echo $product['price_vip']; ?>, 'vip')"
                               data-class="vip" data-price="<?php echo $product['price_vip']; ?>">
                            <input type="radio" name="ticketClass" value="vip">
                            <span class="class-name text-warning">Vé VIP (First Class)</span>
                            <span class="class-price"><?php echo number_format($product['price_vip'], 0, ',', '.'); ?> ₫</span>
                            <div class="small text-muted mt-1">
                                <i class="fas fa-check me-1"></i>Còn lại: <?php echo $product['quantity_vip']; ?> vé
                            </div>
                            <i class="fas fa-check-circle check-icon"></i>
                        </label>

                        <hr class="my-4">

                        <!-- Số lượng vé -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Số lượng hành khách:</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(-1)">-</button>
                                <input type="number" class="form-control text-center fw-bold" id="quantityInput" value="1" min="1" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(1)">+</button>
                            </div>
                            <small class="text-muted mt-2 d-block text-end">Còn lại: <strong><?php echo $totalQuantity; ?></strong> ghế</small>
                        </div>

                        <!-- Tổng tiền -->
                        <div class="total-bar flex-column align-items-stretch text-center">
                            <div class="small text-white-50 mb-1">TỔNG CỘNG</div>
                            <div class="total-price-display" id="totalPrice"><?php echo number_format($product['price_economy'], 0, ',', '.'); ?> ₫</div>
                            <button type="submit" class="btn btn-warning fw-bold mt-3 w-100 py-3 text-dark">
                                XÁC NHẬN ĐẶT VÉ <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Simple -->
    <footer class="py-4 text-center bg-white mt-5 border-top">
        <div class="container">
            <p class="mb-0 text-muted">© 2023 SkyLine Travel. Uy tín tạo niềm tin.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/user/information_product.js"></script>
</body>
</html>