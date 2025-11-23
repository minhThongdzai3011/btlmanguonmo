let currentPrice = 1500000;
let currentQuantity = 1;
let currentType = 'economy';
let priceEconomy = 1500000;
let priceVip = 5000000;
let priceBusiness = 3500000;

// Hàm xử lý khi chọn hạng vé
function selectClass(element, price, type) {
    document.querySelectorAll('.ticket-class-option').forEach(el => el.classList.remove('selected'));
    element.classList.add('selected');
    currentPrice = price;
    currentType = type;
    element.querySelector('input[type="radio"]').checked = true;
    
    // Update hidden fields
    document.getElementById('selectedType').value = type;
    document.getElementById('selectedPrice').value = price * currentQuantity;
    
    calculateTotal();
}

// Hàm cập nhật số lượng
function updateQuantity(change) {
    let newVal = currentQuantity + change;
    if (newVal >= 1 && newVal <= 20) {
        currentQuantity = newVal;
        document.getElementById('quantityInput').value = currentQuantity;
        document.getElementById('bookingQuantity').value = currentQuantity;
        document.getElementById('selectedPrice').value = currentPrice * currentQuantity;
        calculateTotal();
    }
}

// Hàm tính tổng tiền
function calculateTotal() {
    let total = currentPrice * currentQuantity;
    let formattedTotal = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
    document.getElementById('totalPrice').innerText = formattedTotal;
    
    // Update hidden field
    document.getElementById('selectedPrice').value = total;
}

// Initialize prices from data attributes
document.addEventListener('DOMContentLoaded', function() {
    const economyOption = document.querySelector('[data-class="economy"]');
    const vipOption = document.querySelector('[data-class="vip"]');
    const businessOption = document.querySelector('[data-class="business"]');
    
    if (economyOption) {
        priceEconomy = parseFloat(economyOption.dataset.price);
    }
    if (vipOption) {
        priceVip = parseFloat(vipOption.dataset.price);
    }
    if (businessOption) {
        priceBusiness = parseFloat(businessOption.dataset.price);
    }
    
    currentPrice = priceEconomy;
    calculateTotal();
});