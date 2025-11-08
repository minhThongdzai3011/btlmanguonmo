/**
 * Product Management JavaScript
 * Handles flight ticket product interactions, filtering, and modal operations
 */

// Global variables
let currentProducts = [];
let filteredProducts = [];
let viewMode = 'grid'; // 'grid' or 'list'

// Product data (in real app, this would come from API)
const productData = [
    {
        id: 1,
        product_code: 'VN001',
        product_name: 'Hà Nội - TP.HCM (Economy)',
        image: 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=400',
        price: 2500000,
        ticket_quantity: 150,
        departure: 'Hà Nội (HAN)',
        arrival: 'TP.HCM (SGN)',
        airline: 'Vietnam Airlines',
        flight_time: '2h 15m',
        aircraft: 'Boeing 737-800',
        status: 'available',
        discount: 0,
        departure_time: '08:30',
        arrival_time: '10:45',
        flight_number: 'VN213',
        class: 'Economy'
    },
    {
        id: 2,
        product_code: 'VJ002',
        product_name: 'TP.HCM - Đà Nẵng (Economy)',
        image: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=400',
        price: 1800000,
        ticket_quantity: 89,
        departure: 'TP.HCM (SGN)',
        arrival: 'Đà Nẵng (DAD)',
        airline: 'VietJet Air',
        flight_time: '1h 30m',
        aircraft: 'Airbus A320',
        status: 'available',
        discount: 15,
        departure_time: '14:20',
        arrival_time: '15:50',
        flight_number: 'VJ367',
        class: 'Economy'
    }
];

/**
 * Initialize product management functionality
 */
function initializeProductManagement() {
    console.log('Initializing Product Management...');
    
    // Bind event listeners
    bindEventListeners();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Load initial data
    loadProductData();
    
    // Initialize view mode
    initializeViewMode();
    
    console.log('Product Management initialized successfully');
}

/**
 * Bind all event listeners
 */
function bindEventListeners() {
    // View toggle buttons
    const gridViewBtn = document.getElementById('gridViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    
    if (gridViewBtn) {
        gridViewBtn.addEventListener('click', () => switchViewMode('grid'));
    }
    
    if (listViewBtn) {
        listViewBtn.addEventListener('click', () => switchViewMode('list'));
    }
    
    // Product actions
    document.addEventListener('click', function(e) {
        if (e.target.closest('.viewBtn')) {
            const productId = e.target.closest('.viewBtn').dataset.id;
            showProductDetails(productId);
        }
        
        if (e.target.closest('.editBtn')) {
            const productId = e.target.closest('.editBtn').dataset.id;
            editProduct(productId);
        }
        
        if (e.target.closest('.deleteBtn')) {
            const productId = e.target.closest('.deleteBtn').dataset.id;
            deleteProduct(productId);
        }
        
        if (e.target.closest('.product-image-link')) {
            e.preventDefault();
            const productId = e.target.closest('.product-image-link').dataset.productId;
            showProductDetails(productId);
        }
        
        if (e.target.closest('.product-name')) {
            const productCard = e.target.closest('.product-card');
            const productId = productCard.dataset.productId;
            showProductDetails(productId);
        }
    });
    
    // Sidebar action buttons
    const exportBtn = document.getElementById('exportBtn');
    if (exportBtn) {
        exportBtn.addEventListener('click', exportProductData);
    }
    
    const bulkUpdateBtn = document.getElementById('bulkUpdateBtn');
    if (bulkUpdateBtn) {
        bulkUpdateBtn.addEventListener('click', bulkUpdatePrices);
    }
    
    const inventoryBtn = document.getElementById('inventoryBtn');
    if (inventoryBtn) {
        inventoryBtn.addEventListener('click', manageInventory);
    }
    
    const reportBtn = document.getElementById('reportBtn');
    if (reportBtn) {
        reportBtn.addEventListener('click', generateReport);
    }
    
    // Filter form
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', handleFilter);
    }
    
    // Search input with debounce
    const searchInput = document.getElementById('q');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 300);
        });
    }
    
    // Filter selects
    const filterSelects = ['airlineFilter', 'priceFilter', 'statusFilter'];
    filterSelects.forEach(selectId => {
        const select = document.getElementById(selectId);
        if (select) {
            select.addEventListener('change', handleFilterChange);
        }
    });
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

/**
 * Load product data
 */
function loadProductData() {
    currentProducts = productData;
    updateProductStats();
}

/**
 * Initialize view mode
 */
function initializeViewMode() {
    const savedMode = localStorage.getItem('productViewMode') || 'grid';
    switchViewMode(savedMode);
}

/**
 * Switch view mode between grid and list
 */
function switchViewMode(mode) {
    viewMode = mode;
    localStorage.setItem('productViewMode', mode);
    
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    const productsGrid = document.getElementById('productsGrid');
    
    if (gridBtn && listBtn && productsGrid) {
        // Update button states
        gridBtn.classList.toggle('active', mode === 'grid');
        listBtn.classList.toggle('active', mode === 'list');
        
        // Update grid classes
        if (mode === 'grid') {
            productsGrid.className = 'row g-3';
            productsGrid.querySelectorAll('.col-sm-6').forEach(col => {
                col.className = 'col-sm-6 col-lg-4 col-xl-3';
            });
        } else {
            productsGrid.className = 'row g-2';
            productsGrid.querySelectorAll('[class*="col-"]').forEach(col => {
                col.className = 'col-12';
            });
        }
    }
    
    showAlert(`Đã chuyển sang chế độ xem ${mode === 'grid' ? 'lưới' : 'danh sách'}`, 'success');
}

/**
 * Show product details in modal
 */
function showProductDetails(productId) {
    const product = findProductById(productId);
    if (!product) {
        showAlert('Không tìm thấy thông tin sản phẩm', 'error');
        return;
    }
    
    const modalBody = document.getElementById('productDetails');
    modalBody.innerHTML = generateProductDetailHTML(product);
    
    const modal = new bootstrap.Modal(document.getElementById('productModal'));
    modal.show();
    
    // Update edit button
    const editBtn = document.getElementById('editProductBtn');
    editBtn.onclick = () => {
        modal.hide();
        editProduct(productId);
    };
}

/**
 * Generate product detail HTML
 */
function generateProductDetailHTML(product) {
    const discountedPrice = product.discount > 0 ? 
        product.price * (100 - product.discount) / 100 : product.price;
    
    return `
        <div class="row">
            <div class="col-md-5 text-center mb-3">
                <div class="product-image-large mb-3">
                    <img src="${product.image}" 
                         class="img-fluid rounded-3" 
                         alt="${product.product_name}"
                         style="max-height: 300px; width: 100%; object-fit: cover;">
                </div>
                <div class="d-flex justify-content-center gap-2">
                    ${product.discount > 0 ? `<span class="badge bg-danger">-${product.discount}%</span>` : ''}
                    <span class="badge bg-${getStatusColor(product.status)}">${getStatusText(product.status)}</span>
                </div>
            </div>
            <div class="col-md-7">
                <div class="product-detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Mã sản phẩm</div>
                        <div class="detail-value">${product.product_code}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tên sản phẩm</div>
                        <div class="detail-value large">${product.product_name}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Hãng hàng không</div>
                        <div class="detail-value">${product.airline}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Số hiệu chuyến bay</div>
                        <div class="detail-value">${product.flight_number || 'N/A'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Máy bay</div>
                        <div class="detail-value">${product.aircraft}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Hạng vé</div>
                        <div class="detail-value">${product.class || 'Economy'}</div>
                    </div>
                </div>
                
                <hr class="my-3">
                
                <div class="product-detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Điểm khởi hành</div>
                        <div class="detail-value">${product.departure}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Điểm đến</div>
                        <div class="detail-value">${product.arrival}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Thời gian bay</div>
                        <div class="detail-value">${product.flight_time}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Giờ khởi hành</div>
                        <div class="detail-value">${product.departure_time || 'N/A'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Giờ đến</div>
                        <div class="detail-value">${product.arrival_time || 'N/A'}</div>
                    </div>
                </div>
                
                <hr class="my-3">
                
                <div class="product-detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Giá gốc</div>
                        <div class="detail-value currency">${formatCurrency(product.price)}</div>
                    </div>
                    ${product.discount > 0 ? `
                    <div class="detail-item">
                        <div class="detail-label">Giá sau giảm</div>
                        <div class="detail-value large currency">${formatCurrency(discountedPrice)}</div>
                    </div>
                    ` : ''}
                    <div class="detail-item">
                        <div class="detail-label">Số vé có sẵn</div>
                        <div class="detail-value large">${product.ticket_quantity} vé</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tổng giá trị</div>
                        <div class="detail-value currency">${formatCurrency(discountedPrice * product.ticket_quantity)}</div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

/**
 * Edit product
 */
function editProduct(productId) {
    const product = findProductById(productId);
    if (!product) {
        showAlert('Không tìm thấy thông tin sản phẩm', 'error');
        return;
    }
    
    showAlert(`Chỉnh sửa sản phẩm ${product.product_name} (Demo)`, 'info');
    
    // In real app: window.location.href = `edit_product.php?id=${productId}`;
}

/**
 * Delete product
 */
function deleteProduct(productId) {
    const product = findProductById(productId);
    if (!product) {
        showAlert('Không tìm thấy thông tin sản phẩm', 'error');
        return;
    }
    
    if (confirm(`Bạn có chắc muốn xóa sản phẩm "${product.product_name}"?\nHành động này không thể hoàn tác.`)) {
        // In real app, call API to delete
        showAlert(`Đã xóa sản phẩm ${product.product_name} (Demo)`, 'success');
        
        // Remove from UI
        const card = document.querySelector(`[data-product-id="${productId}"]`);
        if (card) {
            card.closest('.col-sm-6, .col-12').remove();
        }
        
        updateProductStats();
    }
}

/**
 * Export product data
 */
function exportProductData() {
    showAlert('Đang xuất dữ liệu sản phẩm... (Demo)', 'info');
    
    // In real app, generate and download Excel/CSV file
    setTimeout(() => {
        showAlert('Đã xuất dữ liệu thành công!', 'success');
    }, 1500);
}

/**
 * Bulk update prices
 */
function bulkUpdatePrices() {
    showAlert('Chức năng cập nhật giá hàng loạt (Demo)', 'info');
    
    // In real app, show bulk update modal
}

/**
 * Manage inventory
 */
function manageInventory() {
    showAlert('Chức năng quản lý tồn kho (Demo)', 'info');
    
    // In real app, redirect to inventory page
}

/**
 * Generate report
 */
function generateReport() {
    showAlert('Đang tạo báo cáo sản phẩm... (Demo)', 'info');
    
    // In real app, generate PDF/Excel report
    setTimeout(() => {
        showAlert('Đã tạo báo cáo thành công!', 'success');
    }, 2000);
}

/**
 * Handle filter form submission
 */
function handleFilter(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const filters = {
        search: formData.get('q') || '',
        airline: formData.get('airline') || '',
        price_range: formData.get('price_range') || '',
        status: formData.get('status') || ''
    };
    
    applyFilters(filters);
}

/**
 * Handle filter change
 */
function handleFilterChange() {
    const filters = {
        search: document.getElementById('q')?.value || '',
        airline: document.getElementById('airlineFilter')?.value || '',
        price_range: document.getElementById('priceFilter')?.value || '',
        status: document.getElementById('statusFilter')?.value || ''
    };
    
    applyFilters(filters);
}

/**
 * Perform search
 */
function performSearch(query) {
    const filters = {
        search: query.trim(),
        airline: document.getElementById('airlineFilter')?.value || '',
        price_range: document.getElementById('priceFilter')?.value || '',
        status: document.getElementById('statusFilter')?.value || ''
    };
    
    applyFilters(filters);
}

/**
 * Apply filters to product list
 */
function applyFilters(filters) {
    // In real app, this would make an API call
    console.log('Applying filters:', filters);
    
    // Simulate filtering
    const filterTexts = [];
    if (filters.search) filterTexts.push(`Tìm: "${filters.search}"`);
    if (filters.airline) filterTexts.push(`Hãng: ${filters.airline}`);
    if (filters.price_range) filterTexts.push(`Giá: ${filters.price_range}`);
    if (filters.status) filterTexts.push(`Trạng thái: ${filters.status}`);
    
    if (filterTexts.length > 0) {
        showAlert(`Đã áp dụng bộ lọc: ${filterTexts.join(', ')}`, 'info');
    }
    
    // Add fade effect to products
    const products = document.querySelectorAll('.product-card');
    products.forEach(product => {
        product.classList.add('filter-fade');
        setTimeout(() => {
            product.classList.remove('filter-fade');
        }, 300);
    });
}

/**
 * Update product statistics
 */
function updateProductStats() {
    // In real app, calculate from actual data
    const stats = {
        available: currentProducts.filter(p => p.status === 'available').length,
        lowStock: currentProducts.filter(p => p.status === 'low_stock').length,
        outOfStock: currentProducts.filter(p => p.status === 'out_of_stock').length,
        totalTickets: currentProducts.reduce((sum, p) => sum + p.ticket_quantity, 0),
        totalValue: currentProducts.reduce((sum, p) => sum + (p.price * p.ticket_quantity), 0)
    };
    
    // Update UI (if needed for dynamic updates)
    console.log('Product stats updated:', stats);
}

/**
 * Utility functions
 */

function findProductById(id) {
    return currentProducts.find(product => product.id == id);
}

function getStatusColor(status) {
    switch (status) {
        case 'available': return 'success';
        case 'low_stock': return 'warning';
        case 'out_of_stock': return 'danger';
        default: return 'secondary';
    }
}

function getStatusText(status) {
    switch (status) {
        case 'available': return 'Có sẵn';
        case 'low_stock': return 'Sắp hết';
        case 'out_of_stock': return 'Hết vé';
        default: return 'Không xác định';
    }
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

function showAlert(message, type = 'info') {
    const alertClass = {
        'success': 'alert-success',
        'error': 'alert-danger',
        'warning': 'alert-warning',
        'info': 'alert-info'
    }[type] || 'alert-info';
    
    const icon = {
        'success': 'bi-check-circle-fill',
        'error': 'bi-exclamation-triangle-fill',
        'warning': 'bi-exclamation-triangle-fill',
        'info': 'bi-info-circle-fill'
    }[type] || 'bi-info-circle-fill';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="bi ${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    // Insert at top of page
    const container = document.querySelector('.container-xxl');
    if (container) {
        container.insertAdjacentHTML('afterbegin', alertHtml);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }
}

/**
 * Add loading state to element
 */
function addLoadingState(element) {
    element.classList.add('loading');
    const originalText = element.innerHTML;
    element.innerHTML = '<i class="bi bi-spinner-border spinner-border-sm me-2"></i>Đang xử lý...';
    
    return () => {
        element.classList.remove('loading');
        element.innerHTML = originalText;
    };
}

/**
 * Highlight product card
 */
function highlightProduct(productId, type = 'success') {
    const card = document.querySelector(`[data-product-id="${productId}"]`);
    if (card) {
        card.classList.add(`${type}-highlight`);
        setTimeout(() => {
            card.classList.remove(`${type}-highlight`);
        }, 3000);
    }
}

/**
 * Animate new product addition
 */
function animateNewProduct(productId) {
    const card = document.querySelector(`[data-product-id="${productId}"]`);
    if (card) {
        card.classList.add('new-item');
        setTimeout(() => {
            card.classList.remove('new-item');
        }, 5000);
    }
}

// Export functions for global access
window.initializeProductManagement = initializeProductManagement;
window.showProductDetails = showProductDetails;
window.editProduct = editProduct;
window.deleteProduct = deleteProduct;
window.switchViewMode = switchViewMode;