<?php
session_start();
require_once '../../handle/bookinghistory_process.php';
$bookings = handleGetAllBookings();

// Lấy username từ session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Khách';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Đặt Vé - SkyLine Travel</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/723/723955.png" type="image/png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #ffc107;
            --dark-color: #0a1f35;
            --light-bg: #f8f9fa;
            --price-color: #dc3545;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        /* Navbar */
        .navbar {
            background-color: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        .navbar-brand { color: var(--primary-color) !important; font-weight: 800; font-size: 1.5rem; }
        .nav-link { font-weight: 600; color: var(--dark-color) !important; }
        .nav-link.active { color: var(--primary-color) !important; }

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding-top: 100px; /* Khoảng cách cho navbar fixed */
            padding-bottom: 50px;
        }

        /* History Card */
        .history-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: none;
            overflow: hidden;
        }

        .card-header-custom {
            background-color: white;
            border-bottom: 2px solid var(--light-bg);
            padding: 20px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Table Styling */
        .table-custom th {
            background-color: var(--light-bg);
            color: var(--dark-color);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            border-bottom: none;
            padding: 15px;
        }
        .table-custom td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
            font-size: 0.95rem;
        }
        .table-custom tr:last-child td {
            border-bottom: none;
        }
        .flight-name {
            font-weight: 600;
            color: var(--primary-color);
        }
        .ticket-code {
            font-family: monospace;
            background: #eef2ff;
            padding: 4px 8px;
            border-radius: 4px;
            color: var(--dark-color);
            font-weight: 600;
        }
        .price-text {
            font-weight: 700;
            color: var(--price-color);
        }
        
        /* Status Badges */
        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-success { background-color: #d1e7dd; color: #0f5132; }
        .status-pending { background-color: #fff3cd; color: #664d03; }
        .status-cancelled { background-color: #f8d7da; color: #842029; }

        /* Class Badges */
        .badge-class {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 6px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .class-economy { background-color: #e2e8f0; color: #475569; }
        .class-business { background-color: #e0f2fe; color: #0369a1; }
        .class-vip { background-color: #fef3c7; color: #b45309; border: 1px solid #fcd34d; }

        /* Search in History */
        .history-search {
            max-width: 300px;
        }
        .history-search input {
            border-radius: 20px 0 0 20px;
            border-right: none;
        }
        .history-search button {
            border-radius: 0 20px 20px 0;
            background-color: var(--primary-color);
            color: white;
            border: 1px solid var(--primary-color);
        }

        /* Footer */
        footer { background-color: var(--dark-color); color: #adb5bd; margin-top: auto; }
    </style>
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
                    <li class="nav-item"><a class="nav-link active" href="booking_history.php">Lịch sử đặt vé</a></li>
                    <li class="nav-item ms-lg-3">
                        <div class="dropdown">
                            <a class="btn btn-outline-primary rounded-pill px-4 fw-bold dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
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

    <div class="container main-content">
        <div class="row justify-content-center">
            <div class="col-12">
                
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Lịch Sử Đặt Vé</h2>
                        <p class="text-muted mb-0">Quản lý và theo dõi các chuyến đi của bạn</p>
                    </div>
                    
                    <div class="input-group history-search mt-3 mt-md-0">
                        <input type="text" class="form-control" placeholder="Tìm theo mã vé...">
                        <button class="btn" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <div class="card history-card">
                    <div class="table-responsive">
                        <table class="table table-hover table-custom mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center" width="5%">ID</th>
                                    <th scope="col" width="15%">Mã Vé</th>
                                    <th scope="col" width="25%">Tên Vé</th>
                                    <th scope="col" class="text-center" width="10%">Loại Vé</th> 
                                    <th scope="col" class="text-center" width="10%">Số Lượng</th>
                                    <th scope="col" width="15%">Tổng Giá</th>
                                    <th scope="col" width="15%">Thời Gian Đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($bookings)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-3 mb-0">Chưa có lịch sử đặt vé nào</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($bookings as $index => $booking): ?>
                                    <tr>
                                        <td class="text-center fw-bold"><?php echo $index + 1; ?></td>
                                        <td>
                                            <span class="ticket-code"><?php echo htmlspecialchars($booking['product_code']); ?></span>
                                        </td>
                                        <td>
                                            <div class="flight-name"><?php echo htmlspecialchars($booking['product_name']); ?></div>
                                        </td>
                                        <td class="text-center">
                                            <?php 
                                            $ticketType = strtolower($booking['type']);
                                            $badgeClass = 'class-economy';
                                            $typeName = 'Phổ thông';
                                            
                                            if ($ticketType == 'vip') {
                                                $badgeClass = 'class-vip';
                                                $typeName = 'VIP';
                                            } elseif ($ticketType == 'business') {
                                                $badgeClass = 'class-business';
                                                $typeName = 'Business';
                                            } elseif ($ticketType == 'economy') {
                                                $typeName = 'Phổ thông';
                                            }
                                            ?>
                                            <span class="badge-class <?php echo $badgeClass; ?>">
                                                <?php echo $typeName; ?>
                                            </span>
                                        </td>
                                        <td class="text-center fw-bold"><?php echo number_format($booking['quantity']); ?></td>
                                        <td>
                                            <span class="price-text"><?php echo number_format($booking['price'], 0, ',', '.'); ?> ₫</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                <?php echo date('d/m/Y H:i', strtotime($booking['time'])); ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination (Phân trang) -->
                    <div class="card-footer bg-white py-3 border-top">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Trước</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 text-center">
        <div class="container">
            <p class="mb-0">© 2023 SkyLine Travel. Đại lý vé máy bay uy tín hàng đầu.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/user/booking_history.js"></script>
</body>
</html>