<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách stewards từ database
 * @return array Danh sách steward
 */
function getAllStewards() {
    $conn = getDbConnection();

    // Truy vấn lấy tất cả stewards
    $sql = "SELECT id, steward_code, steward_name, age, gender FROM stewards ORDER BY id";
    $result = mysqli_query($conn, $sql);

    $stewards = [];
    if ($result && mysqli_num_rows($result) > 0) {
        // Lặp qua từng dòng trong kết quả truy vấn $result
        while ($row = mysqli_fetch_assoc($result)) { 
            $stewards[] = $row; // Thêm mảng $row vào cuối mảng $stewards
        }
    }
    
    mysqli_close($conn);
    return $stewards;
}

/**
 * Thêm steward mới
 * @param string $steward_code Mã steward
 * @param string $steward_name Tên steward
 * @param int $age Tuổi steward
 * @param string $gender Giới tính steward
 * @return bool True nếu thành công, False nếu thất bại
 */
function addSteward($steward_code, $steward_name, $age, $gender) {
    $conn = getDbConnection();

    $sql = "INSERT INTO stewards (steward_code, steward_name, age, gender) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssis", $steward_code, $steward_name, $age, $gender);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}
 

/**
 * Lấy thông tin một steward theo ID
 * @param int $id ID của steward
 * @return array|null Thông tin steward hoặc null nếu không tìm thấy
 */
function getStewardById($id) {
    $conn = getDbConnection();

    $sql = "SELECT id, steward_code, steward_name, age, gender FROM stewards WHERE id = ? LIMIT 1";
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
 * Cập nhật thông tin steward
 * @param int $id ID của steward
 * @param string $steward_code Mã steward mới
 * @param string $steward_name Tên steward mới
 * @param int $age Tuổi steward mới
 * @param string $gender Giới tính steward mới
 * @return bool True nếu thành công, False nếu thất bại
 */

/**
 * Cập nhật thông tin steward
 */
function updateSteward($id, $steward_code, $steward_name, $age, $gender) {
    $conn = getDbConnection();

    $sql = "UPDATE stewards SET 
                steward_code = ?, 
                steward_name = ?, 
                age = ?, 
                gender = ?
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssisi", 
            $steward_code, 
            $steward_name, 
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
 * Xóa steward theo ID
 * @param int $id ID của steward cần xóa
 * @return bool True nếu thành công, False nếu thất bại
 */
function deleteSteward($id) {
    $conn = getDbConnection();

    $sql = "DELETE FROM stewards WHERE id = ?";
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

                
