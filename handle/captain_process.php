<?php
// session_start();
require_once __DIR__ . '/../functions/captain_function.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateCaptain();
        break;
    case 'edit':
        handleEditCaptain();
        break;
    case 'delete':
        handleDeleteCaptain();
        break;
}
/**
 * Lấy tất cả danh sách sản phẩm
 */
function handleGetAllCaptains() {
    return getAllCaptains();
}

function handleGetCaptainById($id) {
    return getCaptainById($id);
}

/**
 * Xử lý tạo captain mới
 */
function handleCreateCaptain() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/captain.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['captain_code']) || !isset($_POST['captain_name'])) {
        header("Location: ../views/captain/create_captain.php?error=Thiếu thông tin cần thiết");
        exit();
    }

    $captain_code = trim($_POST['captain_code']);
    $captain_name = trim($_POST['captain_name']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    

    // Validate dữ liệu
    if (empty($captain_code) || empty($captain_name) || empty($age) || empty($gender)) {
        header("Location: ../views/captain/create_captain.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm captain
    $result = addCaptain($captain_code, $captain_name, $age, $gender);
    
    if ($result) {
        header("Location: ../views/captain/index.php?success=Thêm captain thành công");
    } else {
        header("Location: ../views/captain/create_captain.php?error=Có lỗi xảy ra khi thêm captain");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa captain
 */
function handleEditCaptain() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/captain.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['id']) || !isset($_POST['captain_code']) || !isset($_POST['captain_name'])) {
        header("Location: ../views/captain.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $id = $_POST['id'];
    $captain_code = trim($_POST['captain_code']);
    $captain_name = trim($_POST['captain_name']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    

    // Validate dữ liệu
    if (empty($captain_code) || empty($captain_name) || empty($age) || empty($gender)) {
        header("Location: ../views/captain/edit_captain.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi function để cập nhật sản phẩm
    $result = updateCaptain($id, $captain_code, $captain_name, $age, $gender);
    
    if ($result) {
        header("Location: ../views/captain/index.php?success=Cập nhật captain thành công");
    } else {
        header("Location: ../views/captain/edit_captain.php?id=" . $id . "&error=Cập nhật captain thất bại");
    }
    exit();
}

/**
 * Xử lý xóa captain
 */
function handleDeleteCaptain() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/captain/index.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../views/captain/index.php?error=Không tìm thấy ID captain");
        exit();
    }
    
    $id = $_GET['id'];
    
    // Validate ID là số
    if (!is_numeric($id)) {
        header("Location: ../views/captain/index.php?error=ID captain không hợp lệ");
        exit();
    }

    // Gọi function để xóa captain
    $result = deleteCaptain($id);

    if ($result) {
        header("Location: ../views/captain/index.php?success=Xóa captain thành công");
    } else {
        header("Location: ../views/captain/index.php?error=Xóa captain thất bại");
    }
    exit();
}
?>
