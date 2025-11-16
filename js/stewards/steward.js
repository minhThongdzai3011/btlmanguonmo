/**
 * Steward Management JavaScript
 * Handles steward list interactions, filtering, and modal operations
 */

// Global variables
let currentStewards = [];
let filteredStewards = [];

/**
 * Initialize steward table functionality
 */
function initializeStewardTable() {
    console.log('Initializing Steward Management...');
    
    // Bind event listeners
    bindEventListeners();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Load initial data
    loadStewardData();
    
    console.log('Steward Management initialized successfully');
}

/**
 * Bind all event listeners
 */
function bindEventListeners() {
    // View steward details
    document.addEventListener('click', function(e) {
        if (e.target.closest('.viewBtn')) {
            const stewardId = e.target.closest('.viewBtn').dataset.id;
            showStewardDetails(stewardId);
        }
    });
    
    // Edit steward
    document.addEventListener('click', function(e) {
        if (e.target.closest('.editBtn')) {
            const stewardId = e.target.closest('.editBtn').dataset.id;
            editSteward(stewardId);
        }
    });
    
    // Delete steward
    document.addEventListener('click', function(e) {
        if (e.target.closest('.deleteBtn')) {
            const stewardId = e.target.closest('.deleteBtn').dataset.id;
            deleteSteward(stewardId);
        }
    });
    
    // Export functionality
    const exportBtn = document.getElementById('exportBtn');
    if (exportBtn) {
        exportBtn.addEventListener('click', exportStewardData);
    }
    
    // Import functionality
    const importBtn = document.getElementById('importBtn');
    if (importBtn) {
        importBtn.addEventListener('click', importStewardData);
    }
    
    // Report functionality
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
 * Load steward data from table rows
 */
function loadStewardData() {
    // Get data from table rows rendered by PHP
    const rows = document.querySelectorAll('.steward-table tbody tr[data-steward-id]');
    currentStewards = Array.from(rows).map(row => {
        return {
            id: row.dataset.stewardId,
            steward_code: row.querySelector('.steward-code')?.textContent.trim() || '',
            steward_name: row.querySelector('.steward-info .fw-semibold')?.textContent.trim() || '',
            age: parseInt(row.cells[2]?.textContent) || 0,
            gender: row.querySelector('.gender-badge')?.textContent.trim() || ''
        };
    });
    updateStewardStats();
}

/**
 * Show steward details in modal
 */
function showStewardDetails(stewardId) {
    const steward = findStewardById(stewardId);
    if (!steward) {
        showAlert('Không tìm thấy thông tin tiếp viên', 'error');
        return;
    }
    
    const modalBody = document.getElementById('stewardDetails');
    modalBody.innerHTML = generateStewardDetailHTML(steward);
    
    const modal = new bootstrap.Modal(document.getElementById('stewardModal'));
    modal.show();
    
    // Update edit button link
    const editLink = document.getElementById('editStewardLink');
    if (editLink) {
        editLink.href = `edit_steward.php?id=${stewardId}`;
    }
}

/**
 * Generate steward detail HTML
 */
function generateStewardDetailHTML(steward) {
    return `
        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <div class="steward-avatar">
                    <i class="bi bi-person-badge"></i>
                </div>
                <h5 class="mt-2 mb-1">${steward.steward_name}</h5>
                <span class="badge bg-success">Đang hoạt động</span>
            </div>
            <div class="col-md-8">
                <div class="steward-detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Mã tiếp viên</div>
                        <div class="detail-value">${steward.steward_code}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tên tiếp viên</div>
                        <div class="detail-value">${steward.steward_name}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tuổi</div>
                        <div class="detail-value large">${steward.age} tuổi</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Giới tính</div>
                        <div class="detail-value">
                            <i class="bi bi-gender-${steward.gender === 'Nam' ? 'male' : 'female'} me-1"></i>
                            ${steward.gender}
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Thông tin cơ bản:</strong> Dữ liệu được lấy từ database. Có thể thêm nhiều trường hơn trong bảng stewards.
                </div>
            </div>
        </div>
    `;
}

/**
 * Edit steward
 */
function editSteward(stewardId) {
    const steward = findStewardById(stewardId);
    if (!steward) {
        showAlert('Không tìm thấy thông tin tiếp viên', 'error');
        return;
    }
    
    window.location.href = `edit_steward.php?id=${stewardId}`;
}

/**
 * Delete steward
 */
function deleteSteward(stewardId) {
    const steward = findStewardById(stewardId);
    if (!steward) {
        showAlert('Không tìm thấy thông tin tiếp viên', 'error');
        return;
    }
    
    if (confirm(`Bạn có chắc muốn xóa tiếp viên "${steward.steward_name}"?\nHành động này không thể hoàn tác.`)) {
        // In real app, call API to delete
        showAlert(`Đã xóa tiếp viên ${steward.steward_name}`, 'success');
        
        // Remove from UI
        const row = document.querySelector(`tr[data-steward-id="${stewardId}"]`);
        if (row) {
            row.remove();
        }
        
        updateStewardStats();
    }
}

/**
 * Export steward data
 */
function exportStewardData() {
    showAlert('Đang xuất dữ liệu tiếp viên...', 'info');
    
    // In real app, generate and download Excel/CSV file
    setTimeout(() => {
        showAlert('Đã xuất dữ liệu thành công!', 'success');
    }, 1500);
}

/**
 * Import steward data
 */
function importStewardData() {
    showAlert('Chức năng import dữ liệu', 'info');
    
    // In real app, show file upload modal
}

/**
 * Generate report
 */
function generateReport() {
    showAlert('Đang tạo báo cáo tiếp viên...', 'info');
    
    // In real app, generate PDF report
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
        gender: formData.get('gender') || '',
        age_range: formData.get('age_range') || ''
    };
    
    applyFilters(filters);
}

/**
 * Perform search
 */
function performSearch(query) {
    const filters = {
        search: query.trim(),
        gender: document.getElementById('genderFilter')?.value || '',
        age_range: document.getElementById('ageFilter')?.value || ''
    };
    
    applyFilters(filters);
}

/**
 * Apply filters to steward list
 */
function applyFilters(filters) {
    // In real app, this would make an API call
    console.log('Applying filters:', filters);
    
    // Simulate filtering
    showAlert(`Đã áp dụng bộ lọc`, 'info');
}

/**
 * Update steward statistics
 */
function updateStewardStats() {
    // In real app, calculate from actual data
    const stats = {
        active: currentStewards.filter(s => s.status === 'active').length,
        total: currentStewards.length,
        averageAge: Math.round(currentStewards.reduce((sum, s) => sum + s.age, 0) / currentStewards.length)
    };
    
    // Update UI (if needed for dynamic updates)
    console.log('Steward stats updated:', stats);
}

/**
 * Utility functions
 */

function findStewardById(id) {
    return currentStewards.find(stew => stew.id == id);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('vi-VN', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
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
    element.innerHTML = '<i class="bi bi-hourglass-split spinner-border-sm me-2"></i>Đang xử lý...';
    
    return () => {
        element.classList.remove('loading');
        element.innerHTML = originalText;
    };
}

/**
 * Highlight table row
 */
function highlightRow(stewardId, type = 'success') {
    const row = document.querySelector(`tr[data-steward-id="${stewardId}"]`);
    if (row) {
        row.classList.add(`table-${type}`);
        setTimeout(() => {
            row.classList.remove(`table-${type}`);
        }, 3000);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeStewardTable();
});

// Export functions for global access
window.initializeStewardTable = initializeStewardTable;
window.showStewardDetails = showStewardDetails;
window.editSteward = editSteward;
window.deleteSteward = deleteSteward;
