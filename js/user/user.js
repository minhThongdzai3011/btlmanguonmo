document.addEventListener('DOMContentLoaded', function() {
    const itemsPerPage = 8;
    let currentPage = 1;
    
    const productContainer = document.querySelector('.row.g-4');
    const products = Array.from(productContainer.querySelectorAll('.col-lg-3'));
    const totalPages = Math.ceil(products.length / itemsPerPage);
    
    // Tạo phần pagination
    function createPagination() {
        const paginationHTML = `
            <div class="col-12">
                <nav aria-label="Product pagination">
                    <ul class="pagination justify-content-center" id="productPagination">
                        <!-- Pagination sẽ được tạo bởi JS -->
                    </ul>
                </nav>
            </div>
        `;
        productContainer.insertAdjacentHTML('afterend', paginationHTML);
    }
    
    // Hiển thị sản phẩm theo trang
    function displayPage(page) {
        currentPage = page;
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        
        products.forEach((product, index) => {
            if (index >= start && index < end) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
        
        updatePagination();
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    // Cập nhật pagination buttons
    function updatePagination() {
        const pagination = document.getElementById('productPagination');
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
    if (products.length > itemsPerPage) {
        createPagination();
        displayPage(1);
    }
});