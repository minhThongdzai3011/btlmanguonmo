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

foreach ($products as $product) {
    $totalQuantity = $product['quantity_economy'] + $product['quantity_vip'] + $product['quantity_business'];
    $productValue = ($product['price_economy'] * $product['quantity_economy']) + 
                    ($product['price_vip'] * $product['quantity_vip']) + 
                    ($product['price_business'] * $product['quantity_business']);
    
    $totalTickets += $totalQuantity;
    $totalValue += $productValue;
    
    if ($totalQuantity > 30) {
        $availableProducts++;
    } elseif ($totalQuantity > 0) {
        $lowStockProducts++;
    } else {
        $outOfStockProducts++;
    }
}

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
            <div class="stats-value"><?php echo number_format($totalTickets); ?></div>
            <div class="stats-label">Tổng số vé</div>
          </div>
          <div class="stats-icon">
            <i class="bi bi-ticket-perforated"></i>
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
              <i class="bi bi-download"></i> Chỉnh sửa
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
                        <img src="../../img/<?php echo htmlspecialchars($product['image']); ?>"
                             class="card-img-top product-image" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                             loading="lazy">
                      </a>
                      
                      <?php 
                      $totalQuantity = $product['quantity_economy'] + $product['quantity_vip'] + $product['quantity_business'];
                      ?>
                      <div class="status-badge status-<?php echo ($totalQuantity > 0) ? 'available' : 'out_of_stock'; ?>">
                        <?php if ($totalQuantity > 0): ?>
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
                        <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-secondary" title="Chỉnh sửa">
                          <i class="bi bi-pencil"></i>
                        </a>
                        <a href="../../handle/product_process.php?action=delete&id=<?php echo $product['id']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')" 
                           title="Xóa">
                          <i class="bi bi-trash"></i>
                        </a>
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
                      
                      <h6 class="product-name mb-3"><?php echo htmlspecialchars($product['product_name']); ?></h6>
                      
                      <!-- Captain and Steward Info -->
                      <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                          <i class="bi bi-airplane-engines text-primary" style="font-size: 1.1rem;"></i>
                          <div class="flex-grow-1">
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Cơ trưởng</small>
                            <strong style="font-size: 0.85rem;"><?php echo htmlspecialchars($product['captain_name'] ?? 'Chưa có'); ?></strong>
                          </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                          <i class="bi bi-person-badge text-danger" style="font-size: 1.1rem;"></i>
                          <div class="flex-grow-1">
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Tiếp viên</small>
                            <strong style="font-size: 0.85rem;"><?php echo htmlspecialchars($product['steward_name'] ?? 'Chưa có'); ?></strong>
                          </div>
                        </div>
                      </div>
                      
                      <div class="price-section mb-2">
                        <div class="text-muted small mb-1">Giá vé:</div>
                        <div class="d-flex justify-content-between gap-2" style="font-size: 0.8rem;">
                          <div class="text-center flex-fill">
                            <small class="text-muted d-block">Phổ thông</small>
                            <strong class="text-success"><?php echo number_format($product['price_economy'], 0, ',', '.'); ?></strong>
                          </div>
                          <div class="text-center flex-fill">
                            <small class="text-muted d-block">VIP</small>
                            <strong class="text-warning"><?php echo number_format($product['price_vip'], 0, ',', '.'); ?></strong>
                          </div>
                          <div class="text-center flex-fill">
                            <small class="text-muted d-block">Business</small>
                            <strong class="text-primary"><?php echo number_format($product['price_business'], 0, ',', '.'); ?></strong>
                          </div>
                        </div>
                      </div>
                      
                      <div class="quantity-info border-top pt-2 mt-2">
                        <div class="text-muted small mb-1">Số lượng:</div>
                        <div class="d-flex justify-content-between gap-1 mt-1" style="font-size: 0.7rem;">
                          <span class="text-muted">PT: <?php echo $product['quantity_economy']; ?></span>
                          <span class="text-muted">VIP: <?php echo $product['quantity_vip']; ?></span>
                          <span class="text-muted">BS: <?php echo $product['quantity_business']; ?></span>
                        </div>
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
