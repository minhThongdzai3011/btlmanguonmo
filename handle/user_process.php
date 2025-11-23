<?php
// session_start();
require_once __DIR__ . '/../functions/user_function.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateUser();
        break;
}
/**
 * Lấy tất cả danh sách user
 */
function handleGetAllUsers() {
    return getAllUsers();
}


/**
 * Xử lý tạo user mới
 */
function handleCreateUser() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/login/register.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['role'])) {
        header("Location: ../views/login/register.php?error=Thiếu thông tin cần thiết");
        exit();
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    
    // Validate dữ liệu
    if (empty($username) || empty($password) || empty($role)) {
        header("Location: ../views/login/register.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm user
    $result = addUser($username, $password, $role);
    
    if ($result) {
        header("Location: ../views/login/login.php?success=Đăng ký thành công! Vui lòng đăng nhập");
    } else {
        header("Location: ../views/login/register.php?error=Có lỗi xảy ra khi đăng ký. Tên đăng nhập có thể đã tồn tại");
    }
    exit();
}


?>
