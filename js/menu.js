document.addEventListener('DOMContentLoaded', function() {
  
  // ====================================
  // Initialize Charts
  // ====================================
  if (typeof Chart !== 'undefined' && typeof chartData !== 'undefined') {
    initializeCharts();
  }
  
  function initializeCharts() {
    // 1. Revenue Chart (Line Chart)
    initRevenueChart();
    
    // 2. Products Distribution (Doughnut Chart)
    initProductsChart();
    
    // 3. Top Agents Performance (Bar Chart)
    initAgentChart();
    
    // 4. Employee Salary Distribution (Horizontal Bar Chart)
    initSalaryChart();
  }
  
  // Revenue Chart - Monthly Revenue Trend
  function initRevenueChart() {
    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;
    
    // Generate 12 months data
    const months = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'];
    const currentMonth = new Date().getMonth();
    
    // Simulate revenue data based on actual agent sales
    const baseRevenue = chartData.stats.totalAgentSales / 12;
    const revenueData = months.map((month, index) => {
      if (index <= currentMonth) {
        const variance = (Math.random() - 0.5) * 0.4;
        return Math.round(baseRevenue * (1 + variance));
      }
      return 0;
    });
    
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: months,
        datasets: [{
          label: 'Doanh thu (VNĐ)',
          data: revenueData,
          borderColor: '#0d6efd',
          backgroundColor: 'rgba(13, 110, 253, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointRadius: 5,
          pointHoverRadius: 7,
          pointBackgroundColor: '#0d6efd',
          pointBorderColor: '#fff',
          pointBorderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            titleFont: { size: 14, weight: 'bold' },
            bodyFont: { size: 13 },
            callbacks: {
              label: function(context) {
                return 'Doanh thu: ' + context.parsed.y.toLocaleString('vi-VN') + ' VNĐ';
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return (value / 1000000).toFixed(0) + 'M';
              }
            },
            grid: {
              color: 'rgba(0, 0, 0, 0.05)'
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  }
  
  // Products Distribution Chart
  function initProductsChart() {
    const ctx = document.getElementById('productsChart');
    if (!ctx) return;
    
    // Count products by status - calculate total quantity for each product
    const inStock = chartData.products.filter(p => {
      const total = parseInt(p.quantity_economy || 0) + parseInt(p.quantity_vip || 0) + parseInt(p.quantity_business || 0);
      return total > 30;
    }).length;
    
    const availableStock = chartData.products.filter(p => {
      const total = parseInt(p.quantity_economy || 0) + parseInt(p.quantity_vip || 0) + parseInt(p.quantity_business || 0);
      return total > 10 && total <= 30;
    }).length;
    
    const lowStock = chartData.products.filter(p => {
      const total = parseInt(p.quantity_economy || 0) + parseInt(p.quantity_vip || 0) + parseInt(p.quantity_business || 0);
      return total > 0 && total <= 10;
    }).length;
    
    const outOfStock = chartData.products.filter(p => {
      const total = parseInt(p.quantity_economy || 0) + parseInt(p.quantity_vip || 0) + parseInt(p.quantity_business || 0);
      return total === 0;
    }).length;
    
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Còn nhiều (>30)', 'Còn hàng (10-30)', 'Sắp hết (<10)', 'Hết hàng'],
        datasets: [{
          data: [inStock, availableStock, lowStock, outOfStock],
          backgroundColor: [
            '#198754',
            '#0dcaf0',
            '#ffc107',
            '#dc3545'
          ],
          borderWidth: 3,
          borderColor: '#fff',
          hoverOffset: 10
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 15,
              font: { size: 12, weight: '500' },
              usePointStyle: true,
              pointStyle: 'circle'
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            callbacks: {
              label: function(context) {
                const label = context.label || '';
                const value = context.parsed || 0;
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = ((value / total) * 100).toFixed(1);
                return label + ': ' + value + ' (' + percentage + '%)';
              }
            }
          }
        }
      }
    });
  }
  
  // Top Agents Performance Chart
  function initAgentChart() {
    const ctx = document.getElementById('agentChart');
    if (!ctx) return;
    
    // Get top 5 agents by sales
    const sortedAgents = [...chartData.agents]
      .sort((a, b) => parseFloat(b.sales) - parseFloat(a.sales))
      .slice(0, 5);
    
    const labels = sortedAgents.map(a => a.agent_name.length > 15 ? a.agent_name.substring(0, 15) + '...' : a.agent_name);
    const data = sortedAgents.map(a => parseFloat(a.sales));
    
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Doanh thu (VNĐ)',
          data: data,
          backgroundColor: [
            'rgba(13, 110, 253, 0.8)',
            'rgba(25, 135, 84, 0.8)',
            'rgba(255, 193, 7, 0.8)',
            'rgba(13, 202, 240, 0.8)',
            'rgba(108, 117, 125, 0.8)'
          ],
          borderColor: [
            '#0d6efd',
            '#198754',
            '#ffc107',
            '#0dcaf0',
            '#6c757d'
          ],
          borderWidth: 2,
          borderRadius: 8,
          borderSkipped: false
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            callbacks: {
              label: function(context) {
                return 'Doanh thu: ' + context.parsed.y.toLocaleString('vi-VN') + ' VNĐ';
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return (value / 1000000).toFixed(0) + 'M';
              }
            },
            grid: {
              color: 'rgba(0, 0, 0, 0.05)'
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  }
  
  // Employee Salary Distribution Chart
  function initSalaryChart() {
    const ctx = document.getElementById('salaryChart');
    if (!ctx) return;
    
    // Group employees by salary range
    const salaryRanges = {
      '< 5M': 0,
      '5M - 10M': 0,
      '10M - 15M': 0,
      '15M - 20M': 0,
      '> 20M': 0
    };
    
    chartData.employees.forEach(emp => {
      const salary = parseFloat(emp.salary);
      if (salary < 5000000) salaryRanges['< 5M']++;
      else if (salary < 10000000) salaryRanges['5M - 10M']++;
      else if (salary < 15000000) salaryRanges['10M - 15M']++;
      else if (salary < 20000000) salaryRanges['15M - 20M']++;
      else salaryRanges['> 20M']++;
    });
    
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: Object.keys(salaryRanges),
        datasets: [{
          label: 'Số nhân viên',
          data: Object.values(salaryRanges),
          backgroundColor: 'rgba(255, 193, 7, 0.8)',
          borderColor: '#ffc107',
          borderWidth: 2,
          borderRadius: 8,
          borderSkipped: false
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            callbacks: {
              label: function(context) {
                return 'Số lượng: ' + context.parsed.x + ' nhân viên';
              }
            }
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            },
            grid: {
              color: 'rgba(0, 0, 0, 0.05)'
            }
          },
          y: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  }
  
  // ====================================
  // Number Counter Animation
  // ====================================
  function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const duration = 2000; // 2 seconds
    const increment = target / (duration / 16); // 60fps
    let current = 0;
    
    const timer = setInterval(function() {
      current += increment;
      if (current >= target) {
        element.textContent = target.toLocaleString('vi-VN');
        clearInterval(timer);
      } else {
        element.textContent = Math.floor(current).toLocaleString('vi-VN');
      }
    }, 16);
  }
  
  // Animate all counters
  const counters = document.querySelectorAll('.stats-number[data-target]');
  
  // Use Intersection Observer for better performance
  const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px'
  };
  
  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);
  
  counters.forEach(function(counter) {
    observer.observe(counter);
  });
  
  
  // ====================================
  // Stats Card Hover Effects
  // ====================================
  const statsCards = document.querySelectorAll('.stats-card');
  
  statsCards.forEach(function(card) {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-8px)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });
  
  
  // ====================================
  // Tab Navigation
  // ====================================
  const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
  
  tabButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      // Save active tab to localStorage
      const target = this.getAttribute('data-bs-target');
      localStorage.setItem('activeMenuTab', target);
    });
  });
  
  // Restore active tab from localStorage
  const savedTab = localStorage.getItem('activeMenuTab');
  if (savedTab) {
    const tabButton = document.querySelector('[data-bs-target="' + savedTab + '"]');
    if (tabButton) {
      const tab = new bootstrap.Tab(tabButton);
      tab.show();
    }
  }
  
  
  // ====================================
  // Table Search & Filter
  // ====================================
  function createSearchBox(tableId) {
    const table = document.querySelector('#' + tableId + ' .data-table');
    if (!table) return;
    
    const tableContainer = table.closest('.table-responsive');
    const parentDiv = tableContainer.parentElement;
    
    // Create search input
    const searchDiv = document.createElement('div');
    searchDiv.className = 'mb-3';
    searchDiv.innerHTML = `
      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" class="form-control search-input" placeholder="Tìm kiếm...">
      </div>
    `;
    
    parentDiv.insertBefore(searchDiv, tableContainer);
    
    const searchInput = searchDiv.querySelector('.search-input');
    
    // Search functionality
    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const rows = table.querySelectorAll('tbody tr');
      
      rows.forEach(function(row) {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
      
      // Show "no results" message if needed
      const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
      if (visibleRows.length === 0 && searchTerm !== '') {
        showNoResults(table);
      } else {
        hideNoResults(table);
      }
    });
  }
  
  function showNoResults(table) {
    const tbody = table.querySelector('tbody');
    let noResultRow = tbody.querySelector('.no-result-row');
    
    if (!noResultRow) {
      const colCount = table.querySelectorAll('thead th').length;
      noResultRow = document.createElement('tr');
      noResultRow.className = 'no-result-row';
      noResultRow.innerHTML = `
        <td colspan="${colCount}" class="text-center py-4">
          <i class="bi bi-search display-4 text-muted"></i>
          <p class="text-muted mt-2">Không tìm thấy kết quả</p>
        </td>
      `;
      tbody.appendChild(noResultRow);
    }
    
    noResultRow.style.display = '';
  }
  
  function hideNoResults(table) {
    const tbody = table.querySelector('tbody');
    const noResultRow = tbody.querySelector('.no-result-row');
    if (noResultRow) {
      noResultRow.style.display = 'none';
    }
  }
  
  // Add search boxes to all tabs
  createSearchBox('products');
  createSearchBox('agents');
  createSearchBox('employees');
  
  
  // ====================================
  // Pagination for Tables
  // ====================================
  function createPagination(tabId) {
    const itemsPerPage = 3;
    let currentPage = 1;
    
    const tab = document.getElementById(tabId);
    if (!tab) return;
    
    const table = tab.querySelector('.data-table tbody');
    if (!table) return;
    
    const rows = Array.from(table.querySelectorAll('tr'));
    const totalPages = Math.ceil(rows.length / itemsPerPage);
    
    // Tạo pagination HTML
    const paginationContainer = document.createElement('div');
    paginationContainer.className = 'mt-3';
    paginationContainer.innerHTML = `
      <nav aria-label="Table pagination">
        <ul class="pagination pagination-sm justify-content-center" id="pagination-${tabId}">
        </ul>
      </nav>
    `;
    
    const tableWrapper = tab.querySelector('.table-responsive');
    if (tableWrapper && !document.getElementById(`pagination-${tabId}`)) {
      tableWrapper.after(paginationContainer);
    }
    
    function displayPage(page) {
      currentPage = page;
      const start = (page - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      
      rows.forEach((row, index) => {
        if (index >= start && index < end) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
      
      updatePagination();
    }
    
    function updatePagination() {
      const pagination = document.getElementById(`pagination-${tabId}`);
      if (!pagination) return;
      
      let html = '';
      
      // Previous button
      html += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
          <a class="page-link" href="#" data-page="${currentPage - 1}">‹</a>
        </li>
      `;
      
      // Page numbers
      for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
          html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
              <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
          `;
        } else if (i === currentPage - 2 || i === currentPage + 2) {
          html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
      }
      
      // Next button
      html += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
          <a class="page-link" href="#" data-page="${currentPage + 1}">›</a>
        </li>
      `;
      
      pagination.innerHTML = html;
      
      // Add click event listeners
      pagination.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const page = parseInt(this.dataset.page);
          if (page >= 1 && page <= totalPages) {
            displayPage(page);
          }
        });
      });
    }
    
    // Initialize
    if (rows.length > itemsPerPage) {
      displayPage(1);
    }
    
    // Re-initialize when tab is shown
    const tabButton = document.querySelector(`[data-bs-target="#${tabId}"]`);
    if (tabButton) {
      tabButton.addEventListener('shown.bs.tab', function() {
        displayPage(1);
      });
    }
  }
  
  // Add pagination to all tabs
  createPagination('products');
  createPagination('agents');
  createPagination('employees');
  createPagination('captains');
  createPagination('stewards');
  createPagination('flights');
  createPagination('airlines');
  
  
  // ====================================
  // Table Sorting
  // ====================================
  function makeTableSortable(tableId) {
    const table = document.querySelector('#' + tableId + ' .data-table');
    if (!table) return;
    
    const headers = table.querySelectorAll('thead th');
    
    headers.forEach(function(header, index) {
      // Skip action column
      if (header.textContent.trim() === 'Thao tác') return;
      
      header.style.cursor = 'pointer';
      header.innerHTML += ' <i class="bi bi-chevron-expand sort-icon" style="font-size: 0.75rem; opacity: 0.5;"></i>';
      
      header.addEventListener('click', function() {
        sortTable(table, index, this);
      });
    });
  }
  
  function sortTable(table, columnIndex, header) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr:not(.no-result-row)'));
    
    // Determine sort direction
    const currentDirection = header.getAttribute('data-sort-direction') || 'asc';
    const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
    
    // Update header
    const allHeaders = table.querySelectorAll('thead th');
    allHeaders.forEach(h => {
      h.removeAttribute('data-sort-direction');
      const icon = h.querySelector('.sort-icon');
      if (icon) icon.className = 'bi bi-chevron-expand sort-icon';
    });
    
    header.setAttribute('data-sort-direction', newDirection);
    const icon = header.querySelector('.sort-icon');
    if (icon) {
      icon.className = newDirection === 'asc' ? 'bi bi-chevron-up sort-icon' : 'bi bi-chevron-down sort-icon';
    }
    
    // Sort rows
    rows.sort(function(a, b) {
      const aValue = a.cells[columnIndex].textContent.trim();
      const bValue = b.cells[columnIndex].textContent.trim();
      
      // Try to parse as number
      const aNum = parseFloat(aValue.replace(/[^\d.-]/g, ''));
      const bNum = parseFloat(bValue.replace(/[^\d.-]/g, ''));
      
      let comparison = 0;
      
      if (!isNaN(aNum) && !isNaN(bNum)) {
        comparison = aNum - bNum;
      } else {
        comparison = aValue.localeCompare(bValue, 'vi');
      }
      
      return newDirection === 'asc' ? comparison : -comparison;
    });
    
    // Re-append rows
    rows.forEach(function(row) {
      tbody.appendChild(row);
    });
  }
  
  // Make all tables sortable
  makeTableSortable('products');
  makeTableSortable('agents');
  makeTableSortable('employees');
  
  
  // ====================================
  // Confirm Delete Actions
  // ====================================
  const deleteLinks = document.querySelectorAll('a[onclick^="return confirm"]');
  
  deleteLinks.forEach(function(link) {
    link.addEventListener('click', function(e) {
      if (!confirm('Bạn có chắc chắn muốn xóa?')) {
        e.preventDefault();
        return false;
      }
    });
  });
  
  
  // ====================================
  // Toast Notifications
  // ====================================
  function showToast(message, type) {
    const toastContainer = document.createElement('div');
    toastContainer.style.position = 'fixed';
    toastContainer.style.top = '20px';
    toastContainer.style.right = '20px';
    toastContainer.style.zIndex = '9999';
    
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill';
    
    toastContainer.innerHTML = `
      <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
        <i class="bi bi-${icon} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    `;
    
    document.body.appendChild(toastContainer);
    
    // Auto remove after 5 seconds
    setTimeout(function() {
      toastContainer.remove();
    }, 5000);
  }
  
  // Check for success/error messages in URL
  const urlParams = new URLSearchParams(window.location.search);
  const successMsg = urlParams.get('success');
  const errorMsg = urlParams.get('error');
  
  if (successMsg) {
    showToast(successMsg, 'success');
  }
  
  if (errorMsg) {
    showToast(errorMsg, 'error');
  }
  
  
  // ====================================
  // Responsive Table
  // ====================================
  function checkTableResponsive() {
    const tables = document.querySelectorAll('.table-responsive');
    
    tables.forEach(function(container) {
      const table = container.querySelector('table');
      if (table.offsetWidth > container.offsetWidth) {
        container.classList.add('has-scroll');
      } else {
        container.classList.remove('has-scroll');
      }
    });
  }
  
  checkTableResponsive();
  window.addEventListener('resize', checkTableResponsive);
  
  
  // ====================================
  // Print Functionality
  // ====================================
  function addPrintButton() {
    const tabs = document.querySelectorAll('.tab-pane');
    
    tabs.forEach(function(tab) {
      const header = tab.querySelector('.d-flex.justify-content-between');
      if (header) {
        const printBtn = document.createElement('button');
        printBtn.className = 'btn btn-outline-secondary ms-2';
        printBtn.innerHTML = '<i class="bi bi-printer me-2"></i>In';
        
        printBtn.addEventListener('click', function() {
          window.print();
        });
        
        const btnContainer = header.querySelector('a').parentElement;
        btnContainer.appendChild(printBtn);
      }
    });
  }
  
  addPrintButton();
  
  
  // ====================================
  // Table Row Click to Expand (Optional)
  // ====================================
  const tableRows = document.querySelectorAll('.data-table tbody tr');
  
  tableRows.forEach(function(row) {
    row.addEventListener('dblclick', function() {
      const editBtn = this.querySelector('.btn-outline-primary');
      if (editBtn) {
        window.location.href = editBtn.getAttribute('href');
      }
    });
  });
  
  
  console.log('Menu.js loaded successfully!');
});
