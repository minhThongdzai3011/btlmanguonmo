    
    <footer class="mt-5 text-center text-muted small">
      <div class="row">
        <div class="col-md-6 text-md-start mb-2 mb-md-0">
          © <span id="currentYear"></span> SkyLine — Hệ thống quản lý đại lý bán vé
        </div>
        <div class="col-md-6 text-md-end">
          <span class="me-3">Phiên bản 1.0.0</span>
          <a href="#" class="text-muted text-decoration-none me-3" onclick="alert('Chức năng đang phát triển')">Hỗ trợ</a>
          <a href="#" class="text-muted text-decoration-none" onclick="alert('Chức năng đang phát triển')">Điều khoản</a>
        </div>
      </div>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('currentYear').textContent = new Date().getFullYear();
      
      initializeTheme();
      
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });

    function initializeTheme() {
      const body = document.body;
      const toggle = document.getElementById('themeToggle');
      const themeLabel = document.getElementById('themeLabel');
      const THEME_KEY = 'airagent-theme';

      function applyTheme(mode) {
        if (mode === 'dark') {
          body.classList.add('dark-mode');
          toggle.checked = true;
          themeLabel.textContent = 'Tối';
        } else {
          body.classList.remove('dark-mode');
          toggle.checked = false;
          themeLabel.textContent = 'Sáng';
        }
      }

      const saved = localStorage.getItem(THEME_KEY);
      if (saved) {
        applyTheme(saved);
      } else {
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(prefersDark ? 'dark' : 'light');
      }

      toggle.addEventListener('change', function(){
        const mode = this.checked ? 'dark' : 'light';
        applyTheme(mode);
        localStorage.setItem(THEME_KEY, mode);
      });
    }

    function confirmLogout() {
      if (confirm('Bạn có chắc muốn đăng xuất?')) {
        window.location.href = '/manguonmo/handle/logout.php';
      }
      return false;
    }

    function showAlert(message, type = 'info') {
      const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
          <i class="bi bi-info-circle-fill me-2"></i>
          ${message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
      
      const container = document.querySelector('.container-xxl');
      const firstChild = container.firstElementChild;
      firstChild.insertAdjacentHTML('beforebegin', alertHtml);
    }

    function formatCurrency(amount) {
      return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
      }).format(amount);
    }

    function formatDate(dateString) {
      return new Date(dateString).toLocaleDateString('vi-VN');
    }
  </script>

  <!-- Page specific scripts -->
  <?php if (isset($page_scripts)): ?>
  <script>
    <?= $page_scripts ?>
  </script>
  <?php endif; ?>

  <!-- External page scripts -->
  <?php if (isset($js_files)): ?>
    <?php foreach ($js_files as $js_file): ?>
    <script src="<?= htmlspecialchars($js_file) ?>"></script>
    <?php endforeach; ?>
  <?php endif; ?>

</body>
</html>