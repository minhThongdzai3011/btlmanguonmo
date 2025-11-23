<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyLine- Đại lý vé máy bay uy tín</title>
    <!-- Favicon -->
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/723/723955.png" type="image/png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #ffc107;
            --dark-color: #0a1f35;
            --light-bg: #f8f9fa;
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

        /* --- Custom Scrollbar --- */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0b5ed7;
        }

        /* --- Navbar --- */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-size: 1.6rem;
            font-weight: 800;
        }

        .navbar-brand i {
            color: var(--secondary-color);
            transform: rotate(-45deg);
        }

        .nav-link {
            font-weight: 600;
            color: var(--dark-color) !important;
            margin: 0 10px;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* --- Buttons --- */
        .btn-primary-custom {
            background: linear-gradient(45deg, var(--primary-color), #0056b3);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
            background: linear-gradient(45deg, #0056b3, var(--primary-color));
        }

        /* --- Hero Section with Parallax --- */
        .hero-section {
            background-image: linear-gradient(rgba(0, 20, 50, 0.5), rgba(0, 20, 50, 0.5)), url('img/info/index/img1.jpg');
            background-attachment: fixed; /* Hiệu ứng Parallax đơn giản */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4rem;
            line-height: 1.1;
            margin-bottom: 25px;
            font-weight: 800;
            text-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        /* --- Animation Classes (Scroll Reveal) --- */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 1s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 1s ease;
        }

        .reveal-left.active {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 1s ease;
        }

        .reveal-right.active {
            opacity: 1;
            transform: translateX(0);
        }

        /* --- About Section --- */
        .about-img-box {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .about-img-box img {
            transition: transform 0.5s ease;
        }

        .about-img-box:hover img {
            transform: scale(1.05);
        }

        /* --- Stats Section --- */
        .stats-section {
            background: var(--primary-color);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-item h3 {
            font-size: 3.5rem;
            font-weight: 800;
        }

        /* --- Feature Box Enhanced --- */
        .feature-box {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Hiệu ứng nảy */
            border-bottom: 4px solid transparent;
            height: 100%;
        }

        .feature-box:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-bottom: 4px solid var(--secondary-color);
        }

        .feature-icon {
            width: 90px;
            height: 90px;
            line-height: 90px;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.1), rgba(13, 110, 253, 0.2));
            color: var(--primary-color);
            font-size: 36px;
            border-radius: 50%;
            margin: 0 auto 30px;
            transition: all 0.5s ease;
        }

        .feature-box:hover .feature-icon {
            background: var(--primary-color);
            color: white;
            transform: rotateY(360deg);
        }

        /* --- Destination Cards Enhanced --- */
        .destination-card {
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            height: 400px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .destination-bg {
            height: 100%;
            width: 100%;
            background-size: cover;
            background-position: center;
            transition: transform 0.8s ease;
        }

        .destination-card:hover .destination-bg {
            transform: scale(1.1);
        }

        .destination-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 30px 20px;
            color: white;
            transform: translateY(100px);
            transition: all 0.4s ease;
        }

        .destination-card:hover .destination-overlay {
            transform: translateY(0);
        }

        .destination-overlay h4 {
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        /* --- Footer --- */
        footer {
            background-color: var(--dark-color);
            color: #adb5bd;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-section { height: 80vh; background-attachment: scroll; } /* Tắt parallax trên mobile để mượt hơn */
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-plane me-2"></i>
                SkyLine
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="views/info/guest.php">Vé</a></li>
                    <li class="nav-item"><a class="nav-link" href="views/info/about.php">Về chúng tôi</a></li>
                    <li class="nav-item"><a class="nav-link" href="views/info/services.php">Dịch vụ VIP</a></li>
                    <li class="nav-item"><a class="nav-link" href="#destinations">Điểm đến</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary-custom text-white" href="views/login/login.php">
                            Đăng nhập <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section" id="home">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="hero-content reveal-left active"> <!-- Mặc định active để hiện ngay khi load -->
                        
                        <h1 class="hero-title">Nâng Tầm Trải Nghiệm Bay Của Bạn</h1>
                        <p class="lead mb-5 opacity-75">Chúng tôi không chỉ bán vé máy bay, chúng tôi mang đến những hành trình hoàn hảo và dịch vụ đẳng cấp 5 sao.</p>
                        <div class="d-flex gap-3">
                            <a href="#about" class="btn btn-primary-custom btn-lg text-white px-5">Khám phá ngay</a>
                            <a href="tel:19001234" class="btn btn-outline-light btn-lg rounded-pill px-4 fw-bold">
                                <i class="fas fa-phone-alt me-2"></i> 1900 1234
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Us Section (New Focus) -->
    <section class="py-5 section-padding" id="about">
        <div class="container py-5">
            <div class="row align-items-center gx-5">
                <div class="col-lg-6 mb-5 mb-lg-0 reveal-left">
                    <div class="about-img-box">
                        <img src="img/info/index/img2.png" alt="Về chúng tôi" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-6 reveal-right">
                    <h6 class="text-primary fw-bold text-uppercase ls-2">Về SkyLine</h6>
                    <h2 class="display-5 fw-bold mb-4">Hơn 10 Năm Kết Nối Những Chuyến Bay</h2>
                    <p class="lead text-muted">SkyLine tự hào là đối tác chiến lược của hơn 500 hãng hàng không trong nước và quốc tế. Chúng tôi cam kết mang lại giải pháp di chuyển tối ưu nhất cho mọi khách hàng.</p>
                    <p class="text-muted mb-5">Với đội ngũ chuyên gia giàu kinh nghiệm, chúng tôi xử lý mọi yêu cầu phức tạp từ vé đoàn, vé thương gia, đến các trường hợp khẩn cấp một cách nhanh chóng và chuyên nghiệp nhất.</p>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success fs-2 me-3"></i>
                                <div>
                                    <h5 class="fw-bold mb-0">Uy Tín Hàng Đầu</h5>
                                    <small class="text-muted">Được chứng nhận bởi IATA</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-headset text-primary fs-2 me-3"></i>
                                <div>
                                    <h5 class="fw-bold mb-0">Hỗ Trợ 24/7</h5>
                                    <small class="text-muted">Luôn sẵn sàng khi bạn cần</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Counter Section -->
    <section class="stats-section py-5 reveal">
        <div class="container py-4">
            <div class="row text-center g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <h3 class="counter">10+</h3>
                        <p class="mb-0 opacity-75">Năm Kinh Nghiệm</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <h3>50k+</h3>
                        <p class="mb-0 opacity-75">Khách Hàng Hài Lòng</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <h3>500+</h3>
                        <p class="mb-0 opacity-75">Đối Tác Hàng Không</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <h3>24/7</h3>
                        <p class="mb-0 opacity-75">Hỗ Trợ Kỹ Thuật</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Services Section -->
    <section class="py-5 bg-light" id="services">
        <div class="container py-5">
            <div class="text-center mb-5 reveal">
                <h6 class="text-primary fw-bold text-uppercase">Dịch vụ của chúng tôi</h6>
                <h2 class="fw-bold display-5">Trải Nghiệm Đẳng Cấp VIP</h2>
            </div>
            <div class="row g-4">
                <!-- Service 1 -->
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="feature-box text-center">
                        <div class="feature-icon">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h4>Vé Hạng Thương Gia</h4>
                        <p class="text-muted mt-3">Tư vấn và đặt vé hạng thương gia, hạng nhất với mức giá ưu đãi đặc biệt và các đặc quyền riêng biệt.</p>
                    </div>
                </div>
                <!-- Service 2 -->
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="feature-box text-center">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Vé Đoàn Doanh Nghiệp</h4>
                        <p class="text-muted mt-3">Giải pháp vé máy bay tối ưu chi phí cho doanh nghiệp, tổ chức sự kiện, du lịch công ty (MICE).</p>
                    </div>
                </div>
                <!-- Service 3 -->
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="feature-box text-center">
                        <div class="feature-icon">
                            <i class="fas fa-passport"></i>
                        </div>
                        <h4>Dịch Vụ Visa & Tiện Ích</h4>
                        <p class="text-muted mt-3">Hỗ trợ xin visa nhanh chóng, đặt phòng khách sạn, xe đưa đón sân bay và bảo hiểm du lịch toàn cầu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visual Destinations Gallery (Showcase, not booking) -->
    <section class="py-5" id="destinations">
        <div class="container py-5">
            <div class="row mb-5 align-items-end reveal">
                <div class="col-lg-8">
                    <h6 class="text-primary fw-bold text-uppercase">Mạng lưới đường bay</h6>
                    <h2 class="fw-bold display-5">Kết Nối Mọi Điểm Đến</h2>
                    <p class="text-muted lead mb-0">Chúng tôi có thể đưa bạn đến bất kỳ đâu trên thế giới.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#contact" class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-lg-0">Xem tất cả điểm đến</a>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal-left">
                    <div class="destination-card">
                        <div class="destination-bg" style="background-image: url('img/info/index/img3.jpg');"></div>
                        <div class="destination-overlay">
                            <h4>Châu Âu</h4>
                            <p class="mb-0"><i class="fas fa-map-marker-alt me-2 text-warning"></i>Pháp, Đức, Ý, Anh...</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="destination-card">
                        <div class="destination-bg" style="background-image: url('img/info/index/img4.jpg');"></div>
                        <div class="destination-overlay">
                            <h4>Châu Á</h4>
                            <p class="mb-0"><i class="fas fa-map-marker-alt me-2 text-warning"></i>Nhật Bản, Hàn Quốc, Singapore...</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal-right">
                    <div class="destination-card">
                        <div class="destination-bg" style="background-image: url('img/info/index/img5.jpg');"></div>
                        <div class="destination-overlay">
                            <h4>Châu Mỹ</h4>
                            <p class="mb-0"><i class="fas fa-map-marker-alt me-2 text-warning"></i>Mỹ, Canada, Brazil...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Enhanced -->
    <footer id="contact" class="pt-5">
        <div class="container pt-5 reveal">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <a class="navbar-brand text-white mb-4 d-block" href="#">
                        <i class="fas fa-plane me-2 text-warning"></i>
                        SkyLine Travel
                    </a>
                    <p class="opacity-75">Đại lý vé máy bay hàng đầu Việt Nam. Chúng tôi cam kết mang đến dịch vụ tốt nhất cho mọi hành trình của bạn.</p>
                    <div class="mt-4">
                         <!-- Social Media Icons with hover effect -->
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2" style="width: 35px; height: 35px;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2" style="width: 35px; height: 35px;"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2" style="width: 35px; height: 35px;"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h5 class="text-white mb-4">Công Ty</h5>
                    <ul class="list-unstyled opacity-75">
                        <li class="mb-2"><a href="#about" class="text-reset text-decoration-none">Về chúng tôi</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Đội ngũ</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Tuyển dụng</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Tin tức</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h5 class="text-white mb-4">Chính Sách</h5>
                    <ul class="list-unstyled opacity-75">
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Điều khoản</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Bảo mật</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Hoàn hủy vé</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Thanh toán</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white mb-4">Liên Hệ Ngay</h5>
                    <ul class="list-unstyled text-white opacity-75">
                        <li class="mb-3 d-flex"><i class="fas fa-map-marker-alt me-3 mt-1 text-warning"></i> <span>Tầng 12A, Tòa nhà SkyCity, 88 Láng Hạ, Đống Đa, Hà Nội</span></li>
                        <li class="mb-3 d-flex"><i class="fas fa-phone-alt me-3 mt-1 text-warning"></i> <span>Hotline: 1900 1234<br>CSKH: 024 7777 8888</span></li>
                        <li class="mb-3 d-flex"><i class="fas fa-envelope me-3 mt-1 text-warning"></i> <span>info@skylinetravel.vn</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary py-4 text-center opacity-50">
                <small>&copy; 2023 SkyLine Travel. Thiết kế với <i class="fas fa-heart text-danger"></i> cho trải nghiệm người dùng.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Simple Scroll Animation Script -->
    <script>
        // Hàm kiểm tra phần tử có trong viewport không
        function reveal() {
            var reveals = document.querySelectorAll(".reveal, .reveal-left, .reveal-right");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150; // Khoảng cách từ dưới lên để bắt đầu hiện

                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                }
                // Không else để giữ class active khi đã hiện
            }
        }
        // Gọi hàm khi cuộn trang
        window.addEventListener("scroll", reveal);
        // Gọi một lần khi tải trang để hiện các phần tử ban đầu
        reveal();
    </script>
</body>
</html>