<?php
// session_start();
require_once __DIR__ . '/../functions/bookinghistory_function.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateBooking();
        break;
}
/**
 * Lấy tất cả danh sách sản phẩm
 */
function handleGetAllBookings() {
    return getAllBookings();
}


/**
 * Xử lý tạo booking mới
 */
function handleCreateBooking() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/user/booking_history.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['booking_code']) || !isset($_POST['booking_name'])) {
        header("Location: ../views/user/booking_history.php?error=Thiếu thông tin cần thiết");
        exit();
    }

    $booking_code = trim($_POST['booking_code']);
    $booking_name = trim($_POST['booking_name']);
    $type = trim($_POST['type']);
    $quantity = intval(trim($_POST['quantity']));
    $price = floatval(trim($_POST['price']));
    $time = date('Y-m-d H:i:s');
    
    // Validate dữ liệu
    if (empty($booking_code) || empty($booking_name) || empty($type) || $quantity <= 0 || $price <= 0) {
        header("Location: ../views/user/booking_history.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm booking
    $result = addBooking($booking_code, $booking_name, $type, $quantity, $time, $price);
    
    if ($result) {
        header("Location: ../views/user/booking_history.php?success=Đặt vé thành công");
    } else {
        header("Location: ../views/user/booking_history.php?error=Có lỗi xảy ra khi đặt vé");
    }
    exit();
}


?>
