<?php
// session_start();
require_once __DIR__ . '/../functions/employee_function.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateEmployee();
        break;
    case 'edit':
        handleEditEmployee();
        break;
    case 'delete':
        handleDeleteEmployee();
        break;
    // default:
    //     header("Location: ../views/student.php?error=Hành động không hợp lệ");
    //     exit();
}
/**
 * Lấy tất cả danh sách nhân viên
 */
function handleGetAllEmployees() {
    return getAllEmployees();
}

function handleGetEmployeeById($id) {
    return getEmployeeById($id);
}

/**
 * Xử lý tạo nhân viên mới
 */
function handleCreateEmployee() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/employee/index.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['employee_code']) || !isset($_POST['employee_name'])) {
        header("Location: ../views/employee/create_employee.php?error=Thiếu thông tin cần thiết");
        exit();
    }

    $employee_code = trim($_POST['employee_code']);
    $employee_name = trim($_POST['employee_name']);
    $agent_code = trim($_POST['agent_code']);
    $position = trim($_POST['position']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    $birth_date = trim($_POST['birth_date']);
    $salary = trim($_POST['salary']);

    

    
    // Validate dữ liệu
    if (empty($employee_code) || empty($employee_name) || empty($agent_code) || empty($position) || empty($email) || empty($phone) || empty($address)|| empty($age) || empty($gender) || empty($birth_date) || empty($salary)) {
        header("Location: ../views/employee/create_employee.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm nhân viên
    $result = addEmployee($employee_code, $employee_name, $agent_code, $position, $email, $phone, $address, $age, $gender, $birth_date, $salary);

    if ($result) {
        header("Location: ../views/employee/index.php?success=Thêm nhân viên thành công");
    } else {
        header("Location: ../views/employee/create_employee.php?error=Có lỗi xảy ra khi thêm nhân viên");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa nhân viên
 */
function handleEditEmployee() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/employee/index.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['id']) || !isset($_POST['employee_code']) || !isset($_POST['employee_name'])) {
        header("Location: ../views/employee/index.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $id = $_POST['id'];
    $employee_code = trim($_POST['employee_code']);
    $employee_name = trim($_POST['employee_name']);
    $agent_code = trim($_POST['agent_code']);
    $birth_date = trim($_POST['birth_date']); // SỬA: Thêm birth_date
    $position = trim($_POST['position']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']); // SỬA: THÊM DÒNG NÀY!
    $salary = trim($_POST['salary']);

    // Validate dữ liệu
    if (empty($employee_code) || empty($employee_name) || empty($agent_code) || empty($birth_date) || empty($position) || empty($email) || empty($phone) || empty($address) || empty($age) || empty($gender) || empty($salary)) {
        header("Location: ../views/employee/edit_employee.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // SỬA: Gọi function với đúng thứ tự parameters
    $result = updateEmployee($id, $employee_code, $employee_name, $agent_code, $birth_date, $position, $email, $phone, $address, $age, $gender, $salary);

    if ($result) {
        header("Location: ../views/employee/index.php?success=Cập nhật nhân viên thành công");
    } else {
        header("Location: ../views/employee/edit_employee.php?id=" . $id . "&error=Cập nhật nhân viên thất bại");
    }
    exit();
}

/**
 * Xử lý xóa nhân viên
 */
function handleDeleteEmployee() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/employee/index.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../views/employee/index.php?error=Không tìm thấy ID nhân viên");
        exit();
    }
    
    $id = $_GET['id'];
    
    // Validate ID là số
    if (!is_numeric($id)) {
        header("Location: ../views/employee/index.php?error=ID nhân viên không hợp lệ");
        exit();
    }

    // Gọi function để xóa nhân viên
    $result = deleteEmployee($id);

    if ($result) {
        header("Location: ../views/employee/index.php?success=Xóa nhân viên thành công");
    } else {
        header("Location: ../views/employee/index.php?error=Xóa nhân viên thất bại");
    }
    exit();
}
?>
