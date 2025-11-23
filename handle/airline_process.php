<?php
// session_start();
require_once __DIR__ . '/../functions/airline_function.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateAirline();
        break;
    case 'edit':
        handleEditAirline();
        break;
    case 'delete':
        handleDeleteAirline();
        break;
}
/**
 * Lấy tất cả danh sách sản phẩm
 */
function handleGetAllAirlines() {
    return getAllAirlines();
}

function handleGetAirlineById($id) {
    return getAirlineById($id);
}

/**
 * Xử lý tạo airline mới
 */
function handleCreateAirline() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/airline.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['airline_code']) || !isset($_POST['airline_name'])) {
        header("Location: ../views/airline/create_airline.php?error=Thiếu thông tin cần thiết");
        exit();
    }

    $airline_code = trim($_POST['airline_code']);
    $airline_name = trim($_POST['airline_name']);
    

    // Validate dữ liệu
    if (empty($airline_code) || empty($airline_name)) {
        header("Location: ../views/airline/create_airline.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm airline
    $result = addAirline($airline_code, $airline_name);
    
    if ($result) {
        header("Location: ../views/airline/index.php?success=Thêm airline thành công");
    } else {
        header("Location: ../views/airline/create_airline.php?error=Có lỗi xảy ra khi thêm airline");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa airline
 */
function handleEditAirline() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/airline.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['id']) || !isset($_POST['airline_code']) || !isset($_POST['airline_name'])) {
        header("Location: ../views/airline.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $id = $_POST['id'];
    $airline_code = trim($_POST['airline_code']);
    $airline_name = trim($_POST['airline_name']);
    
    // Validate dữ liệu
    if (empty($airline_code) || empty($airline_name)) {
        header("Location: ../views/airline/edit_airline.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi function để cập nhật sản phẩm
    $result = updateAirline($id, $airline_code, $airline_name);
    
    if ($result) {
        header("Location: ../views/airline/index.php?success=Cập nhật airline thành công");
    } else {
        header("Location: ../views/airline/edit_airline.php?id=" . $id . "&error=Cập nhật airline thất bại");
    }
    exit();
}

/**
 * Xử lý xóa airline
 */
function handleDeleteAirline() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/airline/index.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../views/airline/index.php?error=Không tìm thấy ID airline");
        exit();
    }
    
    $id = $_GET['id'];
    
    // Validate ID là số
    if (!is_numeric($id)) {
        header("Location: ../views/captain/index.php?error=ID captain không hợp lệ");
        exit();
    }

    // Gọi function để xóa airline
    $result = deleteAirline($id);

    if ($result) {
        header("Location: ../views/airline/index.php?success=Xóa airline thành công");
    } else {
        header("Location: ../views/airline/index.php?error=Xóa airline thất bại");
    }
    exit();
}
?>
