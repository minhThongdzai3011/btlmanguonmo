<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách bookings từ database
 * @return array Danh sách booking
 */
function getAllBookings() {
    $conn = getDbConnection();

    // Truy vấn lấy tất cả bookings
    $sql = "SELECT id, booking_code, booking_name, time, type, quantity, price FROM bookings ORDER BY id";
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


                
