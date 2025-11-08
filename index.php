<?php
session_start();

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Đăng nhập - AirAgent Admin</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/index.css" />
</head>
<body>
  <!-- Animated Background -->
  <div class="background-animation">
    <div class="floating-shapes">
      <div class="shape shape-1"></div>
      <div class="shape shape-2"></div>
      <div class="shape shape-3"></div>
      <div class="shape shape-4"></div>
      <div class="shape shape-5"></div>
    </div>
  </div>

  <div class="login-container">
    <!-- Particles Background -->
    <div class="particles-bg"></div>
    
    <!-- Main Content -->
    <div class="container-fluid h-100">
      <div class="row h-100 align-items-center justify-content-center">
        <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">
          
          <!-- Login Card -->
          <div class="login-card">
            <!-- Header with animation -->
            <div class="login-header text-center mb-4">
              <div class="brand-logo-container">
                <div class="brand-logo mx-auto mb-3">
                  <div class="logo-inner">
                    <i class="bi bi-airplane-fill"></i>
                  </div>
                  <div class="logo-pulse"></div>
                </div>
              </div>
              <h1 class="login-title">
                <span class="title-gradient">AirAgent</span> Admin
              </h1>
              <p class="login-subtitle">
                <i class="bi bi-shield-check me-2"></i>
                Hệ thống quản lý đại lý bán vé máy bay
              </p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="handle/login.php" class="login-form needs-validation" novalidate id="loginForm">
              <!-- Error Alert (hidden by default) -->
              <div class="alert alert-danger animated-alert d-none" role="alert" id="errorAlert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <span id="errorMessage">Tên đăng nhập hoặc mật khẩu không đúng</span>
              </div>

              <div class="form-group mb-4">
                <label for="username" class="form-label">
                  <i class="bi bi-person-circle me-2"></i>Tên đăng nhập
                </label>
                <div class="input-wrapper">
                  <div class="input-group">
                    <span class="input-group-text">
                      <i class="bi bi-person"></i>
                    </span>
                    <input 
                      type="text" 
                      class="form-control" 
                      id="username" 
                      name="username"
                      value=""
                      placeholder="Nhập tên đăng nhập của bạn"
                      required
                      autocomplete="username"
                    >
                    <div class="input-focus-border"></div>
                  </div>
                  <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    Vui lòng nhập tên đăng nhập
                  </div>
                </div>
              </div>

              <div class="form-group mb-4">
                <label for="password" class="form-label">
                  <i class="bi bi-shield-lock me-2"></i>Mật khẩu
                </label>
                <div class="input-wrapper">
                  <div class="input-group">
                    <span class="input-group-text">
                      <i class="bi bi-lock"></i>
                    </span>
                    <input 
                      type="password" 
                      class="form-control" 
                      id="password" 
                      name="password"
                      placeholder="Nhập mật khẩu của bạn"
                      required
                      autocomplete="current-password"
                    >
                    <button 
                      class="btn btn-outline-secondary password-toggle" 
                      type="button" 
                      id="togglePassword"
                      tabindex="-1"
                    >
                      <i class="bi bi-eye"></i>
                    </button>
                    <div class="input-focus-border"></div>
                  </div>
                  <div class="invalid-feedback">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    Vui lòng nhập mật khẩu
                  </div>
                </div>
              </div>

              <div class="form-options mb-4">
                <div class="form-check custom-checkbox">
                  <input class="form-check-input" type="checkbox" id="rememberMe" name="remember_me">
                  <label class="form-check-label" for="rememberMe">
                    <span class="checkmark"></span>
                    Ghi nhớ đăng nhập
                  </label>
                </div>
                <a href="#" class="forgot-password" data-bs-toggle="modal" data-bs-target="#forgotModal">
                  <i class="bi bi-question-circle me-1"></i>Quên mật khẩu?
                </a>
              </div>

              <div class="d-grid mb-4">
                <button type="submit" class="btn btn-login" id="loginBtn" name="login" >
                  <span class="btn-content">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    <span class="btn-text">Đăng nhập</span>
                  </span>
                  <span class="btn-loader">
                    <span class="spinner"></span>
                    <span class="loading-text">Đang xử lý...</span>
                  </span>
                  <div class="btn-ripple"></div>
                </button>
              </div>
            </form>

            <!-- Footer -->
            <div class="login-footer text-center mt-4">
              <div class="theme-toggle-wrapper">
                <div class="theme-toggle">
                  <input type="checkbox" id="themeToggle" />
                  <label for="themeToggle" class="toggle-label">
                    <span class="toggle-icon sun"><i class="bi bi-sun-fill"></i></span>
                    <span class="toggle-icon moon"><i class="bi bi-moon-fill"></i></span>
                    <span class="toggle-slider"></span>
                  </label>
                  <span class="theme-text" id="themeLabel">Chế độ tối</span>
                </div>
              </div>
              
              <div class="copyright">
                <i class="bi bi-c-circle me-1"></i>
                <span id="currentYear"></span> AirAgent. Designed with 
                <i class="bi bi-heart-fill text-danger"></i> by Dev Nhom 4
              </div>
            </div>
          </div>

          <!-- System Status -->
          <div class="system-status text-center mt-3">
            <div class="status-indicator">
              <span class="status-dot online"></span>
              <span class="status-text">Hệ thống hoạt động bình thường</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div class="modal fade" id="forgotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content custom-modal">
        <div class="modal-header border-0">
          <h5 class="modal-title">
            <i class="bi bi-key me-2"></i>Khôi phục mật khẩu
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          <p class="text-muted mb-4">
            <i class="bi bi-info-circle me-2"></i>
            Nhập email của bạn để nhận liên kết đặt lại mật khẩu.
          </p>
          <form id="forgotForm">
            <div class="form-group">
              <label for="forgotEmail" class="form-label">Email khôi phục</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bi bi-envelope"></i>
                </span>
                <input type="email" class="form-control" id="forgotEmail" 
                       placeholder="example@company.com" required>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">
            <i class="bi bi-x-lg me-1"></i>Hủy
          </button>
          <button type="button" class="btn btn-primary" id="sendResetBtn">
            <i class="bi bi-send me-1"></i>Gửi liên kết
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Initialize animations and interactions
    document.addEventListener('DOMContentLoaded', function() {
      initializeAnimations();
      initializeTheme();
      initializeForm();
      initializeParticles();
      
      // Set current year
      document.getElementById('currentYear').textContent = new Date().getFullYear();
    });

    function initializeAnimations() {
      // Stagger animation for form elements
      const formElements = document.querySelectorAll('.form-group, .form-options, .btn-login, .quick-login');
      formElements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
        el.classList.add('animate-in');
      });

      // Logo pulse animation
      setTimeout(() => {
        document.querySelector('.brand-logo').classList.add('pulse-active');
      }, 500);
    }

    function initializeTheme() {
      const body = document.body;
      const toggle = document.getElementById('themeToggle');
      const themeLabel = document.getElementById('themeLabel');
      const THEME_KEY = 'airagent-theme';

      function applyTheme(mode) {
        if (mode === 'dark') {
          body.classList.add('dark-mode');
          toggle.checked = true;
          themeLabel.textContent = 'Chế độ sáng';
        } else {
          body.classList.remove('dark-mode');
          toggle.checked = false;
          themeLabel.textContent = 'Chế độ tối';
        }
      }

      // Load saved theme
      const saved = localStorage.getItem(THEME_KEY);
      if (saved) {
        applyTheme(saved);
      } else {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(prefersDark ? 'dark' : 'light');
      }

      toggle.addEventListener('change', function(){
        const mode = this.checked ? 'dark' : 'light';
        applyTheme(mode);
        localStorage.setItem(THEME_KEY, mode);
      });
    }

    function initializeForm() {
      const form = document.getElementById('loginForm');
      const loginBtn = document.getElementById('loginBtn');
      const usernameInput = document.getElementById('username');
      const passwordInput = document.getElementById('password');
      const togglePassword = document.getElementById('togglePassword');

      // Password toggle
      togglePassword.addEventListener('click', function() {
        const icon = this.querySelector('i');
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          icon.className = 'bi bi-eye-slash';
        } else {
          passwordInput.type = 'password';
          icon.className = 'bi bi-eye';
        }
      });

      // Ripple effect for login button
      loginBtn.addEventListener('click', function(e) {
        const ripple = this.querySelector('.btn-ripple');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('animate');
        
        setTimeout(() => ripple.classList.remove('animate'), 600);
      });

      // Auto-focus
      if (usernameInput.value === '') {
        usernameInput.focus();
      } else {
        passwordInput.focus();
      }
    }

    function initializeParticles() {
      const particlesBg = document.querySelector('.particles-bg');
      for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 4 + 's';
        particle.style.animationDuration = (Math.random() * 3 + 2) + 's';
        particlesBg.appendChild(particle);
      }
    }

    // Forgot password modal
    document.getElementById('sendResetBtn').addEventListener('click', function() {
      const email = document.getElementById('forgotEmail').value;
      if (email) {
        // Simulate API call
        this.innerHTML = '<i class="bi bi-arrow-repeat spin me-1"></i>Đang gửi...';
        this.disabled = true;
        
        setTimeout(() => {
          alert('Liên kết đặt lại mật khẩu đã được gửi đến ' + email + ' (Demo)');
          const modal = bootstrap.Modal.getInstance(document.getElementById('forgotModal'));
          modal.hide();
          document.getElementById('forgotForm').reset();
          this.innerHTML = '<i class="bi bi-send me-1"></i>Gửi liên kết';
          this.disabled = false;
        }, 2000);
      } else {
        document.getElementById('forgotEmail').focus();
      }
    });
  </script> 
</body>
</html>