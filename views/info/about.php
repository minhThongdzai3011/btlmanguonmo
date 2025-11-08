<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về chúng tôi - Air Agent</title>
    
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/723/723955.png" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

        .reveal { opacity: 0; transform: translateY(50px); transition: all 1s ease; }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-left { opacity: 0; transform: translateX(-50px); transition: all 1s ease; }
        .reveal-left.active { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(50px); transition: all 1s ease; }
        .reveal-right.active { opacity: 1; transform: translateX(0); }

        footer { background-color: var(--dark-color); color: #adb5bd; }

        
        .page-header {
            background: linear-gradient(rgba(10, 31, 53, 0.8), rgba(10, 31, 53, 0.8)), url('../../img/info/about/img1.jpg');
            background-size: cover;
            background-position: center;
            padding: 150px 0 100px;
            color: white;
            text-align: center;
            margin-bottom: 50px;
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        /* Vision & Mission Cards */
        .mission-card {
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            height: 100%;
            border-top: 5px solid var(--primary-color);
            transition: transform 0.3s ease;
        }
        .mission-card:hover { transform: translateY(-10px); }
        .mission-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 25px;
        }

        /* Timeline History */
        .timeline {
            position: relative;
            padding: 50px 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            width: 4px;
            height: 100%;
            background: var(--light-bg);
            transform: translateX(-50%);
        }
        .timeline-item {
            margin-bottom: 50px;
            position: relative;
        }
        .timeline-content {
            width: 45%;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            position: relative;
        }
        .timeline-item:nth-child(odd) .timeline-content {
            margin-left: auto;
        }
        .timeline-dot {
            position: absolute;
            left: 50%;
            top: 30px;
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border-radius: 50%;
            transform: translateX(-50%);
            border: 4px solid white;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
        }
        .timeline-year {
            color: var(--primary-color);
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 10px;
            display: block;
        }

        /* Team Section */
        .team-member {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            text-align: center;
        }
        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .member-img {
            height: 300px;
            overflow: hidden;
        }
        .member-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .team-member:hover .member-img img {
            transform: scale(1.1);
        }
        .member-info {
            padding: 25px;
        }
        .member-social a {
            color: var(--primary-color);
            margin: 0 8px;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }
        .member-social a:hover { color: var(--secondary-color); }

        @media (max-width: 768px) {
            .timeline::before { left: 30px; }
            .timeline-content { width: calc(100% - 60px); margin-left: 60px !important; }
            .timeline-dot { left: 30px; }
            .page-title { font-size: 2.5rem; }
        }
    </style>
</head>
<body>

    <!-- Navigation Bar (Đã cập nhật link Active) -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">
                <i class="fas fa-plane me-2"></i>
                Air Agent
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="../../index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Về chúng tôi</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Dịch vụ VIP</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary-custom text-white" href="../../login.php">
                            Đăng nhập <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 reveal">
                    <h1 class="page-title">Câu Chuyện Của Chúng Tôi</h1>
                    <p class="lead opacity-75">Hành trình hơn một thập kỷ kiến tạo những chuyến đi hoàn hảo và kết nối hàng triệu trái tim.</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Mission & Vision Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 reveal-left">
                    <div class="mission-card text-center">
                        <i class="fas fa-eye mission-icon"></i>
                        <h3>Tầm Nhìn</h3>
                        <p class="text-muted mt-3">Trở thành thương hiệu đại lý du lịch và vé máy bay hàng đầu Đông Nam Á vào năm 2030, tiên phong trong việc áp dụng công nghệ vào trải nghiệm khách hàng.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 reveal">
                    <div class="mission-card text-center" style="border-top-color: var(--secondary-color)">
                        <i class="fas fa-bullseye mission-icon" style="color: var(--secondary-color)"></i>
                        <h3>Sứ Mệnh</h3>
                        <p class="text-muted mt-3">Mang đến cho khách hàng những giải pháp di chuyển tối ưu nhất về chi phí và thời gian, biến mỗi chuyến đi trở thành một trải nghiệm hạnh phúc và đáng nhớ.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 reveal-right">
                     <div class="mission-card text-center" style="border-top-color: #28a745">
                        <i class="fas fa-heart mission-icon" style="color: #28a745"></i>
                        <h3>Giá Trị Cốt Lõi</h3>
                        <p class="text-muted mt-3"><strong>Tận Tâm:</strong> Khách hàng là trung tâm.<br><strong>Uy Tín:</strong> Cam kết là thực hiện.<br><strong>Chuyên Nghiệp:</strong> Nhanh chóng và hiệu quả.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History Timeline Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5 reveal">
                <h6 class="text-primary fw-bold text-uppercase">Lịch sử hình thành</h6>
                <h2 class="fw-bold display-5">Chặng Đường Phát Triển</h2>
            </div>
            <div class="timeline">
                <!-- Timeline Item 1 -->
                <div class="timeline-item reveal-left">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <span class="timeline-year">2013</span>
                        <h4>Khởi đầu khiêm tốn</h4>
                        <p class="text-muted mb-0">Thành lập văn phòng đầu tiên tại Hà Nội với đội ngũ chỉ 5 thành viên đầy nhiệt huyết.</p>
                    </div>
                </div>
                <!-- Timeline Item 2 -->
                <div class="timeline-item reveal-right">
                     <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <span class="timeline-year">2016</span>
                        <h4>Đối tác chiến lược IATA</h4>
                        <p class="text-muted mb-0">Chính thức trở thành thành viên của Hiệp hội Vận tải Hàng không Quốc tế (IATA), mở rộng mạng lưới đối tác toàn cầu.</p>
                    </div>
                </div>
                <!-- Timeline Item 3 -->
                <div class="timeline-item reveal-left">
                     <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <span class="timeline-year">2019</span>
                        <h4>Mở rộng quy mô</h4>
                        <p class="text-muted mb-0">Khai trương chi nhánh tại TP.HCM và Đà Nẵng. Đạt mốc 1 triệu lượt khách hàng phục vụ.</p>
                    </div>
                </div>
                 <!-- Timeline Item 4 -->
                 <div class="timeline-item reveal-right">
                    <div class="timeline-dot"></div>
                   <div class="timeline-content">
                       <span class="timeline-year">Nay</span>
                       <h4>Tiên phong công nghệ</h4>
                       <p class="text-muted mb-0">Ra mắt hệ thống đặt vé thông minh AI, lọt Top 10 Đại lý du lịch uy tín nhất Việt Nam.</p>
                   </div>
               </div>
            </div>
        </div>
    </section>

    <!-- Leadership Team Section -->
    <section class="py-5">
        <div class="container py-5">
             <div class="text-center mb-5 reveal">
                <h6 class="text-primary fw-bold text-uppercase">Đội ngũ lãnh đạo</h6>
                <h2 class="fw-bold display-5">Những Người Dẫn Đường</h2>
            </div>
            <div class="row g-4">
                <!-- Team Member 1 -->
                <div class="col-md-6 col-lg-4 reveal-left">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="../../img/info/about/img2.jpg" alt="CEO">
                        </div>
                        <div class="member-info">
                            <h4 class="fw-bold mb-1">Trần Văn Hùng</h4>
                            <p class="text-primary mb-3">Sáng lập & CEO</p>
                            <p class="text-muted fst-italic">"Chúng tôi không chỉ bán vé, chúng tôi bán sự an tâm."</p>
                            <div class="member-social mt-4">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- Team Member 2 -->
                 <div class="col-md-6 col-lg-4 reveal">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="../../img/info/about/img3.jpg" alt="CMO">
                        </div>
                        <div class="member-info">
                            <h4 class="fw-bold mb-1">Nguyễn Thu Hà</h4>
                            <p class="text-primary mb-3">Giám đốc Vận hành (COO)</p>
                            <p class="text-muted fst-italic">"Sự hài lòng của khách hàng là thước đo thành công duy nhất."</p>
                            <div class="member-social mt-4">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- Team Member 3 -->
                 <div class="col-md-6 col-lg-4 reveal-right">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="../../img/info/about/img4.jpg" alt="CTO">
                        </div>
                        <div class="member-info">
                            <h4 class="fw-bold mb-1">Lê Minh Tuấn</h4>
                            <p class="text-primary mb-3">Giám đốc Khách hàng VIP</p>
                            <p class="text-muted fst-italic">"Mỗi yêu cầu khó khăn là một cơ hội để khẳng định đẳng cấp."</p>
                            <div class="member-social mt-4">
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (Giống trang chủ) -->
    <footer id="contact" class="pt-5">
        <div class="container pt-5 reveal">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <a class="navbar-brand text-white mb-4 d-block" href="index.html">
                        <i class="fas fa-plane me-2 text-warning"></i>
                        SkyLine Travel
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
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Tuyển dụng</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h5 class="text-white mb-4">Hỗ Trợ</h5>
                    <ul class="list-unstyled opacity-75">
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Câu hỏi thường gặp</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Chính sách bảo mật</a></li>
                        <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Điều khoản sử dụng</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white mb-4">Liên Hệ</h5>
                    <ul class="list-unstyled text-white opacity-75">
                        <li class="mb-3"><i class="fas fa-map-marker-alt me-3 text-warning"></i> 88 Láng Hạ, Đống Đa, Hà Nội</li>
                        <li class="mb-3"><i class="fas fa-phone-alt me-3 text-warning"></i> 1900 1234</li>
                        <li class="mb-3"><i class="fas fa-envelope me-3 text-warning"></i> info@airagent.vn</li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary py-4 text-center opacity-50">
                <small>&copy; 2023 Air Agent Travel. All rights reserved.</small>
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