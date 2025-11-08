/**
 * Employee Management JavaScript
 * Handles employee list interactions, filtering, and modal operations
 */

// Global variables
let currentEmployees = [];
let filteredEmployees = [];

// Employee data (in real app, this would come from API)
const employeeData = [
    {
        id: 1,
        employee_code: 'NV001',
        employee_name: 'Nguyễn Văn An',
        agent_code: 'AG001',
        agent_name: 'Đại lý Hà Nội',
        position: 'Nhân viên bán hàng',
        age: 28,
        gender: 'Nam',
        salary: 15000000,
        phone: '0987654321',
        email: 'nva@airagent.com',
        hire_date: '2023-01-15',
        status: 'active',
        address: '123 Phố Huế, Hai Bà Trưng, Hà Nội',
        department: 'Kinh doanh',
        manager: 'Trần Thị Bình'
    },
    {
        id: 2,
        employee_code: 'NV002',
        employee_name: 'Trần Thị Bình',
        agent_code: 'AG001',
        agent_name: 'Đại lý Hà Nội',
        position: 'Quản lý',
        age: 32,
        gender: 'Nữ',
        salary: 25000000,
        phone: '0912345678',
        email: 'ttb@airagent.com',
        hire_date: '2022-03-10',
        status: 'active',
        address: '456 Láng Hạ, Đống Đa, Hà Nội',
        department: 'Quản lý',
        manager: 'Tự quản lý'
    }
];

/**
 * Initialize employee table functionality
 */
function initializeEmployeeTable() {
    console.log('Initializing Employee Management...');
    
    // Bind event listeners
    bindEventListeners();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Load initial data
    loadEmployeeData();
    
    console.log('Employee Management initialized successfully');
}

/**
 * Bind all event listeners
 */
function bindEventListeners() {
    // View employee details
    document.addEventListener('click', function(e) {
        if (e.target.closest('.viewBtn')) {
            const employeeId = e.target.closest('.viewBtn').dataset.id;
            showEmployeeDetails(employeeId);
        }
    });
    
    // Edit employee
    document.addEventListener('click', function(e) {
        if (e.target.closest('.editBtn')) {
            const employeeId = e.target.closest('.editBtn').dataset.id;
            editEmployee(employeeId);
        }
    });
    
    // Delete employee
    document.addEventListener('click', function(e) {
        if (e.target.closest('.deleteBtn')) {
            const employeeId = e.target.closest('.deleteBtn').dataset.id;
            deleteEmployee(employeeId);
        }
    });
    
    // Export functionality
    const exportBtn = document.getElementById('exportBtn');
    if (exportBtn) {
        exportBtn.addEventListener('click', exportEmployeeData);
    }
    
    // Import functionality
    const importBtn = document.getElementById('importBtn');
    if (importBtn) {
        importBtn.addEventListener('click', importEmployeeData);
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
 * Load employee data
 */
function loadEmployeeData() {
    currentEmployees = employeeData;
    updateEmployeeStats();
}

/**
 * Show employee details in modal
 */
function showEmployeeDetails(employeeId) {
    const employee = findEmployeeById(employeeId);
    if (!employee) {
        showAlert('Không tìm thấy thông tin nhân viên', 'error');
        return;
    }
    
    const modalBody = document.getElementById('employeeDetails');
    modalBody.innerHTML = generateEmployeeDetailHTML(employee);
    
    const modal = new bootstrap.Modal(document.getElementById('employeeModal'));
    modal.show();
    
    // Update edit button
    const editBtn = document.getElementById('editEmployeeBtn');
    editBtn.onclick = () => {
        modal.hide();
        editEmployee(employeeId);
    };
}

/**
 * Generate employee detail HTML
 */
function generateEmployeeDetailHTML(employee) {
    return `
        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <div class="employee-avatar">
                    <i class="bi bi-person-circle" style="font-size: 4rem; color: var(--primary);"></i>
                </div>
                <h5 class="mt-2 mb-1">${employee.employee_name}</h5>
                <span class="badge bg-${employee.status === 'active' ? 'success' : 'secondary'}">${employee.status === 'active' ? 'Đang làm việc' : 'Đã nghỉ việc'}</span>
            </div>
            <div class="col-md-8">
                <div class="employee-detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Mã nhân viên</div>
                        <div class="detail-value">${employee.employee_code}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Chức vụ</div>
                        <div class="detail-value">${employee.position}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tuổi</div>
                        <div class="detail-value">${employee.age} tuổi</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Giới tính</div>
                        <div class="detail-value">
                            <i class="bi bi-gender-${employee.gender === 'Nam' ? 'male' : 'female'} me-1"></i>
                            ${employee.gender}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Lương</div>
                        <div class="detail-value large currency">${formatCurrency(employee.salary)}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">
                            <a href="mailto:${employee.email}">${employee.email}</a>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Số điện thoại</div>
                        <div class="detail-value">
                            <a href="tel:${employee.phone}">${employee.phone}</a>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Ngày vào làm</div>
                        <div class="detail-value">${formatDate(employee.hire_date)}</div>
                    </div>
                </div>
                
                <hr class="my-3">
                
                <div class="employee-detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Mã đại lý</div>
                        <div class="detail-value">${employee.agent_code}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tên đại lý</div>
                        <div class="detail-value">${employee.agent_name}</div>
                    </div>
                    ${employee.department ? `
                    <div class="detail-item">
                        <div class="detail-label">Phòng ban</div>
                        <div class="detail-value">${employee.department}</div>
                    </div>
                    ` : ''}
                    ${employee.manager ? `
                    <div class="detail-item">
                        <div class="detail-label">Quản lý trực tiếp</div>
                        <div class="detail-value">${employee.manager}</div>
                    </div>
                    ` : ''}
                    ${employee.address ? `
                    <div class="detail-item">
                        <div class="detail-label">Địa chỉ</div>
                        <div class="detail-value">${employee.address}</div>
                    </div>
                    ` : ''}
                </div>
            </div>
        </div>
    `;
}

/**
 * Edit employee
 */
function editEmployee(employeeId) {
    const employee = findEmployeeById(employeeId);
    if (!employee) {
        showAlert('Không tìm thấy thông tin nhân viên', 'error');
        return;
    }
    
    // Redirect to edit page (or open edit modal)
    showAlert(`Chỉnh sửa nhân viên ${employee.employee_name} (Demo)`, 'info');
    
    // In real app: window.location.href = `edit_employee.php?id=${employeeId}`;
}

/**
 * Delete employee
 */
function deleteEmployee(employeeId) {
    const employee = findEmployeeById(employeeId);
    if (!employee) {
        showAlert('Không tìm thấy thông tin nhân viên', 'error');
        return;
    }
    
    if (confirm(`Bạn có chắc muốn xóa nhân viên "${employee.employee_name}"?\nHành động này không thể hoàn tác.`)) {
        // In real app, call API to delete
        showAlert(`Đã xóa nhân viên ${employee.employee_name} (Demo)`, 'success');
        
        // Remove from UI
        const row = document.querySelector(`tr[data-employee-id="${employeeId}"]`);
        if (row) {
            row.remove();
        }
        
        updateEmployeeStats();
    }
}

/**
 * Export employee data
 */
function exportEmployeeData() {
    showAlert('Đang xuất dữ liệu nhân viên... (Demo)', 'info');
    
    // In real app, generate and download Excel/CSV file
    setTimeout(() => {
        showAlert('Đã xuất dữ liệu thành công!', 'success');
    }, 1500);
}

/**
 * Import employee data
 */
function importEmployeeData() {
    showAlert('Chức năng import dữ liệu (Demo)', 'info');
    
    // In real app, show file upload modal
}

/**
 * Generate report
 */
function generateReport() {
    showAlert('Đang tạo báo cáo nhân viên... (Demo)', 'info');
    
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
        position: formData.get('position') || '',
        agent: formData.get('agent') || '',
        gender: formData.get('gender') || ''
    };
    
    applyFilters(filters);
}

/**
 * Perform search
 */
function performSearch(query) {
    const filters = {
        search: query.trim(),
        position: document.getElementById('positionFilter')?.value || '',
        agent: document.getElementById('agentFilter')?.value || '',
        gender: document.getElementById('genderFilter')?.value || ''
    };
    
    applyFilters(filters);
}

/**
 * Apply filters to employee list
 */
function applyFilters(filters) {
    // In real app, this would make an API call
    console.log('Applying filters:', filters);
    
    // Simulate filtering
    showAlert(`Đã áp dụng bộ lọc: ${JSON.stringify(filters)}`, 'info');
}

/**
 * Update employee statistics
 */
function updateEmployeeStats() {
    // In real app, calculate from actual data
    const stats = {
        active: currentEmployees.filter(e => e.status === 'active').length,
        total: currentEmployees.length,
        totalSalary: currentEmployees.reduce((sum, e) => sum + e.salary, 0),
        averageAge: Math.round(currentEmployees.reduce((sum, e) => sum + e.age, 0) / currentEmployees.length)
    };
    
    // Update UI (if needed for dynamic updates)
    console.log('Employee stats updated:', stats);
}

/**
 * Utility functions
 */

function findEmployeeById(id) {
    return currentEmployees.find(emp => emp.id == id);
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
    element.innerHTML = '<i class="bi bi-spinner-border spinner-border-sm me-2"></i>Đang xử lý...';
    
    return () => {
        element.classList.remove('loading');
        element.innerHTML = originalText;
    };
}

/**
 * Highlight table row
 */
function highlightRow(employeeId, type = 'success') {
    const row = document.querySelector(`tr[data-employee-id="${employeeId}"]`);
    if (row) {
        row.classList.add(`${type}-highlight`);
        setTimeout(() => {
            row.classList.remove(`${type}-highlight`);
        }, 3000);
    }
}

// Export functions for global access
window.initializeEmployeeTable = initializeEmployeeTable;
window.showEmployeeDetails = showEmployeeDetails;
window.editEmployee = editEmployee;
window.deleteEmployee = deleteEmployee;