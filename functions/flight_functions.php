<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách e từ database
 * @return array Danh sách flights
 */
function getAllFlights() {
    $conn = getDbConnection();

    // Truy vấn lấy tất cả 
    $sql = "SELECT f.id, f.flight_code, f.flight_name, a.airline_code,
            c.captain_code, s.steward_code, f.origin, f.destination, f.flight_time
            FROM flight f
            LEFT JOIN airlines a ON f.airline_code = a.airline_code
            LEFT JOIN captains c ON f.captain_code = c.captain_code
            LEFT JOIN stewards s ON f.steward_code = s.steward_code
            ORDER BY f.id";
    $result = mysqli_query($conn, $sql);

    $flights = [];
    if ($result && mysqli_num_rows($result) > 0) {
        // Lặp qua từng dòng trong kết quả truy vấn $result
        while ($row = mysqli_fetch_assoc($result)) { 
            $flights[] = $row; // Thêm mảng $row vào cuối mảng $flights
        }
    }
    
    mysqli_close($conn);
    return $flights;
}

/**
 * Thêm flight mới
 * @param string $flight_code Mã chuyến bay
 * @param string $flight_name Tên chuyến bay
 * @param string $airline_code Mã hãng hàng không
 * @param string $captain_code Mã cơ trưởng
 * @param string $steward_code Mã tiếp viên
 * @param string $origin Nơi khởi hành
 * @param string $destination Nơi đến
 * @param string $flight_time Thời gian chuyến bay
 * 
 */
function addFlight($flight_code, $flight_name, $airline_code, $captain_code, $steward_code, $flight_time, $origin, $destination) {
    $conn = getDbConnection();

    $sql = "INSERT INTO flight (flight_code, flight_name, airline_code, captain_code, steward_code, flight_time, origin, destination) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $flight_code, $flight_name, $airline_code, $captain_code, $steward_code, $flight_time, $origin, $destination);
        $success = mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }
    
    mysqli_close($conn);
    return false;
}

/**
 * Lấy thông tin một flight theo ID
 * @param int $id ID của flight
 * @return array|null Thông tin flight hoặc null nếu không tìm thấy
 */
function getFlightById($id) {
    $conn = getDbConnection();

    $sql = "SELECT id, flight_code, flight_name, airline_code, captain_code, steward_code, flight_time, origin, destination FROM flight WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $flight = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $flight;
        }
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
    return null;
}

/**
 * Cập nhật thông tin flight
 * @param int $id ID của flight
 * @param string $flight_code Mã chuyến bay mới
 * @param string $flight_name Tên chuyến bay mới
 * @param string $airline_code Mã hãng hàng không mới
 * @param string $captain_code Mã cơ trưởng mới
 * @param string $steward_code Mã tiếp viên mới
 * @param string $flight_time Thời gian chuyến bay mới
 * @param string $origin Nơi khởi hành mới
 * @param string $destination Nơi đến mới
 * @return bool True nếu thành công, False nếu thất bại
 */

/**
 * Cập nhật thông tin flight
 */
function updateFlight($id, $flight_code, $flight_name, $airline_code, $captain_code, $steward_code, $flight_time, $origin, $destination) {
    $conn = getDbConnection();

    $sql = "UPDATE flight SET 
                flight_code = ?, 
                flight_name = ?, 
                airline_code = ?, 
                captain_code = ?, 
                steward_code = ?, 
                flight_time = ?, 
                origin = ?, 
                destination = ? 
            WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssssi", 
            $flight_code,     // s - string
            $flight_name,     // s - string
            $airline_code,        // s - string
            $captain_code,        // s - string
            $steward_code,        // s - string
            $flight_time,        // s - string (date)
            $origin,  // s - string
            $destination,             // s - string
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
 * Xóa flight theo ID
 * @param int $id ID của flight cần xóa
 * @return bool True nếu thành công, False nếu thất bại
 */
function deleteFlight($id) {
    $conn = getDbConnection();

    $sql = "DELETE FROM flights WHERE id = ?";
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
