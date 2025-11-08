<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách e từ database
 * @return array Danh sách employees
 */
function getAllEmployees() {
    $conn = getDbConnection();

    // Truy vấn lấy tất cả employees với thông tin agent
    $sql = "SELECT e.id, e.employee_code, e.employee_name, e.agent_code, e.birth_date, 
                   e.contact_position as position, e.email, e.phone, e.address, e.age, 
                   e.gender, e.salary, a.agent_name
            FROM employees e
            LEFT JOIN agents a ON e.agent_code = a.agent_code
            ORDER BY e.id";
    $result = mysqli_query($conn, $sql);

    $employees = [];
    if ($result && mysqli_num_rows($result) > 0) {
        // Lặp qua từng dòng trong kết quả truy vấn $result
        while ($row = mysqli_fetch_assoc($result)) { 
            $employees[] = $row; // Thêm mảng $row vào cuối mảng $employees
        }
    }
    
    mysqli_close($conn);
    return $employees;
}

/**
 * Thêm employee mới
 * @param string $employee_code Mã nhân viên
 * @param string $employee_name Tên nhân viên
 * @param string $agent_code Mã đại lý
 * @param string $birth_date Ngày sinh
 * @param string $contact_position Chức vụ
 * @param string $email Email nhân viên
 * @param string $phone Số điện thoại nhân viên
 * @param string $address Địa chỉ nhân viên
 * @param int $age Tuổi nhân viên
 * @param string $gender Giới tính nhân viên
 * @param float $salary Mức lương nhân viên
 * @return bool True nếu thành công, False nếu thất bại
 */
function addEmployee($employee_code, $employee_name, $agent_code, $birth_date, $contact_position, $email, $phone, $address, $age, $gender, $salary) {
    $conn = getDbConnection();

    $sql = "INSERT INTO employees (employee_code, employee_name, agent_code, birth_date, contact_position, email, phone, address, age, gender, salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssssssss", $employee_code, $employee_name, $agent_code, $birth_date, $contact_position, $email, $phone, $address, $age, $gender, $salary);
        $success = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }
    
    mysqli_close($conn);
    return false;
}

/**
 * Lấy thông tin một employee theo ID
 * @param int $id ID của employee
 * @return array|null Thông tin employee hoặc null nếu không tìm thấy
 */
function getEmployeeById($id) {
    $conn = getDbConnection();

    $sql = "SELECT id, employee_code, employee_name, agent_code, birth_date, contact_position, email, phone, address, age, gender, salary FROM employees WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $agent = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $agent;
        }
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
    return null;
}

/**
 * Cập nhật thông tin employee
 * @param int $id ID của employee
 * @param string $employee_code Mã nhân viên mới
 * @param string $employee_name Tên nhân viên mới
 * @param string $agent_code Mã đại lý mới
 * @param string $birth_date Ngày sinh mới
 * @param string $contact_position Chức vụ mới
 * @param string $email Email nhân viên mới
 * @param string $phone_number Số điện thoại nhân viên mới
 * @param string $address Địa chỉ nhân viên mới
 * @param int $age Tuổi nhân viên mới
 * @param float $salary Mức lương nhân viên mới
 * @return bool True nếu thành công, False nếu thất bại
 */

/**
 * Cập nhật thông tin employee
 */
function updateEmployee($id, $employee_code, $employee_name, $agent_code, $birth_date, $contact_position, $email, $phone, $address, $age, $gender, $salary) {
    $conn = getDbConnection();

    $sql = "UPDATE employees SET 
                employee_code = ?, 
                employee_name = ?, 
                agent_code = ?, 
                birth_date = ?, 
                contact_position = ?, 
                email = ?, 
                phone = ?, 
                address = ?, 
                age = ?, 
                gender = ?, 
                salary = ? 
            WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // SỬA: Dùng $phone thay vì $phone_number, đúng thứ tự parameters
        mysqli_stmt_bind_param($stmt, "ssssssssissi", 
            $employee_code,     // s - string
            $employee_name,     // s - string
            $agent_code,        // s - string
            $birth_date,        // s - string (date)
            $contact_position,  // s - string
            $email,             // s - string
            $phone,             // s - string (SỬA: $phone thay vì $phone_number)
            $address,           // s - string
            $age,               // i - integer
            $gender,            // s - string
            $salary,            // s - string (để tránh lỗi float)
            $id                 // i - integer
        );
        
        $success = mysqli_stmt_execute($stmt);
        $affected_rows = mysqli_affected_rows($conn);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        return $success && $affected_rows >= 0;
    }
    
    mysqli_close($conn);
    return false;
}

/**
 * Xóa employee theo ID
 * @param int $id ID của employee cần xóa
 * @return bool True nếu thành công, False nếu thất bại
 */
function deleteEmployee($id) {
    $conn = getDbConnection();

    $sql = "DELETE FROM employees WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $success = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }
    
    mysqli_close($conn);
    return false;
}
?>
