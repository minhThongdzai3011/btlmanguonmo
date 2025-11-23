<?php
session_start();

$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Đăng ký - SkyLine</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../../css/register.css" />
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
    <div class="particles-bg"></div>
    
    <div class="container-fluid h-100">
      <div class="row h-100 align-items-center justify-content-center">
        <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">
          
          <div class="login-card">
            <div class="login-header text-center mb-4">
              <div class="brand-logo-container">
                <div class="brand-logo">
                  <i class="bi bi-airplane-engines-fill"></i>
                </div>
              </div>
              <h1 class="login-title">
                <span class="text-gradient">Đăng ký tài khoản</span>
              </h1>
              <p class="login-subtitle">
                Tạo tài khoản mới để sử dụng hệ thống
              </p>
            </div>

            <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>
              <?php echo htmlspecialchars($error); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="bi bi-check-circle-fill me-2"></i>
              <?php echo htmlspecialchars($success); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <form method="POST" action="../../handle/user_process.php?action=create" class="login-form needs-validation" novalidate id="registerForm">
              
              <div class="form-group mb-3">
                <label class="form-label" for="username">
                  <i class="bi bi-person-fill me-2"></i>Tên đăng nhập
                </label>
                <div class="input-group-modern">
                  <span class="input-icon">
                    <i class="bi bi-person"></i>
                  </span>
                  <input type="text" class="form-control" id="username" name="username" 
                         placeholder="Nhập tên đăng nhập" required />
                  <div class="invalid-feedback">
                    Vui lòng nhập tên đăng nhập
                  </div>
                </div>
              </div>

              <div class="form-group mb-3">
                <label class="form-label" for="password">
                  <i class="bi bi-lock-fill me-2"></i>Mật khẩu
                </label>
                <div class="input-group-modern">
                  <span class="input-icon">
                    <i class="bi bi-lock"></i>
                  </span>
                  <input type="password" class="form-control" id="password" name="password" 
                         placeholder="Nhập mật khẩu" required />
                  <button class="input-action" type="button" id="togglePassword">
                    <i class="bi bi-eye"></i>
                  </button>
                  <div class="invalid-feedback">
                    Vui lòng nhập mật khẩu
                  </div>
                </div>
              </div>

              <div class="form-group mb-4">
                <label class="form-label" for="confirmPassword">
                  <i class="bi bi-shield-lock-fill me-2"></i>Xác nhận mật khẩu
                </label>
                <div class="input-group-modern">
                  <span class="input-icon">
                    <i class="bi bi-shield-lock"></i>
                  </span>
                  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" 
                         placeholder="Nhập lại mật khẩu" required />
                  <button class="input-action" type="button" id="toggleConfirmPassword">
                    <i class="bi bi-eye"></i>
                  </button>
                  <div class="invalid-feedback">
                    Mật khẩu không khớp
                  </div>
                </div>
              </div>

              <input type="hidden" name="role" value="user">

              <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                <label class="form-check-label" for="agreeTerms">
                  Tôi đồng ý với <a href="#" class="text-primary">điều khoản sử dụng</a>
                </label>
              </div>

              <div class="d-grid mb-3">
                <button class="btn btn-login" type="submit" name="register" id="registerBtn">
                  <span class="btn-text">
                    <i class="bi bi-person-plus-fill me-2"></i>Đăng ký
                  </span>
                  <div class="btn-ripple"></div>
                </button>
              </div>

              <div class="text-center mt-3">
                <p class="text-muted mb-0">
                  Đã có tài khoản? 
                  <a href="login.php" class="text-primary fw-bold">Đăng nhập ngay</a>
                </p>
              </div>
            </form>

            <div class="login-footer text-center mt-4">
              <div class="copyright">
                <i class="bi bi-c-circle me-1"></i>
                <span id="currentYear"></span> SkyLine. Designed with 
                <i class="bi bi-heart-fill text-danger"></i> by Dev Nhom 4
              </div>
            </div>
          </div>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      initializeForm();
      initializeParticles();
      document.getElementById('currentYear').textContent = new Date().getFullYear();
    });

    function initializeForm() {
      const form = document.getElementById('registerForm');
      const password = document.getElementById('password');
      const confirmPassword = document.getElementById('confirmPassword');
      const togglePassword = document.getElementById('togglePassword');
      const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

      // Toggle password visibility
      togglePassword.addEventListener('click', function() {
        const icon = this.querySelector('i');
        if (password.type === 'password') {
          password.type = 'text';
          icon.className = 'bi bi-eye-slash';
        } else {
          password.type = 'password';
          icon.className = 'bi bi-eye';
        }
      });

      toggleConfirmPassword.addEventListener('click', function() {
        const icon = this.querySelector('i');
        if (confirmPassword.type === 'password') {
          confirmPassword.type = 'text';
          icon.className = 'bi bi-eye-slash';
        } else {
          confirmPassword.type = 'password';
          icon.className = 'bi bi-eye';
        }
      });

      // Validate password match
      form.addEventListener('submit', function(e) {
        if (password.value !== confirmPassword.value) {
          e.preventDefault();
          e.stopPropagation();
          confirmPassword.setCustomValidity('Mật khẩu không khớp');
        } else {
          confirmPassword.setCustomValidity('');
        }
        form.classList.add('was-validated');
      });

      confirmPassword.addEventListener('input', function() {
        if (password.value === confirmPassword.value) {
          confirmPassword.setCustomValidity('');
        } else {
          confirmPassword.setCustomValidity('Mật khẩu không khớp');
        }
      });
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
  </script>
</body>
</html>