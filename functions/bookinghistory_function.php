<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách bookings từ database
 * @return array Danh sách booking
 */
function getAllBookings() {
    $conn = getDbConnection();

    // Truy vấn lấy tất cả bookings
    $sql = "SELECT id, product_code, product_name, time, type, quantity, price 
            FROM bookinghistory ORDER BY id";
    $result = mysqli_query($conn, $sql);

    $bookings = [];
    if ($result && mysqli_num_rows($result) > 0) {
        // Lặp qua từng dòng trong kết quả truy vấn $result
        while ($row = mysqli_fetch_assoc($result)) { 
            $bookings[] = $row; // Thêm mảng $row vào cuối mảng $bookings
        }
    }
    
    mysqli_close($conn);
    return $bookings;
}

/**
 * Thêm bookings mới
 * @param string $product_code Mã booking
 * @param string $product_name Tên booking
 * @param string $type Loại vé
 * @param int $quantity Số lượng vé
 * @param float $price Giá vé
 * @param string $time Thời gian đặt vé
 * @return bool True nếu thành công, False nếu thất bại
 */
function addBooking($product_code, $product_name, $type, $quantity, $time, $price) {
    $conn = getDbConnection();
    
    // Thời gian hiện tại
    $time = date('Y-m-d H:i:s');

    $sql = "INSERT INTO bookinghistory (product_code, product_name, time, type, quantity, price) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssi", $product_code, $product_name, $time, $type, $quantity, $price);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}

                
