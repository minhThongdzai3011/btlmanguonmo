<?php
// session_start();
require_once __DIR__ . '/../functions/product.function.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateProduct();
        break;
    case 'edit':
        handleEditProduct();
        break;
    case 'delete':
        handleDeleteProduct();
        break;
}
/**
 * Lấy tất cả danh sách sản phẩm
 */
function handleGetAllProducts() {
    return getAllProducts();
}

function handleGetProductById($id) {
    return getProductById($id);
}

/**
 * Xử lý tạo sản phẩm mới
 */
function handleCreateProduct() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/product.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['product_code']) || !isset($_POST['product_name'])) {
        header("Location: ../views/product/create_product.php?error=Thiếu thông tin cần thiết");
        exit();
    }

    $product_code = trim($_POST['product_code']);
    $product_name = trim($_POST['product_name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);

    
    // Validate dữ liệu
    if (empty($product_code) || empty($product_name) || empty($price) || empty($quantity)) {
        header("Location: ../views/product/create_product.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi hàm thêm sản phẩm
    $result = addProduct($product_code, $product_name, $price, $quantity);
    
    if ($result) {
        header("Location: ../views/product.php?success=Thêm sản phẩm thành công");
    } else {
        header("Location: ../views/product/create_product.php?error=Có lỗi xảy ra khi thêm sản phẩm");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa sản phẩm
 */
function handleEditProduct() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/product.php?error=Phương thức không hợp lệ");
        exit();
    }

    if (!isset($_POST['id']) || !isset($_POST['product_code']) || !isset($_POST['product_name'])) {
        header("Location: ../views/product.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $id = $_POST['id'];
    $product_code = trim($_POST['product_code']);
    $product_name = trim($_POST['product_name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);

    // Validate dữ liệu
    if (empty($product_code) || empty($product_name) || empty($price) || empty($quantity)) {
        header("Location: ../views/product/edit_product.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    // Gọi function để cập nhật sản phẩm
    $result = updateProduct($id, $product_code, $product_name, $price, $quantity);
    
    if ($result) {
        header("Location: ../views/main.php?success=Cập nhật sản phẩm thành công");
    } else {
        header("Location: ../views/product/edit_product.php?id=" . $id . "&error=Cập nhật sản phẩm thất bại");
    }
    exit();
}

/**
 * Xử lý xóa sản phẩm
 */
function handleDeleteProduct() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/product/index.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../views/product/index.php?error=Không tìm thấy ID sản phẩm");
        exit();
    }
    
    $id = $_GET['id'];
    
    // Validate ID là số
    if (!is_numeric($id)) {
        header("Location: ../views/product/index.php?error=ID sản phẩm không hợp lệ");
        exit();
    }

    // Gọi function để xóa sản phẩm
    $result = deleteProduct($id);

    if ($result) {
        header("Location: ../views/product/index.php?success=Xóa sản phẩm thành công");
    } else {
        header("Location: ../views/product/index.php?error=Xóa sản phẩm thất bại");
    }
    exit();
}
?>
