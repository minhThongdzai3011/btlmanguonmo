<?php
$page_title = 'Thêm chuyến bay - AirAgent Admin';
$page_description = 'Tạo chuyến bay mới';
$current_page = 'flight';
$css_files = ['../../css/main.css', '../../css/flights/create_flight.css'];
$js_files = ['../../js/flights/create_flight.js'];

$username = 'Admin';
$role = 'Administrator';

// Lấy danh sách airlines, captains, stewards
require_once '../../functions/airline_function.php';
require_once '../../functions/captain_function.php';
require_once '../../functions/steward_funtion.php';

$airlines = getAllAirlines();
$captains = getAllCaptains();
$stewards = getAllStewards();

$show_page_title = true;
$page_subtitle = 'Nhập thông tin chuyến bay mới';
$page_actions = '
  <a href="index.php" class="btn btn-secondary">
    <i class="bi bi-arrow-left me-2"></i>Quay lại
  </a>
';

$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';

include '../../includes/header.php';
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
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

    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <i class="bi bi-airplane me-2"></i>Thông tin chuyến bay
        </h5>
      </div>
      <div class="card-body">
        <form id="createFlightForm" action="../../handle/flight_process.php?action=create" method="POST" class="needs-validation" novalidate>
          
          <!-- Flight Code -->
          <div class="mb-3">
            <label for="flight_code" class="form-label">
              Mã chuyến bay <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="flight_code" name="flight_code" 
                   placeholder="VD: VN123" 
                   pattern="^[A-Z]{2}[0-9]{3,6}$"
                   required>
            <div class="invalid-feedback">Vui lòng nhập mã chuyến bay (VD: VN123)</div>
            <small class="form-text text-muted">
              Format: 2 chữ cái viết hoa + 3-6 số (VN123)
            </small>
          </div>

          <!-- Flight Name -->
          <div class="mb-3">
            <label for="flight_name" class="form-label">
              Tên chuyến bay <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="flight_name" name="flight_name" 
                   placeholder="VD: Hà Nội - Sài Gòn" required>
            <div class="invalid-feedback">Vui lòng nhập tên chuyến bay</div>
          </div>

          <!-- Airline, Captain, Steward -->
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <label for="airline_code" class="form-label">
                Hãng hàng không <span class="text-danger">*</span>
              </label>
              <select class="form-select" id="airline_code" name="airline_code" required>
                <option value="">-- Chọn hãng --</option>
                <?php foreach ($airlines as $airline): ?>
                  <option value="<?php echo htmlspecialchars($airline['airline_code']); ?>">
                    <?php echo htmlspecialchars($airline['airline_code'] . ' - ' . $airline['airline_name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Vui lòng chọn hãng hàng không</div>
            </div>

            <div class="col-md-4">
              <label for="captain_code" class="form-label">
                Cơ trưởng <span class="text-danger">*</span>
              </label>
              <select class="form-select" id="captain_code" name="captain_code" required>
                <option value="">-- Chọn cơ trưởng --</option>
                <?php foreach ($captains as $captain): ?>
                  <option value="<?php echo htmlspecialchars($captain['captain_code']); ?>">
                    <?php echo htmlspecialchars($captain['captain_code'] . ' - ' . $captain['captain_name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Vui lòng chọn cơ trưởng</div>
            </div>

            <div class="col-md-4">
              <label for="steward_code" class="form-label">
                Tiếp viên <span class="text-danger">*</span>
              </label>
              <select class="form-select" id="steward_code" name="steward_code" required>
                <option value="">-- Chọn tiếp viên --</option>
                <?php foreach ($stewards as $steward): ?>
                  <option value="<?php echo htmlspecialchars($steward['steward_code']); ?>">
                    <?php echo htmlspecialchars($steward['steward_code'] . ' - ' . $steward['steward_name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Vui lòng chọn tiếp viên</div>
            </div>
          </div>

          <!-- Origin & Destination -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="origin" class="form-label">
                Điểm khởi hành <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" id="origin" name="origin" 
                     placeholder="VD: Hà Nội" required>
              <div class="invalid-feedback">Vui lòng nhập điểm khởi hành</div>
            </div>

            <div class="col-md-6">
              <label for="destination" class="form-label">
                Điểm đến <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" id="destination" name="destination" 
                     placeholder="VD: Sài Gòn" required>
              <div class="invalid-feedback">Vui lòng nhập điểm đến</div>
            </div>
          </div>

          <!-- Flight Time -->
          <div class="mb-3">
            <label for="flight_time" class="form-label">
              Thời gian bay <span class="text-danger">*</span>
            </label>
            <input type="datetime-local" class="form-control" id="flight_time" name="flight_time" required>
            <div class="invalid-feedback">Vui lòng chọn thời gian bay</div>
          </div>

          <!-- Submit Buttons -->
          <div class="d-flex gap-2 justify-content-end">
            <a href="index.php" class="btn btn-secondary">
              <i class="bi bi-x-lg me-2"></i>Hủy
            </a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
              <i class="bi bi-check-lg me-2"></i>Tạo chuyến bay
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
include '../../includes/footer.php';
?>
