<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách agents từ database
 * @return array Danh sách agents
 */
function getAllAgents() {
    $conn = getDbConnection();

    // Truy vấn lấy tất cả agents
    $sql = "SELECT id, agent_code, agent_name, contactPerson, position, email, phoneNumber, fullAddress, city, currentState, commissionRate, sales, note FROM agents ORDER BY id";
    $result = mysqli_query($conn, $sql);

    $agents = [];
    if ($result && mysqli_num_rows($result) > 0) {
        // Lặp qua từng dòng trong kết quả truy vấn $result
        while ($row = mysqli_fetch_assoc($result)) { 
            $agents[] = $row; // Thêm mảng $row vào cuối mảng $agents
        }
    }
    
    mysqli_close($conn);
    return $agents;
}

/**
 * Thêm agent mới
 * @param string $agent_code Mã đại lý
 * @param string $agent_name Tên đại lý
 * @param string $contact_person Người liên hệ
 * @param string $position Chức vụ
 * @param string $email Email đại lý
 * @param string $phone_number Số điện thoại đại lý
 * @param string $full_address Địa chỉ đầy đủ
 * @param string $city Thành phố
 * @param string $current_state Trạng thái hiện tại
 * @param float $commission_rate Tỷ lệ hoa hồng
 * @param float $sales Doanh thu dự kiến
 * @return bool True nếu thành công, False nếu thất bại
 */
function addAgent($agent_code, $agent_name, $contact_person, $position, $email, $phone_number, $full_address, $city, $current_state, $commission_rate, $sales) {
    $conn = getDbConnection();

    $sql = "INSERT INTO agents (agent_code, agent_name, contactPerson, position, email, phoneNumber, fullAddress, city, currentState, commissionRate, sales) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssssssss", $agent_code, $agent_name, $contact_person, $position, $email, $phone_number, $full_address, $city, $current_state, $commission_rate, $sales);
        $success = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }
    
    mysqli_close($conn);
    return false;
}

/**
 * Lấy thông tin một angent theo ID
 * @param int $id ID của agent
 * @return array|null Thông tin agent hoặc null nếu không tìm thấy
 */
function getAgentById($id) {
    $conn = getDbConnection();

    $sql = "SELECT id, agent_code, agent_name, contactPerson, position, email, phoneNumber, fullAddress, city, currentState, commissionRate, sales, note FROM agents WHERE id = ? LIMIT 1";
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
 * Cập nhật thông tin agent
 * @param int $id ID của agent
 * @param string $agent_code Mã đại lý mới
 * @param string $agent_name Tên đại lý mới
 * @param string $contact_person Người liên hệ mới
 * @param string $email Email đại lý mới
 * @param string $phone_number Số điện thoại đại lý mới
 * @param string $current_state Trạng thái hiện tại mới
 * @param string $note Ghi chú mới
 * @return bool True nếu thành công, False nếu thất bại
 */

/**
 * Cập nhật thông tin agent
 */
function updateAgent($id, $agent_code, $agent_name, $contact_person, $email, $phone_number, $current_state, $note, $sales, $commission_rate, $position) {
    $conn = getDbConnection();

    $sql = "UPDATE agents SET 
                agent_code = ?, 
                agent_name = ?, 
                contactPerson = ?, 
                email = ?, 
                phoneNumber = ?, 
                currentState = ?, 
                note = ?, 
                sales = ?, 
                commissionRate = ?, 
                position = ? 
            WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // SỬA: 11 tham số = 10 's' + 1 'i' = "ssssssssssi"
        mysqli_stmt_bind_param($stmt, "ssssssssssi", 
            $agent_code,      // s
            $agent_name,      // s
            $contact_person,  // s  
            $email,           // s
            $phone_number,    // s
            $current_state,   // s
            $note,            // s
            $sales,           // s (để string để tránh lỗi float)
            $commission_rate, // s (để string để tránh lỗi float)
            $position,        // s
            $id               // i (integer)
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
 * Xóa agent theo ID
 * @param int $id ID của agent cần xóa
 * @return bool True nếu thành công, False nếu thất bại
 */
function deleteAgent($id) {
    $conn = getDbConnection();

    $sql = "DELETE FROM agents WHERE id = ?";
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
