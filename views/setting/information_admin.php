<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Admin Quản Lý Đại Lý - Bootstrap</title>
    <!-- Tải Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Tải Font Awesome 6 CDN cho Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJc5f5tBqfA/2A3K4xG2I3qV3pC1xQpG/7/6sD2vJz4gA8hN6z4g4p2QzYv5Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Light background */
        }
        /* Tùy chỉnh màu sắc để gần với tông xanh hàng không */
        :root {
            --bs-primary: #004488; /* Dark Blue */
            --bs-info: #00bcd4; /* Cyan Accent */
            --bs-light: #f0f7ff; /* Very light background for sections */
        }
        .bg-primary { background-color: var(--bs-primary) !important; }
        .text-primary { color: var(--bs-primary) !important; }
        .text-info { color: var(--bs-info) !important; }
        
        .section-header {
            font-size: 1.5rem; /* 24px */
            font-weight: 700;
            color: var(--bs-primary);
            border-bottom: 2px solid var(--bs-info);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .skill-badge {
            background-color: rgba(0, 188, 212, 0.1); /* info color with low opacity */
            color: var(--bs-info);
            padding: 0.5rem 1rem;
            border-radius: 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
        }
        .skill-badge:hover {
            background-color: var(--bs-info);
            color: white;
        }
    </style>
</head>
<body class="p-4 p-md-5">

    <!-- Nút Quay về Menu (Được thêm theo yêu cầu) -->
    <div class="container mb-4 d-flex justify-content-start">
        <button class="btn btn-info shadow-sm" onclick="alert('Đã quay về trang Menu. (Đây là chức năng giả lập)');">
            <i class="fas fa-arrow-left me-2"></i> Quay về trang Menu
        </button>
    </div>

    <!-- Container chính cho Hồ Sơ Cá Nhân -->
    <div class="container bg-white shadow-lg rounded-4 overflow-hidden">

        <!-- Header - Thông tin cơ bản và Chức danh -->
        <div class="bg-primary text-white p-4 p-md-5 d-flex flex-column flex-md-row align-items-center">
            
            <!-- Ảnh Đại Diện -->
            <div class="flex-shrink-0 mb-4 mb-md-0 me-md-4">
                <img src="https://placehold.co/120x120/004488/ffffff?text=ADMIN" 
                     onerror="this.onerror=null; this.src='https://placehold.co/120x120/004488/ffffff?text=ADMIN';"
                     alt="Ảnh đại diện" 
                     class="rounded-circle border border-5 border-info shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
            </div>

            <!-- Tên, Chức danh và Liên hệ -->
            <div class="text-center text-md-start flex-grow-1">
                <h1 class="display-5 fw-bold mb-1">LÊ THỊ BÍCH</h1>
                <p class="fs-5 fw-light border-bottom border-light border-opacity-50 pb-2 mb-3">ADMIN QUẢN LÝ MẠNG LƯỚI ĐẠI LÝ VÉ MÁY BAY</p>
                
                <!-- Liên hệ -->
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3">
                    <span class="d-flex align-items-center text-white-50"><i class="fas fa-envelope me-2 text-info"></i> bich.agency@email.com</span>
                    <span class="d-flex align-items-center text-white-50"><i class="fas fa-phone me-2 text-info"></i> (+84) 912 345 678</span>
                    <span class="d-flex align-items-center text-white-50"><i class="fas fa-map-marker-alt me-2 text-info"></i> Hà Nội, Việt Nam</span>
                </div>
            </div>
        </div>

        <!-- Nội dung chính - Tóm tắt, Kinh nghiệm, Kỹ năng -->
        <div class="row p-4 p-md-5 g-5">
            
            <!-- Cột 1: Kỹ năng & Tóm tắt (4/12) -->
            <div class="col-lg-4">
                
                <!-- Tóm tắt Cá nhân -->
                <section class="p-4 rounded-3 shadow-sm mb-5 bg-light">
                    <div class="section-header">
                        <i class="fas fa-user-tie me-3 text-info"></i> Hồ Sơ Chuyên Môn
                    </div>
                    <p class="text-secondary">
                        Chuyên viên quản lý đại lý cấp cao với 7 năm kinh nghiệm chuyên sâu trong ngành vé máy bay. Chuyên trách phát triển và duy trì mạng lưới đối tác, tối ưu hóa hiệu suất bán hàng qua hệ thống GDS và đảm bảo tuân thủ quy định hàng không quốc tế (IATA). Đã giúp tăng trưởng doanh thu vé máy bay của mạng lưới đại lý lên 20% mỗi năm.
                    </p>
                </section>

                <!-- Kỹ Năng -->
                <section class="p-4 rounded-3 shadow-sm border border-1">
                    <div class="section-header">
                        <i class="fas fa-layer-group me-3 text-info"></i> Kho Kỹ Năng Kỹ Thuật
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="skill-badge">Amadeus/Sabre/Galileo (GDS)</span>
                        <span class="skill-badge">Quản lý Đối tác & Hợp đồng</span>
                        <span class="skill-badge">Phân tích Doanh số & Thị trường</span>
                        <span class="skill-badge">Quy định IATA & BSP</span>
                        <span class="skill-badge">Đào tạo Nghiệp vụ Ticketing</span>
                        <span class="skill-badge">Xử lý vé Phức tạp</span>
                        <span class="skill-badge">Chiến lược giá</span>
                    </div>
                </section>
            </div>

            <!-- Cột 2: Kinh nghiệm làm việc & Học vấn (8/12) -->
            <div class="col-lg-8">

                <!-- Kinh nghiệm Làm việc -->
                <section class="mb-5">
                    <div class="section-header">
                        <i class="fas fa-briefcase me-3 text-info"></i> Kinh Nghiệm Vận Hành
                    </div>
                    
                    <!-- Vị trí 1 -->
                    <div class="mb-4 ps-3 border-start border-info border-4 position-relative">
                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-circle bg-primary p-2"><i class="fas fa-check-circle fa-sm"></i></span>
                        <h3 class="h5 fw-bold text-dark">Trưởng phòng Quản lý Đại lý</h3>
                        <p class="text-primary fw-medium mb-1">Công ty Hàng không VietWings</p>
                        <p class="text-muted small mb-3">Tháng 05/2020 - Hiện tại</p>
                        <ul class="list-unstyled text-secondary">
                            <li><i class="fas fa-arrow-right me-2 text-info"></i> Lãnh đạo đội ngũ quản lý hơn 50 đại lý cấp 1, vượt mục tiêu doanh số 150 tỷ VNĐ/năm.</li>
                            <li><i class="fas fa-arrow-right me-2 text-info"></i> Xây dựng hệ thống báo cáo hiệu suất và đối soát tự động, giảm 40% sai sót nghiệp vụ.</li>
                            <li><i class="fas fa-arrow-right me-2 text-info"></i> Tổ chức các buổi đào tạo định kỳ về nghiệp vụ GDS và chính sách giá vé mới.</li>
                        </ul>
                    </div>
                    
                    <!-- Vị trí 2 -->
                    <div class="mb-4 ps-3 border-start border-info border-4 position-relative">
                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-circle bg-primary p-2"><i class="fas fa-check-circle fa-sm"></i></span>
                        <h3 class="h5 fw-bold text-dark">Chuyên viên Vận hành Hệ thống Vé</h3>
                        <p class="text-primary fw-medium mb-1">Đại lý Du lịch TravelPro</p>
                        <p class="text-muted small mb-3">Tháng 08/2016 - Tháng 04/2020</p>
                        <ul class="list-unstyled text-secondary">
                            <li><i class="fas fa-arrow-right me-2 text-info"></i> Thực hiện thành thạo nghiệp vụ đặt chỗ, xuất vé, hoàn/đổi vé trên các nền tảng GDS chính.</li>
                            <li><i class="fas fa-arrow-right me-2 text-info"></i> Giải quyết các sự cố liên quan đến vé máy bay phức tạp (multi-city, code-share).</li>
                            <li><i class="fas fa-arrow-right me-2 text-info"></i> Đảm bảo các giao dịch tuân thủ nghiêm ngặt theo quy định tài chính và IATA.</li>
                        </ul>
                    </div>
                </section>

                <!-- Giáo dục -->
                <section>
                    <div class="section-header">
                        <i class="fas fa-graduation-cap me-3 text-info"></i> Học Vấn
                    </div>
                    <div class="mb-4 ps-3 border-start border-info border-4 position-relative">
                        <span class="position-absolute top-0 start-0 translate-middle badge rounded-circle bg-primary p-2"><i class="fas fa-book fa-sm"></i></span>
                        <h3 class="h5 fw-bold text-dark">Cử nhân Quản trị Du lịch và Khách sạn</h3>
                        <p class="text-primary fw-medium mb-1">Đại học Kinh tế Quốc dân (NEU)</p>
                        <p class="text-muted small">2012 - 2016 | Tốt nghiệp loại Giỏi</p>
                    </div>
                </section>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-primary text-white text-center p-3">
            <p class="mb-0 small opacity-75">Admin Quản lý Đại lý Bán vé Máy bay | Luôn sẵn sàng cho thách thức mới.</p>
        </footer>
    </div>

    <!-- Tải Bootstrap JS (tùy chọn, cần cho một số component nâng cao) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>