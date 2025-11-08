<?php
// session_start();
require_once __DIR__ . '/../functions/agent_functions.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateAgent();
        break;
    case 'edit':
        handleEditAgent();
        break;
    case 'delete':
        handleDeleteAgent();
        break;
}
/**
 * Lấy tất cả danh sách đại lý
 */
function handleGetAllAgents() {
    return getAllAgents();
}

function handleGetAgentById($id) {
    return getAgentById($id);
}

/**
 * Xử lý tạo đại lý mới
 */
function handleCreateAgent() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/agent.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['agent_code']) || !isset($_POST['agent_name'])) {
        header("Location: ../views/agent/create_agent.php?error=Thiếu thông tin cần thiết");
        exit();
    }

    $agent_code = trim($_POST['agent_code']);
    $agent_name = trim($_POST['agent_name']);
    $contact_person = trim($_POST['contact_person']);
    $position = trim($_POST['position']);
    $email = trim($_POST['email']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $fullAddress = trim($_POST['fullAddress']);
    $city = trim($_POST['city']);
    $currentState = trim($_POST['currentState']);
    $commissionRate = trim ($_POST['commissionRate']);
    $sales = trim ($_POST['sales']);    
    $note = trim ($_POST['note']);

    
    // Validate dữ liệu
    if (empty($agent_code) || empty($agent_name) || empty($contact_person) || empty($position) || empty($email) || empty($phoneNumber) || empty($fullAddress) || empty($city) || empty($currentState) || empty($commissionRate) || empty($sales) || empty($note)) {
        header("Location: ../views/agent/create_agent.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm đại lý
    $result = addAgent($agent_code, $agent_name, $contact_person, $position, $email, $phoneNumber, $fullAddress, $city, $currentState, $commissionRate, $sales);
    
    if ($result) {
        header("Location: ../views/agent.php?success=Thêm đại lý thành công");
    } else {
        header("Location: ../views/agent/create_agent.php?error=Có lỗi xảy ra khi thêm đại lý");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa đại lý
 */
function handleEditAgent() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/main.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['id']) || !isset($_POST['agent_code']) || !isset($_POST['agent_name'])) {
        header("Location: ../views/main.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $id = $_POST['id'];
    $agent_code = trim($_POST['agent_code']);
    $agent_name = trim($_POST['agent_name']);
    $contact_person = trim($_POST['contact_person']);
    $email = trim($_POST['email']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $currentState = trim($_POST['currentState']);
    $commissionRate = trim($_POST['commissionRate']);
    $sales = trim($_POST['sales']);
    $note = trim($_POST['note']);
    $position = trim($_POST['position']);

    // Validate dữ liệu
    if (empty($agent_code) || empty($agent_name) || empty($contact_person) || empty($email) || empty($phoneNumber) || empty($currentState) || empty($position) || empty($commissionRate) || empty($sales)) {
        header("Location: ../views/agent/edit_agent.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi function để cập nhật đại lý
    $result = updateAgent($id, $agent_code, $agent_name, $contact_person, $email, $phoneNumber, $currentState, $note , $sales, $commissionRate, $position);
    
    if ($result) {
        header("Location: ../views/main.php?success=Cập nhật đại lý thành công");
    } else {
        header("Location: ../views/agent/edit_agent.php?id=" . $id . "&error=Cập nhật đại lý thất bại");
    }
    exit();
}

/**
 * Xử lý xóa đại lý
 */
function handleDeleteAgent() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/main.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../views/main.php?error=Không tìm thấy ID đại lý");
        exit();
    }
    
    $id = $_GET['id'];
    
    // Validate ID là số
    if (!is_numeric($id)) {
        header("Location: ../views/main.php?error=ID đại lý không hợp lệ");
        exit();
    }

    // Gọi function để xóa đại lý
    $result = deleteAgent($id);

    if ($result) {
        header("Location: ../views/main.php?success=Xóa đại lý thành công");
    } else {
        header("Location: ../views/main.php?error=Xóa đại lý thất bại");
    }
    exit();
}
?>
