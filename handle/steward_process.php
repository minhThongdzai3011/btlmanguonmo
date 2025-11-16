<?php
// session_start();
require_once __DIR__ . '/../functions/steward_funtion.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateSteward();
        break;
    case 'edit':
        handleEditSteward();
        break;
    case 'delete':
        handleDeleteSteward();
        break;
}
/**
 * Lấy tất cả danh sách steward
 */
function handleGetAllStewards() {
    return getAllStewards();
}

function handleGetStewardById($id) {
    return getStewardById($id);
}

/**
 * Xử lý tạo steward mới
 */
function handleCreateSteward() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/steward.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['steward_code']) || !isset($_POST['steward_name'])) {
        header("Location: ../views/steward/create_steward.php?error=Thiếu thông tin cần thiết");
        exit();
    }

    $steward_code = trim($_POST['steward_code']);
    $steward_name = trim($_POST['steward_name']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    

    // Validate dữ liệu
    if (empty($steward_code) || empty($steward_name) || empty($age) || empty($gender)) {
        header("Location: ../views/steward/create_steward.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm steward
    $result = addSteward($steward_code, $steward_name, $age, $gender);
    
    if ($result) {
        header("Location: ../views/steward/index.php?success=Thêm steward thành công");
    } else {
        header("Location: ../views/steward/create_steward.php?error=Có lỗi xảy ra khi thêm steward");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa steward
 */
function handleEditSteward() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/steward.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['id']) || !isset($_POST['steward_code']) || !isset($_POST['steward_name'])) {
        header("Location: ../views/steward.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $id = $_POST['id'];
    $steward_code = trim($_POST['steward_code']);
    $steward_name = trim($_POST['steward_name']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    

    // Validate dữ liệu
    if (empty($steward_code) || empty($steward_name) || empty($age) || empty($gender)) {
        header("Location: ../views/steward/edit_steward.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi function để cập nhật steward
    $result = updateSteward($id, $steward_code, $steward_name, $age, $gender);
    
    if ($result) {
        header("Location: ../views/steward/index.php?success=Cập nhật steward thành công");
    } else {
        header("Location: ../views/steward/edit_steward.php?id=" . $id . "&error=Cập nhật steward thất bại");
    }
    exit();
}

/**
 * Xử lý xóa steward
 */
function handleDeleteSteward() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/steward/index.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../views/steward/index.php?error=Không tìm thấy ID steward");
        exit();
    }
    
    $id = $_GET['id'];
    
    // Validate ID là số
    if (!is_numeric($id)) {
        header("Location: ../views/steward/index.php?error=ID steward không hợp lệ");
        exit();
    }

    // Gọi function để xóa steward
    $result = deleteSteward($id);

    if ($result) {
        header("Location: ../views/steward/index.php?success=Xóa steward thành công");
    } else {
        header("Location: ../views/steward/index.php?error=Xóa steward thất bại");
    }
    exit();
}
?>
