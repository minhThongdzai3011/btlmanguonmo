<?php
    require_once '../handle/product_process.php';
    $products = handleGetAllProducts();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Săn Vé Tốt - SkyLine Travel</title>
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
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        .navbar-brand { color: var(--primary-color) !important; font-weight: 800; font-size: 1.5rem; }
        .nav-link { font-weight: 600; color: var(--dark-color) !important; }
        .nav-link.active { color: var(--primary-color) !important; }

        /* --- Header --- */
        .deals-header {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-color));
            padding: 100px 0 80px;
            color: white;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }
        .deals-header::after {
             content: '';
             position: absolute;
             bottom: -50px;
             left: 0;
             width: 100%;
             height: 100px;
             background: #f0f2f5;
             border-radius: 50% 50% 0 0 / 100% 100% 0 0;
             transform: scaleX(1.5);
        }

        /* --- CARD VÉ MÁY BAY NÂNG CAO --- */
        .flight-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            height: 100%; /* Đảm bảo các card bằng nhau */
            display: flex;
            flex-direction: column;
        }
        .flight-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(13, 110, 253, 0.15);
        }
        .card-img-top-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
        }
        .card-img-top-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }
        .flight-card:hover .card-img-top-wrapper img {
            transform: scale(1.1);
        }
        .flight-code-badge {
            position: absolute;
            top: 15px; left: 15px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .wishlist-btn {
            position: absolute;
            top: 15px; right: 15px;
            background: white;
            width: 40px; height: 40px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #ccc;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .wishlist-btn:hover { color: var(--price-color); transform: scale(1.1); }

        .card-body {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex-grow: 1; /* Để phần body giãn hết chiều cao còn lại */
        }
        .flight-route {
            font-size: 1.15rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--dark-color);
            line-height: 1.4;
            /* Giới hạn 2 dòng nếu tên quá dài */
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 55px;
        }
        .flight-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.95rem;
            color: #555;
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }
        .flight-info-row:last-child { border-bottom: none; }
        .flight-info-row i { color: var(--primary-color); width: 25px; opacity: 0.8; }

        /* Price Section đẹp hơn */
        .price-section {
            margin-top: auto; /* Đẩy xuống đáy card */
            padding-top: 20px;
            border-top: 2px dashed #f0f0f0;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
        }
        .price-label {
            font-size: 0.85rem;
            color: #999;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .price-amount {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--price-color);
            line-height: 1;
            font-family: 'Montserrat', sans-serif;
        }
        .currency {
            font-size: 1rem;
            vertical-align: top;
            font-weight: 700;
        }
        .btn-book {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            margin-top: 20px;
            background: var(--primary-color);
            color: white;
            border: none;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        .btn-book:hover {
            background: var(--dark-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.html"><i class="fas fa-plane me-2 text-warning"></i> SkyLine Travel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.html">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Săn vé tốt</a></li>
                    <li class="nav-item ms-lg-3"><a class="btn btn-primary rounded-pill px-4 fw-bold" href="#contact">Hotline: 1900 1234</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="deals-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Săn Vé Rẻ - Bay Thỏa Thích</h1>
            <p class="lead opacity-75 mb-0">Khám phá hàng ngàn chuyến bay với mức giá không thể tốt hơn</p>
        </div>
    </header>

    <!-- HOT DEALS SECTION -->
    <section class="py-5" style="margin-top: -50px; position: relative; z-index: 2;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark m-0"><i class="fas fa-fire-alt text-danger me-2"></i>Vé Đang Hot</h2>
            </div>

            <div class="row g-4">
                <!-- VÒNG LẶP PHP GỐC CỦA BẠN -->
                <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="flight-card">
                        <!-- Ảnh và Mã vé -->
                        <div class="card-img-top-wrapper">
                            <img src="../img/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                            <div class="flight-code-badge">
                                <i class="fas fa-barcode me-1"></i> <?= htmlspecialchars($product['product_code']) ?>
                            </div>
                            <div class="wishlist-btn" title="Lưu vào yêu thích"><i class="fas fa-heart"></i></div>
                        </div>
                        
                        <!-- Nội dung vé -->
                        <div class="card-body">
                            <div class="flight-route" title="<?= htmlspecialchars($product['product_name']) ?>">
                                <?= htmlspecialchars($product['product_name']) ?>
                            </div>
                            
                            <!-- Loại vé và số lượng -->
                            <div class="mb-3">
                                <h6 class="text-muted mb-2" style="font-size: 0.85rem; font-weight: 600;">
                                    <i class="fas fa-ticket-alt me-1"></i> Loại vé có sẵn:
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php if ($product['quantity_economy'] > 0): ?>
                                        <span class="badge bg-success" style="padding: 8px 12px; font-size: 0.85rem;">
                                            <i class="fas fa-chair me-1"></i> Phổ thông (<?= $product['quantity_economy'] ?> vé)
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($product['quantity_vip'] > 0): ?>
                                        <span class="badge bg-warning text-dark" style="padding: 8px 12px; font-size: 0.85rem;">
                                            <i class="fas fa-star me-1"></i> VIP (<?= $product['quantity_vip'] ?> vé)
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($product['quantity_business'] > 0): ?>
                                        <span class="badge bg-primary" style="padding: 8px 12px; font-size: 0.85rem;">
                                            <i class="fas fa-crown me-1"></i> Business (<?= $product['quantity_business'] ?> vé)
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Giá vé -->
                            <div class="price-section" style="display: block;">
                                <h6 class="text-muted mb-3" style="font-size: 0.85rem; font-weight: 600;">
                                    <i class="fas fa-money-bill-wave me-1"></i> Bảng giá:
                                </h6>
                                
                                <div class="d-flex flex-column gap-2">
                                    <?php if ($product['quantity_economy'] > 0): ?>
                                        <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background: rgba(25, 135, 84, 0.1);">
                                            <span class="fw-bold text-success">Phổ thông</span>
                                            <span class="fw-bold text-success"><?= number_format($product['price_economy'], 0, ',', '.') ?> ₫</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($product['quantity_vip'] > 0): ?>
                                        <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background: rgba(255, 193, 7, 0.1);">
                                            <span class="fw-bold text-warning">VIP</span>
                                            <span class="fw-bold text-warning"><?= number_format($product['price_vip'], 0, ',', '.') ?> ₫</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($product['quantity_business'] > 0): ?>
                                        <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background: rgba(13, 110, 253, 0.1);">
                                            <span class="fw-bold text-primary">Business</span>
                                            <span class="fw-bold text-primary"><?= number_format($product['price_business'], 0, ',', '.') ?> ₫</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <button class="btn btn-book">
                                Đặt Vé Ngay <i class="fas fa-arrow-right ms-2 opacity-50"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <!-- KẾT THÚC VÒNG LẶP -->
            </div>
        </div>
    </section>

    <!-- Footer Simple -->
    <footer class="py-5 text-center bg-white mt-5">
        <div class="container">
            <a class="navbar-brand d-inline-block mb-3" href="#"><i class="fas fa-plane me-2 text-warning"></i> SkyLine Travel</a>
            <p class="mb-0 text-muted">© 2023 SkyLine Travel. Tất cả các quyền được bảo lưu.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>