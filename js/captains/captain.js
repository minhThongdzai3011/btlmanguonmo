/**
 * Captain Management JavaScript
 * Handles captain list interactions, filtering, and modal operations
 */

// Global variables
let currentCaptains = [];
let filteredCaptains = [];

/**
 * Initialize captain table functionality
 */
function initializeCaptainTable() {
    console.log('Initializing Captain Management...');
    
    // Bind event listeners
    bindEventListeners();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Load initial data
    loadCaptainData();
    
    console.log('Captain Management initialized successfully');
}

/**
 * Bind all event listeners
 */
function bindEventListeners() {
    // View captain details
    document.addEventListener('click', function(e) {
        if (e.target.closest('.viewBtn')) {
            const captainId = e.target.closest('.viewBtn').dataset.id;
            showCaptainDetails(captainId);
        }
    });
    
    // Edit captain
    document.addEventListener('click', function(e) {
        if (e.target.closest('.editBtn')) {
            const captainId = e.target.closest('.editBtn').dataset.id;
            editCaptain(captainId);
        }
    });
    
    // Delete captain
    document.addEventListener('click', function(e) {
        if (e.target.closest('.deleteBtn')) {
            const captainId = e.target.closest('.deleteBtn').dataset.id;
            deleteCaptain(captainId);
        }
    });
    
    // Export functionality
    const exportBtn = document.getElementById('exportBtn');
    if (exportBtn) {
        exportBtn.addEventListener('click', exportCaptainData);
    }
    
    // Import functionality
    const importBtn = document.getElementById('importBtn');
    if (importBtn) {
        importBtn.addEventListener('click', importCaptainData);
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
 * Load captain data from table rows
 */
function loadCaptainData() {
    // Get data from table rows rendered by PHP
    const rows = document.querySelectorAll('.captain-table tbody tr[data-captain-id]');
    currentCaptains = Array.from(rows).map(row => {
        return {
            id: row.dataset.captainId,
            captain_code: row.querySelector('.captain-code')?.textContent.trim() || '',
            captain_name: row.querySelector('.captain-info .fw-semibold')?.textContent.trim() || '',
            age: parseInt(row.cells[2]?.textContent) || 0,
            gender: row.querySelector('.gender-badge')?.textContent.trim() || ''
        };
    });
    updateCaptainStats();
}

/**
 * Show captain details in modal
 */
function showCaptainDetails(captainId) {
    const captain = findCaptainById(captainId);
    if (!captain) {
        showAlert('Không tìm thấy thông tin cơ trưởng', 'error');
        return;
    }
    
    const modalBody = document.getElementById('captainDetails');
    modalBody.innerHTML = generateCaptainDetailHTML(captain);
    
    const modal = new bootstrap.Modal(document.getElementById('captainModal'));
    modal.show();
    
    // Update edit button link
    const editLink = document.getElementById('editCaptainLink');
    if (editLink) {
        editLink.href = `edit_captain.php?id=${captainId}`;
    }
}

/**
 * Generate captain detail HTML
 */
function generateCaptainDetailHTML(captain) {
    return `
        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <div class="captain-avatar">
                    <i class="bi bi-person-badge"></i>
                </div>
                <h5 class="mt-2 mb-1">${captain.captain_name}</h5>
                <span class="badge bg-success">Đang hoạt động</span>
            </div>
            <div class="col-md-8">
                <div class="captain-detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Mã cơ trưởng</div>
                        <div class="detail-value">${captain.captain_code}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tên cơ trưởng</div>
                        <div class="detail-value">${captain.captain_name}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tuổi</div>
                        <div class="detail-value large">${captain.age} tuổi</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Giới tính</div>
                        <div class="detail-value">
                            <i class="bi bi-gender-${captain.gender === 'Nam' ? 'male' : 'female'} me-1"></i>
                            ${captain.gender}
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Thông tin cơ bản:</strong> Dữ liệu được lấy từ database. Có thể thêm nhiều trường hơn trong bảng captains.
                </div>
            </div>
        </div>
    `;
}

/**
 * Edit captain
 */
function editCaptain(captainId) {
    const captain = findCaptainById(captainId);
    if (!captain) {
        showAlert('Không tìm thấy thông tin cơ trưởng', 'error');
        return;
    }
    
    // In real app: window.location.href = `edit_captain.php?id=${captainId}`;
    window.location.href = `edit_captain.php?id=${captainId}`;
}

/**
 * Delete captain
 */
function deleteCaptain(captainId) {
    const captain = findCaptainById(captainId);
    if (!captain) {
        showAlert('Không tìm thấy thông tin cơ trưởng', 'error');
        return;
    }
    
    if (confirm(`Bạn có chắc muốn xóa cơ trưởng "${captain.captain_name}"?\nHành động này không thể hoàn tác.`)) {
        // In real app, call API to delete
        showAlert(`Đã xóa cơ trưởng ${captain.captain_name}`, 'success');
        
        // Remove from UI
        const row = document.querySelector(`tr[data-captain-id="${captainId}"]`);
        if (row) {
            row.remove();
        }
        
        updateCaptainStats();
    }
}

/**
 * Export captain data
 */
function exportCaptainData() {
    showAlert('Đang xuất dữ liệu cơ trưởng...', 'info');
    
    // In real app, generate and download Excel/CSV file
    setTimeout(() => {
        showAlert('Đã xuất dữ liệu thành công!', 'success');
    }, 1500);
}

/**
 * Import captain data
 */
function importCaptainData() {
    showAlert('Chức năng import dữ liệu', 'info');
    
    // In real app, show file upload modal
}

/**
 * Generate report
 */
function generateReport() {
    showAlert('Đang tạo báo cáo cơ trưởng...', 'info');
    
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
        experience: formData.get('experience') || '',
        gender: formData.get('gender') || '',
        status: formData.get('status') || ''
    };
    
    applyFilters(filters);
}

/**
 * Perform search
 */
function performSearch(query) {
    const filters = {
        search: query.trim(),
        experience: document.getElementById('experienceFilter')?.value || '',
        gender: document.getElementById('genderFilter')?.value || '',
        status: document.getElementById('statusFilter')?.value || ''
    };
    
    applyFilters(filters);
}

/**
 * Apply filters to captain list
 */
function applyFilters(filters) {
    // In real app, this would make an API call
    console.log('Applying filters:', filters);
    
    // Simulate filtering
    showAlert(`Đã áp dụng bộ lọc`, 'info');
}

/**
 * Update captain statistics
 */
function updateCaptainStats() {
    // In real app, calculate from actual data
    const stats = {
        active: currentCaptains.filter(c => c.status === 'active').length,
        total: currentCaptains.length,
        totalFlights: currentCaptains.reduce((sum, c) => sum + (c.total_flights || 0), 0),
        averageAge: Math.round(currentCaptains.reduce((sum, c) => sum + c.age, 0) / currentCaptains.length)
    };
    
    // Update UI (if needed for dynamic updates)
    console.log('Captain stats updated:', stats);
}

/**
 * Utility functions
 */

function findCaptainById(id) {
    return currentCaptains.find(capt => capt.id == id);
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
function highlightRow(captainId, type = 'success') {
    const row = document.querySelector(`tr[data-captain-id="${captainId}"]`);
    if (row) {
        row.classList.add(`table-${type}`);
        setTimeout(() => {
            row.classList.remove(`table-${type}`);
        }, 3000);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeCaptainTable();
});

// Export functions for global access
window.initializeCaptainTable = initializeCaptainTable;
window.showCaptainDetails = showCaptainDetails;
window.editCaptain = editCaptain;
window.deleteCaptain = deleteCaptain;
