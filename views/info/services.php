<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dịch vụ VIP - SkyLine Travel</title>
    <!-- Favicon -->
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/723/723955.png" type="image/png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        /* --- GIỮ NGUYÊN BỘ STYLE TỪ CÁC TRANG TRƯỚC --- */
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #ffc107;
            --dark-color: #0a1f35;
            --light-bg: #f8f9fa;
            --gold-color: #c5a47e; /* Màu vàng kim cho trang VIP */
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--primary-color); border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: #0b5ed7; }

        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 15px 0;
        }
        .navbar-brand { color: var(--primary-color) !important; font-size: 1.6rem; font-weight: 800; }
        .navbar-brand i { color: var(--secondary-color); transform: rotate(-45deg); }
        .nav-link { font-weight: 600; color: var(--dark-color) !important; margin: 0 10px; position: relative; }
        .nav-link.active { color: var(--primary-color) !important; }
        .nav-link::after {
            content: ''; position: absolute; bottom: 0; left: 50%; width: 0; height: 2px;
            background-color: var(--primary-color); transition: all 0.3s ease; transform: translateX(-50%);
        }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }

        .btn-primary-custom {
            background: linear-gradient(45deg, var(--primary-color), #0056b3);
            border: none; padding: 12px 30px; font-weight: 600; border-radius: 50px;
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3); transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            transform: translateY(-3px); box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
        }
        .btn-gold-custom {
            background: linear-gradient(45deg, var(--gold-color), #a48660);
            color: white; border: none; padding: 12px 30px; font-weight: 600; border-radius: 50px;
            box-shadow: 0 5px 15px rgba(197, 164, 126, 0.3); transition: all 0.3s ease;
        }
        .btn-gold-custom:hover {
            transform: translateY(-3px); box-shadow: 0 8px 20px rgba(197, 164, 126, 0.4); color: white;
        }

        .reveal { opacity: 0; transform: translateY(50px); transition: all 1s ease; }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-left { opacity: 0; transform: translateX(-50px); transition: all 1s ease; }
        .reveal-left.active { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(50px); transition: all 1s ease; }
        .reveal-right.active { opacity: 1; transform: translateX(0); }

        footer { background-color: var(--dark-color); color: #adb5bd; }

        /* --- STYLES RIÊNG CHO TRANG SERVICES VIP --- */
        .page-header-vip {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../../img/info/services/img1.jpg');
            background-size: cover; background-position: center;
            padding: 150px 0 100px; color: white; text-align: center; margin-bottom: 50px;
        }
        .text-gold { color: var(--gold-color) !important; }
        .bg-dark-blue { background-color: var(--dark-color); color: white; }

        /* Service Cards */
        .vip-service-card {
            border: none; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            transition: all 0.4s ease; height: 100%;
        }
        .vip-service-card:hover { transform: translateY(-10px); }
        .vip-card-img { height: 250px; overflow: hidden; position: relative; }
        .vip-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
        .vip-service-card:hover .vip-card-img img { transform: scale(1.1); }
        .vip-card-body { padding: 30px; position: relative; background: white; }
        .vip-icon-wrapper {
            position: absolute; top: -40px; right: 30px; width: 80px; height: 80px;
            background: var(--gold-color); color: white; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; font-size: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Process Steps */
        .process-step {
            text-align: center; position: relative; padding: 30px;
            background: white; border-radius: 15px; height: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: all 0.3s ease;
        }
        .process-step:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.1); }
        .step-number {
            font-size: 4rem; font-weight: 800; color: rgba(13, 110, 253, 0.1);
            position: absolute; top: 10px; left: 20px; line-height: 1;
        }
        .step-icon {
            font-size: 2.5rem; color: var(--primary-color); margin-bottom: 20px; position: relative; z-index: 2;
        }

        /* CTA Banner */
        .cta-banner {
            background: linear-gradient(135deg, var(--dark-color), #1a3a5a);
            padding: 80px 0; color: white; border-radius: 20px; margin: 50px 0;
            position: relative; overflow: hidden;
        }
        .cta-banner::before {
            content: ''; position: absolute; top: -50%; right: -10%; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
        }

    </style>
</head>
<body>

    <!-- Navigation Bar (Đã cập nhật link Active) -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">
                <i class="fas fa-plane me-2"></i>
                SkyLine Travel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="../../index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Về chúng tôi</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Dịch vụ VIP</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary-custom text-white" href="../login/login.php">
                            Đăng nhập <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header VIP -->
    <header class="page-header-vip">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 reveal">
                    <span class="text-gold fw-bold text-uppercase ls-2 mb-3 d-block">SkyLine Premium</span>
                    <h1 class="display-3 fw-bold mb-4">Dịch Vụ Đẳng Cấp Thượng Lưu</h1>
                    <p class="lead opacity-75">Trải nghiệm sự sang trọng, riêng tư và tiện nghi tuyệt đối trên mỗi hành trình của bạn.</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Intro Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center text-center mb-5 reveal">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-3">Tại Sao Chọn Dịch Vụ VIP Của Chúng Tôi?</h2>
                    <p class="text-muted lead">Chúng tôi hiểu rằng thời gian và sự thoải mái là vô giá đối với những khách hàng đặc biệt. Dịch vụ VIP của SkyLine được thiết kế để đáp ứng những tiêu chuẩn khắt khe nhất.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main VIP Services -->
    <section class="pb-5">
        <div class="container pb-5">
            <div class="row g-4">
                <!-- Service 1: Private Jet -->
                <div class="col-lg-4 col-md-6 reveal-left">
                    <div class="vip-service-card">
                        <div class="vip-card-img">
                            <img src="../../img/info/services/img2.jpeg" alt="Chuyên cơ riêng">
                        </div>
                        <div class="vip-card-body">
                            <div class="vip-icon-wrapper" >
                                <i class="fas fa-plane me-2" style="margin-left: 9px;"></i>
                            </div>
                            <h3 class="fw-bold mt-3">Thuê Chuyên Cơ Riêng</h3>
                            <p class="text-muted mt-3">Bay theo lịch trình của riêng bạn với các dòng máy bay hiện đại nhất. Tận hưởng sự riêng tư tuyệt đối và thủ tục nhanh chóng.</p>
                            <ul class="list-unstyled text-muted mt-4 mb-4">
                                <li class="mb-2"><i class="fas fa-check text-gold me-2"></i>Lịch trình linh hoạt 24/7</li>
                                <li class="mb-2"><i class="fas fa-check text-gold me-2"></i>Nhà ga VIP riêng biệt</li>
                                <li><i class="fas fa-check text-gold me-2"></i>Thực đơn theo yêu cầu</li>
                            </ul>
                            <a href="#contact" class="btn btn-outline-dark rounded-pill px-4">Tìm hiểu thêm</a>
                        </div>
                    </div>
                </div>
                <!-- Service 2: First Class -->
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="vip-service-card">
                        <div class="vip-card-img">
                            <img src="../../img/info/services/img3.avif" alt="Hạng Nhất">
                        </div>
                        <div class="vip-card-body">
                            <div class="vip-icon-wrapper" style="background-color: var(--primary-color)">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h3 class="fw-bold mt-3">Vé Hạng Nhất & Thương Gia</h3>
                            <p class="text-muted mt-3">Đối tác chiến lược của các hãng hàng không 5 sao. Đảm bảo chỗ ngồi tốt nhất với mức giá ưu đãi đặc biệt dành riêng cho thành viên.</p>
                            <ul class="list-unstyled text-muted mt-4 mb-4">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Ưu tiên làm thủ tục & lên máy bay</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Sử dụng phòng chờ thương gia</li>
                                <li><i class="fas fa-check text-primary me-2"></i>Hành lý miễn cước tối đa</li>
                            </ul>
                            <a href="#contact" class="btn btn-outline-primary rounded-pill px-4">Tìm hiểu thêm</a>
                        </div>
                    </div>
                </div>
                <!-- Service 3: Airport Concierge -->
                <div class="col-lg-4 col-md-6 reveal-right">
                    <div class="vip-service-card">
                        <div class="vip-card-img">
                            <img src="../../img/info/services/img4.jpg" alt="Đưa đón VIP">
                        </div>
                        <div class="vip-card-body">
                            <div class="vip-icon-wrapper" style="background-color: #28a745">
                                <i class="fas fa-car"></i>
                            </div>
                            <h3 class="fw-bold mt-3">Đưa Đón & Hỗ Trợ Sân Bay</h3>
                            <p class="text-muted mt-3">Dịch vụ xe sang đưa đón tận nơi. Nhân viên hỗ trợ làm thủ tục nhanh (Fast Track), giúp bạn tiết kiệm thời gian quý báu.</p>
                            <ul class="list-unstyled text-muted mt-4 mb-4">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Xe sang đời mới (Mẹc, BMW...)</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Lối đi ưu tiên an ninh/hải quan</li>
                                <li><i class="fas fa-check text-success me-2"></i>Hỗ trợ hành lý ký gửi</li>
                            </ul>
                            <a href="#contact" class="btn btn-outline-success rounded-pill px-4">Tìm hiểu thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Working Process -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5 reveal">
                <h6 class="text-primary fw-bold text-uppercase">Quy trình phục vụ</h6>
                <h2 class="fw-bold display-5">Đơn Giản & Nhanh Chóng</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 reveal-left">
                    <div class="process-step">
                        <span class="step-number">01</span>
                        <div class="step-icon"><i class="fas fa-file-signature"></i></div>
                        <h4>Gửi Yêu Cầu</h4>
                        <p class="text-muted mb-0">Liên hệ với chúng tôi qua hotline hoặc form đăng ký. Chuyên viên VIP sẽ tiếp nhận ngay lập tức.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="process-step">
                        <span class="step-number">02</span>
                        <div class="step-icon"><i class="fas fa-comments-dollar"></i></div>
                        <h4>Tư Vấn Giải Pháp</h4>
                        <p class="text-muted mb-0">Chúng tôi đề xuất các phương án hành trình tối ưu nhất dựa trên nhu cầu và sở thích riêng của bạn.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal">
                    <div class="process-step">
                        <span class="step-number">03</span>
                         <div class="step-icon"><i class="fas fa-credit-card"></i></div>
                        <h4>Xác Nhận & Thanh Toán</h4>
                        <p class="text-muted mb-0">Hoàn tất thủ tục nhanh gọn với nhiều hình thức thanh toán linh hoạt và bảo mật tuyệt đối.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 reveal-right">
                    <div class="process-step">
                        <span class="step-number">04</span>
                         <div class="step-icon"><i class="fas fa-glass-cheers"></i></div>
                        <h4>Tận Hưởng Chuyến Đi</h4>
                        <p class="text-muted mb-0">Mọi thứ đã sẵn sàng. Bạn chỉ việc thư giãn và tận hưởng hành trình đẳng cấp của mình.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="container reveal">
        <div class="cta-banner text-center">
            <div class="row justify-content-center position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-4">Sẵn Sàng Cho Trải Nghiệm Khác Biệt?</h2>
                    <p class="lead mb-5 opacity-75">Đừng ngần ngại liên hệ với đội ngũ chuyên gia VIP của chúng tôi để được tư vấn chi tiết nhất cho chuyến đi sắp tới.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="tel:19001234" class="btn btn-gold-custom btn-lg">
                            <i class="fas fa-phone-alt me-2"></i> Gọi Hotline VIP
                        </a>
                         <a href="#contact" class="btn btn-outline-light btn-lg rounded-pill px-4">Gửi Yêu Cầu</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (Giữ nguyên để đồng bộ) -->
    <footer id="contact" class="pt-5">
        <div class="container pt-5 reveal">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <a class="navbar-brand text-white mb-4 d-block" href="index.html">
                        <i class="fas fa-plane me-2 text-warning"></i> SkyLine Travel
                    </a>
                    <p class="opacity-75">Đại lý vé máy bay hàng đầu Việt Nam. Chúng tôi cam kết mang đến dịch vụ tốt nhất cho mọi hành trình của bạn.</p>
                    <div class="mt-4">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2" style="width: 35px; height: 35px;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2" style="width: 35px; height: 35px;"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2" style="width: 35px; height: 35px;"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h5 class="text-white mb-4">Công Ty</h5>
                    <ul class="list-unstyled opacity-75">
                        <li class="mb-2"><a href="about.html" class="text-reset text-decoration-none">Về chúng tôi</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Đội ngũ</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h5 class="text-white mb-4">Dịch Vụ VIP</h5>
                    <ul class="list-unstyled opacity-75">
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Chuyên cơ riêng</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Vé hạng Nhất</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Đưa đón sân bay</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white mb-4">Liên Hệ VIP</h5>
                    <ul class="list-unstyled text-white opacity-75">
                        <li class="mb-3"><i class="fas fa-crown me-3 text-warning"></i> Hotline VIP: 0988 999 888</li>
                        <li class="mb-3"><i class="fas fa-envelope me-3 text-warning"></i> vip@SkyLine.vn</li>
                        <li class="mb-3"><i class="fas fa-map-marker-alt me-3 text-warning"></i> Phòng chờ VIP, Tầng 12A, 88 Láng Hạ</li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary py-4 text-center opacity-50">
                <small>&copy; 2023 SkyLine Travel. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS & Animation Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function reveal() {
            var reveals = document.querySelectorAll(".reveal, .reveal-left, .reveal-right");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                if (elementTop < windowHeight - 150) { reveals[i].classList.add("active"); }
            }
        }
        window.addEventListener("scroll", reveal);
        reveal();
    </script>
</body>
</html>