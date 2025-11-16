<?php
// session_start();
require_once __DIR__ . '/../functions/booking_function.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

/**
 * Lấy tất cả danh sách bookings
 */
function handleGetAllBookings() {
    return getAllBookings();
}


