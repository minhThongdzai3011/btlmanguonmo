<?php
// session_start();
require_once __DIR__ . '/../functions/flight_functions.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateFlight();
        break;
    case 'edit':
        handleEditFlight();
        break;
    case 'delete':
        handleDeleteFlight();
        break;
    // default:
    //     header("Location: ../views/student.php?error=Hành động không hợp lệ");
    //     exit();
}
/**
 * Lấy tất cả danh sách nhân viên
 */
function handleGetAllFlights() {
    return getAllFlights();
}

function handleGetFlightById($id) {
    return getFlightById($id);
}

/**
 * Xử lý tạo chuyến bay mới
 */
function handleCreateFlight() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/flight/index.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['flight_code']) || !isset($_POST['flight_name'])) {
        header("Location: ../views/flight/create_flight.php?error=Thiếu thông tin cần thiết");
        exit();
    }

    $flight_code = trim($_POST['flight_code']);
    $flight_name = trim($_POST['flight_name']);
    $airline_code = trim($_POST['airline_code']);
    $captain_code = trim($_POST['captain_code']);
    $steward_code = trim($_POST['steward_code']);
    $origin = trim($_POST['origin']);
    $destination = trim($_POST['destination']);
    $flight_time = trim($_POST['flight_time']);

    

    
    // Validate dữ liệu
    if (empty($flight_code) || empty($flight_name) || empty($airline_code) || empty($captain_code) || empty($steward_code) || empty($origin) || empty($destination) || empty($flight_time)) {
        header("Location: ../views/flight/create_flight.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm chuyến bay
    $result = addFlight($flight_code, $flight_name, $airline_code, $captain_code, $steward_code, $flight_time, $origin, $destination);

    if ($result) {
        header("Location: ../views/flight/index.php?success=Thêm chuyến bay thành công");
    } else {
        header("Location: ../views/flight/create_flight.php?error=Có lỗi xảy ra khi thêm chuyến bay");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa chuyến bay
 */
function handleEditFlight() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/flight/index.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['id']) || !isset($_POST['flight_code']) || !isset($_POST['flight_name'])) {
        header("Location: ../views/flight/index.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $id = $_POST['id'];
    $flight_code = trim($_POST['flight_code']);
    $flight_name = trim($_POST['flight_name']);
    $airline_code = trim($_POST['airline_code']);
    $captain_code = trim($_POST['captain_code']);
    $steward_code = trim($_POST['steward_code']);
    $origin = trim($_POST['origin']);
    $destination = trim($_POST['destination']);
    $flight_time = trim($_POST['flight_time']);

    // Validate dữ liệu
    if (empty($flight_code) || empty($flight_name) || empty($airline_code) || empty($captain_code) || empty($steward_code) || empty($origin) || empty($destination)) {
        header("Location: ../views/flight/edit_flight.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // SỬA: Gọi function với đúng thứ tự parameters
    $result = updateFlight($id, $flight_code, $flight_name, $airline_code, $captain_code, $steward_code, $flight_time, $origin, $destination);

    if ($result) {
        header("Location: ../views/flight/index.php?success=Cập nhật chuyến bay thành công");
    } else {
        header("Location: ../views/flight/edit_flight.php?id=" . $id . "&error=Cập nhật chuyến bay thất bại");
    }
    exit();
}

/**
 * Xử lý xóa chuyến bay
 */
function handleDeleteFlight() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/flight/index.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../views/flight/index.php?error=Không tìm thấy ID chuyến bay");
        exit();
    }
    
    $id = $_GET['id'];
    
    // Validate ID là số
    if (!is_numeric($id)) {
        header("Location: ../views/flight/index.php?error=ID chuyến bay không hợp lệ");
        exit();
    }

    // Gọi function để xóa chuyến bay
    $result = deleteFlight($id);

    if ($result) {
        header("Location: ../views/flight/index.php?success=Xóa chuyến bay thành công");
    } else {
        header("Location: ../views/flight/index.php?error=Xóa chuyến bay thất bại");
    }
    exit();
}
?>
