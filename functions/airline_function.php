<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách airlines từ database
 * @return array Danh sách airlines
 */
function getAllAirlines() {
    $conn = getDbConnection();

    // Truy vấn lấy tất cả airlines
    $sql = "SELECT id, airline_code, airline_name FROM airlines ORDER BY id";
    $result = mysqli_query($conn, $sql);

    $airlines = [];
    if ($result && mysqli_num_rows($result) > 0) {
        // Lặp qua từng dòng trong kết quả truy vấn $result
        while ($row = mysqli_fetch_assoc($result)) { 
            $airlines[] = $row; // Thêm mảng $row vào cuối mảng $airlines
        }
    }
    
    mysqli_close($conn);
    return $airlines;
}

/**
 * Thêm airline mới
 * @param string $airline_code Mã airline
 * @param string $airline_name Tên airline
 * @return bool True nếu thành công, False nếu thất bại
 */
function addAirline($airline_code, $airline_name) {
    $conn = getDbConnection();

    $sql = "INSERT INTO airlines (airline_code, airline_name) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $airline_code, $airline_name);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}
 

/**
 * Lấy thông tin một airline theo ID
 * @param int $id ID của airline
 * @return array|null Thông tin airline hoặc null nếu không tìm thấy
 */
function getAirlineById($id) {
    $conn = getDbConnection();

    $sql = "SELECT id, airline_code, airline_name FROM airlines WHERE id = ? LIMIT 1";
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
 * Cập nhật thông tin airline
 * @param int $id ID của airline
 * @param string $airline_code Mã airline mới
 * @param string $airline_name Tên airline mới
 * @return bool True nếu thành công, False nếu thất bại
 */

/**
 * Cập nhật thông tin airline
 */
function updateAirline($id, $airline_code, $airline_name) {
    $conn = getDbConnection();

    $sql = "UPDATE airlines SET 
                airline_code = ?, 
                airline_name = ?
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", 
            $airline_code, 
            $airline_name, 
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
 * Xóa airline theo ID
 * @param int $id ID của airline cần xóa
 * @return bool True nếu thành công, False nếu thất bại
 */
function deleteAirline($id) {
    $conn = getDbConnection();

    $sql = "DELETE FROM airlines WHERE id = ?";
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

                
