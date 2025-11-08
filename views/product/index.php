<?php
$page_title = 'Quản lý vé máy bay - AirAgent Admin';
$page_description = 'Hệ thống quản lý sản phẩm vé máy bay';
$current_page = 'product';
$css_files = ['../../css/main.css', '../../css/product.css'];
$js_files = ['../../js/product.js'];

$username = 'Admin';
$role = 'Administrator';

require_once '../../handle/product_process.php';


$products = handleGetAllProducts();

// Tính toán statistics
$totalProducts = count($products);
$availableProducts = 0;
$lowStockProducts = 0;
$outOfStockProducts = 0;
$totalTickets = 0;
$totalValue = 0;

// Page header settings
$show_page_title = true;
$page_subtitle = 'Danh sách và quản lý vé máy bay các tuyến đường';
$page_actions = '
  <a href="create_product.php" class="btn btn-primary">
    <i class="bi bi-plus-lg me-2"></i>Thêm sản phẩm
  </a>
';

// Include header
include '../../includes/header.php';
?>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-3">
    <div class="card stats-card stats-available h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo $availableProducts; ?></div>
            <div class="stats-label">Sản phẩm có sẵn</div>
          </div>
          <div class="stats-icon">
            <i class="bi bi-check-circle-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card stats-card stats-total h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo $totalProducts; ?></div>
            <div class="stats-label">Tổng sản phẩm</div>
          </div>
          <div class="stats-icon">
            <i class="bi bi-box-seam"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card stats-card stats-warning h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo $outOfStockProducts; ?></div>
            <div class="stats-label">Hết hàng</div>
          </div>
          <div class="stats-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card stats-card stats-revenue h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="stats-value"><?php echo number_format($totalValue, 0, ',', '.'); ?> VNĐ</div>
            <div class="stats-label">Tổng giá trị</div>
          </div>
          <div class="stats-icon">
            <i class="bi bi-currency-dollar"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="row g-4">
  <!-- Left Column: Products List -->
  <div class="col-lg-9">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">
            <i class="bi bi-airplane-engines me-2"></i>Danh sách vé máy bay
          </h5>
          <div class="d-flex gap-2">
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-outline-secondary btn-sm active" id="gridViewBtn">
                <i class="bi bi-grid-3x3-gap"></i>
              </button>
              <button type="button" class="btn btn-outline-secondary btn-sm" id="listViewBtn">
                <i class="bi bi-list"></i>
              </button>
            </div>
            <button class="btn btn-outline-secondary btn-sm" id="exportBtn">
              <i class="bi bi-download"></i> Export
            </button>
            <a href="create_product.php" class="btn btn-primary btn-sm">
              <i class="bi bi-plus-lg"></i> Thêm mới
            </a>
          </div>
        </div>

        <!-- Filters -->
        <form id="filterForm" class="row g-2 align-items-end mb-4" method="GET">
          <div class="col-md-3">
            <label class="form-label small">Tìm kiếm</label>
            <input class="form-control form-control-sm" type="search" 
                   name="q" id="q" 
                   value=""
                   placeholder="Tên, mã, tuyến bay..." />
          </div>
          <div class="col-md-2">
            <label class="form-label small">Hãng bay</label>
            <select name="airline" id="airlineFilter" class="form-select form-select-sm">
              <option value="">Tất cả</option>
              <option value="Vietnam Airlines">Vietnam Airlines</option>
              <option value="VietJet Air">VietJet Air</option>
              <option value="Bamboo Airways">Bamboo Airways</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label small">Mức giá</label>
            <select name="price_range" id="priceFilter" class="form-select form-select-sm">
              <option value="">Tất cả</option>
              <option value="under_2m">Dưới 2M</option>
              <option value="2m_3m">2M - 3M</option>
              <option value="3m_5m">3M - 5M</option>
              <option value="over_5m">Trên 5M</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label small">Trạng thái</label>
            <select name="status" id="statusFilter" class="form-select form-select-sm">
              <option value="">Tất cả</option>
              <option value="available">Có sẵn</option>
              <option value="low_stock">Sắp hết</option>
              <option value="out_of_stock">Hết vé</option>
            </select>
          </div>
          <div class="col-md-2">
            <button class="btn btn-sm btn-outline-primary w-100" type="submit">
              <i class="bi bi-search"></i> Tìm
            </button>
          </div>
          <div class="col-md-1">
            <?php if (!empty($searchQuery) || !empty($airlineFilter) || !empty($priceFilter) || !empty($statusFilter)): ?>
            <a href="index.php" class="btn btn-sm btn-outline-secondary w-100" title="Xóa bộ lọc">
              <i class="bi bi-x-circle"></i>
            </a>
            <?php endif; ?>
          </div>
        </form>

        <!-- Products Grid -->
        <div id="productsContainer">
          <?php if (empty($products)): ?>
            <div class="text-center py-5">
              <i class="bi bi-airplane text-muted" style="font-size: 4rem;"></i>
              <h4 class="text-muted mt-3">Không tìm thấy sản phẩm nào</h4>
              <p class="text-muted">Thử thay đổi bộ lọc hoặc thêm sản phẩm mới</p>
            </div>
          <?php else: ?>
            <div class="row g-3" id="productsGrid">
              <?php foreach ($products as $product): ?>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                  <div class="card product-card h-100" data-product-id="<?php echo $product['id']; ?>">
                    <!-- Product Image -->
                    <div class="product-image-container">
                      <a href="#" class="product-image-link" data-product-id="<?php echo $product['id']; ?>">
                        <img src="data:image/jpeg;base64,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" 
                             class="card-img-top product-image" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                             loading="lazy">
                      </a>
                      
                      <!-- Status Badge -->
                      <div class="status-badge status-<?php echo ($product['quantity'] > 0) ? 'available' : 'out_of_stock'; ?>">
                        <?php if ($product['quantity'] > 0): ?>
                          <i class="bi bi-check-circle-fill"></i>
                        <?php else: ?>
                          <i class="bi bi-x-circle-fill"></i>
                        <?php endif; ?>
                      </div>
                      
                      <!-- Quick Actions -->
                      <div class="product-actions">
                        <button class="btn btn-sm btn-primary viewBtn" data-id="<?php echo $product['id']; ?>" title="Xem chi tiết">
                          <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-secondary editBtn" data-id="<?php echo $product['id']; ?>" title="Chỉnh sửa">
                          <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="<?php echo $product['id']; ?>" title="Xóa">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </div>

                    <!-- Product Info -->
                    <div class="card-body p-3">
                      <div class="product-header mb-2">
                        <div class="product-code"><?php echo htmlspecialchars($product['product_code']); ?></div>
                        <div class="airline-logo">
                          <i class="bi bi-airplane"></i>
                        </div>
                      </div>
                      
                      <h6 class="product-name mb-2"><?php echo htmlspecialchars($product['product_name']); ?></h6>
                      
                      <div class="price-section mb-2">
                        <div class="price-current"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</div>
                      </div>
                      
                      <div class="quantity-info mb-3">
                        <i class="bi bi-ticket-perforated me-1"></i>
                        <span class="quantity-text">Còn lại: <strong><?php echo $product['quantity']; ?></strong> vé</span>
                      </div>
                      
                      <div class="product-actions">
                        <button class="btn btn-outline-primary btn-sm me-2" 
                                onclick="viewProduct(<?php echo $product['id']; ?>)" 
                                title="Xem chi tiết">
                          <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm me-2" 
                                onclick="editProduct(<?php echo $product['id']; ?>)" 
                                title="Chỉnh sửa">
                          <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm" 
                                onclick="deleteProduct(<?php echo $product['id']; ?>)" 
                                title="Xóa">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
        
        <!-- JavaScript Functions -->
        <script>
        function viewProduct(id) {
          window.location.href = '../product/view.php?id=' + id;
        }
        
        function editProduct(id) {
          window.location.href = '../product/edit.php?id=' + id;
        }
        
        function deleteProduct(id) {
          if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            window.location.href = '../../handle/product_process.php?action=delete&id=' + id;
          }
        }
        
        // Filter functions
        function filterProducts() {
          const searchInput = document.getElementById('searchInput');
          const statusFilter = document.getElementById('statusFilter');
          
          let url = 'index.php?';
          let params = [];
          
          if (searchInput.value.trim()) {
            params.push('search=' + encodeURIComponent(searchInput.value.trim()));
          }
          
          if (statusFilter.value) {
            params.push('status=' + encodeURIComponent(statusFilter.value));
          }
          
          if (params.length > 0) {
            url += params.join('&');
          }
          
          window.location.href = url;
        }
        </script>
        </div>

        <!-- Pagination -->
        <?php if (!empty($products)): ?>
        <div class="d-flex justify-content-between align-items-center mt-4">
          <div class="text-muted small">
            Hiển thị <?php echo count($products); ?> sản phẩm
          </div>
          <nav>
            <ul class="pagination pagination-sm mb-0">
              <li class="page-item disabled"><a class="page-link">Trước</a></li>
              <li class="page-item active"><a class="page-link">1</a></li>
              <li class="page-item"><a class="page-link">2</a></li>
              <li class="page-item"><a class="page-link">3</a></li>
              <li class="page-item"><a class="page-link">Sau</a></li>
            </ul>
          </nav>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="col-lg-3">
    <div class="card">
      <div class="card-header">
        <h6 class="card-title mb-0">
          <i class="bi bi-graph-up me-2"></i>Thống kê nhanh
        </h6>
      </div>
      <div class="card-body">
        <div class="quick-stats">
          <div class="stat-item stat-success">
            <div class="stat-icon">
              <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="stat-content">
              <div class="stat-number"><?php echo $availableProducts; ?></div>
              <div class="stat-label">Có sẵn</div>
            </div>
          </div>
          
          <div class="stat-item stat-warning">
            <div class="stat-icon">
              <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="stat-content">
              <div class="stat-number"><?php echo $lowStockProducts; ?></div>
              <div class="stat-label">Sắp hết</div>
            </div>
          </div>
          
          <div class="stat-item stat-danger">
            <div class="stat-icon">
              <i class="bi bi-x-circle-fill"></i>
            </div>
            <div class="stat-content">
              <div class="stat-number"><?php echo $outOfStockProducts; ?></div>
              <div class="stat-label">Hết vé</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">
        <h6 class="card-title mb-0">
          <i class="bi bi-tools me-2"></i>Thao tác nhanh
        </h6>
      </div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <a href="create_product.php" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-2"></i>Thêm sản phẩm
          </a>
          <button class="btn btn-outline-secondary btn-sm" id="bulkUpdateBtn">
            <i class="bi bi-arrow-clockwise me-2"></i>Cập nhật giá
          </button>
          <button class="btn btn-outline-info btn-sm" id="inventoryBtn">
            <i class="bi bi-box-seam me-2"></i>Quản lý tồn kho
          </button>
          <button class="btn btn-outline-warning btn-sm" id="reportBtn">
            <i class="bi bi-file-earmark-text me-2"></i>Báo cáo
          </button>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">
        <h6 class="card-title mb-0">
          <i class="bi bi-info-circle me-2"></i>Thông tin
        </h6>
      </div>
      <div class="card-body">
        <div class="info-list">
          <div class="info-item">
            <small class="text-muted">Tổng giá trị kho:</small>
            <div class="fw-bold text-primary"><?php echo number_format($totalValue, 0, ',', '.'); ?> VNĐ</div>
          </div>
          <div class="info-item">
            <small class="text-muted">Vé bán được hôm nay:</small>
            <div class="fw-bold text-success">156 vé</div>
          </div>
          <div class="info-item">
            <small class="text-muted">Doanh thu hôm nay:</small>
            <div class="fw-bold text-warning">287,500,000 VNĐ</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-airplane me-2"></i>Chi tiết sản phẩm
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="productDetails">
        <!-- Content will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="editProductBtn">Chỉnh sửa</button>
      </div>
    </div>
  </div>
</div>

<?php


// Include footer
include '../../includes/footer.php';
?>
