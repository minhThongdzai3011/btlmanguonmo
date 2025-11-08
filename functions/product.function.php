<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách products từ database
 * @return array Danh sách products
 */
function getAllProducts() {
    $conn = getDbConnection();

    // Truy vấn lấy tất cả products
    $sql = "SELECT id, product_code, product_name, price, quantity FROM products ORDER BY id";
    $result = mysqli_query($conn, $sql);

    $products = [];
    if ($result && mysqli_num_rows($result) > 0) {
        // Lặp qua từng dòng trong kết quả truy vấn $result
        while ($row = mysqli_fetch_assoc($result)) { 
            $products[] = $row; // Thêm mảng $row vào cuối mảng $products
        }
    }
    
    mysqli_close($conn);
    return $products;
}

/**
 * Thêm product mới
 * @param string $product_code Mã sản phẩm
 * @param string $product_name Tên sản phẩm
 * @param float $price Giá sản phẩm
 * @param int $quantity Số lượng sản phẩm
 * @return bool True nếu thành công, False nếu thất bại
 */
function addProduct($product_code, $product_name, $price, $quantity) {
    $conn = getDbConnection();

    $sql = "INSERT INTO products (product_code, product_name, price, quantity) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $product_code, $product_name, $price, $quantity);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}
 

/**
 * Lấy thông tin một product theo ID
 * @param int $id ID của product
 * @return array|null Thông tin product hoặc null nếu không tìm thấy
 */
function getProductById($id) {
    $conn = getDbConnection();

    $sql = "SELECT id, product_code, product_name, price, quantity FROM products WHERE id = ? LIMIT 1";
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
 * Cập nhật thông tin product
 * @param int $id ID của product
 * @param string $product_code Mã product mới
 * @param string $product_name Tên product mới
 * @param float $price Giá product mới
 * @param int $quantity Số lượng product mới
 * @return bool True nếu thành công, False nếu thất bại
 */

/**
 * Cập nhật thông tin product
 */
function updateProduct($id, $product_code, $product_name, $price, $quantity) {
    $conn = getDbConnection();

    $sql = "UPDATE products SET 
                product_code = ?, 
                product_name = ?, 
                price = ?, 
                quantity = ? 
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssi", 
            $product_code, 
            $product_name, 
            $price, 
            $quantity, 
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
 * Xóa product theo ID
 * @param int $id ID của product cần xóa
 * @return bool True nếu thành công, False nếu thất bại
 */
function deleteProduct($id) {
    $conn = getDbConnection();

    $sql = "DELETE FROM products WHERE id = ?";
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

                
