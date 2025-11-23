document.addEventListener('DOMContentLoaded', function() {
    const itemsPerPage = 4;
    let currentPage = 1;
    
    const tbody = document.querySelector('.table-custom tbody');
    const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => !row.querySelector('td[colspan]'));
    const totalPages = Math.ceil(rows.length / itemsPerPage);
    
    // Hiển thị hàng theo trang
    function displayPage(page) {
        currentPage = page;
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        
        rows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
                // Cập nhật số thứ tự
                const firstCell = row.querySelector('td:first-child');
                if (firstCell) {
                    firstCell.textContent = index + 1;
                }
            } else {
                row.style.display = 'none';
            }
        });
        
        updatePagination();
    }
    
    // Cập nhật pagination buttons
    function updatePagination() {
        const pagination = document.querySelector('.pagination');
        if (!pagination) return;
        
        let html = '';
        
        // Previous button
        html += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage - 1}" ${currentPage === 1 ? 'tabindex="-1"' : ''}>Trước</a>
            </li>
        `;
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            html += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
        }
        
        // Next button
        html += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage + 1}" ${currentPage === totalPages ? 'tabindex="-1"' : ''}>Sau</a>
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
    
    // Initialize pagination
    if (rows.length > 0 && totalPages > 0) {
        displayPage(1);
    }
    
    // Search functionality
    const searchInput = document.querySelector('.history-search input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let visibleCount = 0;
            
            rows.forEach(row => {
                const ticketCode = row.querySelector('.ticket-code');
                if (ticketCode && ticketCode.textContent.toLowerCase().includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else if (!searchTerm) {
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Hide pagination when searching
            const pagination = document.querySelector('.pagination');
            if (searchTerm && pagination) {
                pagination.parentElement.style.display = 'none';
            } else if (pagination) {
                pagination.parentElement.style.display = 'block';
                displayPage(1);
            }
        });
    }
});