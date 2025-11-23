<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách user từ database
 * @return array Danh sách user
 */
function getAllUsers() {
    $conn = getDbConnection();

    // Truy vấn lấy tất cả users
    $sql = "SELECT id, username, password, role
            FROM users ORDER BY id";
    $result = mysqli_query($conn, $sql);

    $users = [];
    if ($result && mysqli_num_rows($result) > 0) {
        // Lặp qua từng dòng trong kết quả truy vấn $result
        while ($row = mysqli_fetch_assoc($result)) {
            // Chỉ thêm vào mảng nếu role = "user"
            if ($row['role'] === "user") {
                $users[] = $row;
            }
        }
    }
    
    mysqli_close($conn);
    return $users;
}

/**
 * Thêm users mới
 * @param string $username tên user
 * @param string $password  mật khẩu user
 * @param string $role phân quyền user
 */
function addUser($username, $password, $role) {
    $conn = getDbConnection();
    

    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $username, $password, $role);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}

                
