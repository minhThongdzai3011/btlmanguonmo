document.getElementById("filterForm")?.addEventListener("submit", function(e){
    e.preventDefault();
    showAlert("Tìm kiếm đại lý (demo). Kết nối API để lấy kết quả thật.", "info");
  });

  document.getElementById("agentForm")?.addEventListener("submit", function(e){
    e.preventDefault();
    const code = document.getElementById("agentCode").value || "[Mã]";
    const name = document.getElementById("agentName").value || "[Tên đại lý]";
    const modalEl = document.getElementById("agentModal");
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();
    showAlert("Lưu đại lý (demo): " + code + " - " + name + ". Kết nối backend để lưu dữ liệu.", "success");
    this.reset();
  });

  document.querySelectorAll(".editBtn").forEach(btn => {
    btn.addEventListener("click", function(){
      const code = this.getAttribute("data-code") || "";
      document.getElementById("agentModalTitle").textContent = "Sửa đại lý " + code;
      document.getElementById("agentCode").value = code;
      document.getElementById("agentName").value = "Tên đại lý " + code;
      const modal = new bootstrap.Modal(document.getElementById("agentModal"));
      modal.show();
    });
  });

 