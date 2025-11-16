<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách captains từ database
 * @return array Danh sách captain
 */
function getAllCaptains() {
    $conn = getDbConnection();

    // Truy vấn lấy tất cả captains
    $sql = "SELECT id, captain_code, captain_name, age, gender FROM captains ORDER BY id";
    $result = mysqli_query($conn, $sql);

    $captains = [];
    if ($result && mysqli_num_rows($result) > 0) {
        // Lặp qua từng dòng trong kết quả truy vấn $result
        while ($row = mysqli_fetch_assoc($result)) { 
            $captains[] = $row; // Thêm mảng $row vào cuối mảng $captains
        }
    }
    
    mysqli_close($conn);
    return $captains;
}

/**
 * Thêm captain mới
 * @param string $captain_code Mã captain
 * @param string $captain_name Tên captain
 * @param int $age Tuổi captain
 * @param string $gender Giới tính captain
 * @return bool True nếu thành công, False nếu thất bại
 */
function addCaptain($captain_code, $captain_name, $age, $gender) {
    $conn = getDbConnection();

    $sql = "INSERT INTO captains (captain_code, captain_name, age, gender) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssis", $captain_code, $captain_name, $age, $gender);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}
 

/**
 * Lấy thông tin một captain theo ID
 * @param int $id ID của captain
 * @return array|null Thông tin captain hoặc null nếu không tìm thấy
 */
function getCaptainById($id) {
    $conn = getDbConnection();

    $sql = "SELECT id, captain_code, captain_name, age, gender FROM captains WHERE id = ? LIMIT 1";
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
 * Cập nhật thông tin captain
 * @param int $id ID của captain
 * @param string $captain_code Mã captain mới
 * @param string $captain_name Tên captain mới
 * @param int $age Tuổi captain mới
 * @param string $gender Giới tính captain mới
 * @return bool True nếu thành công, False nếu thất bại
 */

/**
 * Cập nhật thông tin captain
 */
function updateCaptain($id, $captain_code, $captain_name, $age, $gender) {
    $conn = getDbConnection();

    $sql = "UPDATE captains SET 
                captain_code = ?, 
                captain_name = ?, 
                age = ?, 
                gender = ?
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssis", 
            $captain_code, 
            $captain_name, 
            $age, 
            $gender, 
            $id
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
 * Xóa captain theo ID
 * @param int $id ID của captain cần xóa
 * @return bool True nếu thành công, False nếu thất bại
 */
function deleteCaptain($id) {
    $conn = getDbConnection();

    $sql = "DELETE FROM captains WHERE id = ?";
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

                
