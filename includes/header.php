<?php
$page_title = $page_title ?? 'SkyLine Admin';
$page_description = $page_description ?? 'Hệ thống quản lý các đại lý bán vé';
$css_files = $css_files ?? ['../css/main.css'];
$current_page = $current_page ?? '';
$username = $username ?? 'User';
$role = $role ?? 'User';
$displayName = ucfirst($username);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($page_title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> <!-- icon -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  
  <?php foreach ($css_files as $css_file): ?>
  <link rel="stylesheet" href="<?= htmlspecialchars($css_file) ?>" />
  <?php endforeach; ?>

  <?php if (isset($page_styles)): ?>
  <style>
    <?= $page_styles ?>
  </style>
  <?php endif; ?>
</head>
<body>
  <div class="container-xxl py-4">
    <!-- Header -->
    <header class="d-flex align-items-center justify-content-between mb-4 px-3 py-3 rounded">
      <div class="d-flex align-items-center gap-3">
        <div class="brand-logo d-flex align-items-center justify-content-center">
          <i class="bi bi-airplane-fill text-white fs-4"></i>
        </div>
        <div>
          <h1 class="h5 mb-0">
            <a href="<?= ($current_page === 'menu') ? '#' : '../menu.php' ?>" class="text-decoration-none text-inherit">
              SkyLine Admin
            </a>
          </h1>
          <div class="text-muted small"><?= htmlspecialchars($page_description) ?></div>
        </div>
      </div>

      <div class="d-flex align-items-center gap-3">
        <!-- Theme toggle -->
        <div class="form-check form-switch m-0">
          <input class="form-check-input" type="checkbox" id="themeToggle" />
          <label class="form-check-label small" for="themeToggle" id="themeLabel">Sáng</label>
        </div>

        <!-- User Info -->
        <div class="dropdown">
          <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2" 
                  type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="user-avatar">
              <i class="bi bi-person-circle fs-5"></i>
            </div>
            <div class="d-none d-md-block text-start">
              <div class="fw-semibold small"><?= htmlspecialchars($displayName) ?></div>
              <div class="text-muted small"><?= htmlspecialchars($role) ?></div>
            </div>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
              <div class="dropdown-header">
                <div class="fw-semibold"><?= htmlspecialchars($displayName) ?></div>
                <div class="text-muted small"><?= htmlspecialchars($role) ?></div>
              </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="<?= ($current_page === 'menu') ? '#' : '../views/menu.php' ?>">
                <i class="bi bi-house-door me-2"></i>Dashboard
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#" onclick="alert('Chức năng đang phát triển')">
                <i class="bi bi-person me-2"></i>Hồ sơ cá nhân
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#" onclick="alert('Chức năng đang phát triển')">
                <i class="bi bi-gear me-2"></i>Cài đặt
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="/manguonmo/handle/logout.php">
                
                <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
              </a>
            </li>
          </ul>
        </div>
      </div>
    </header>
    
    <!-- Page Title -->
    <?php if (isset($show_page_title) && $show_page_title): ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="h4 mb-1"><?= htmlspecialchars($page_title) ?></h2>
        <?php if (isset($page_subtitle)): ?>
        <p class="text-muted mb-0"><?= htmlspecialchars($page_subtitle) ?></p>
        <?php endif; ?>
      </div>
      <?php if (isset($page_actions)): ?>
      <div class="d-flex gap-2">
        <?= $page_actions ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>


    <div id="alertContainer">
      
    </div>
