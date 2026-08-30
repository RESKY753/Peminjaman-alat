// Fungsi Konfirmasi Hapus Data / Aksi Bahaya
function showAlertConfirm(title, message, onConfirm) {
    const overlay = document.getElementById("customAlertOverlay");
    const icon = document.getElementById("customAlertIcon");
    const titleEl = document.getElementById("customAlertTitle");
    const msgEl = document.getElementById("customAlertMessage");
    const btnCancel = document.getElementById("customAlertBtnCancel");
    const btnConfirm = document.getElementById("customAlertBtnConfirm");

    // Set Konten
    icon.className = "custom-alert-icon danger";
    icon.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>';
    titleEl.innerText = title;
    msgEl.innerText = message;

    btnCancel.style.display = "block";
    btnCancel.innerText = "Batal";

    btnConfirm.className = "custom-alert-btn confirm-danger";
    btnConfirm.innerText = "Ya, Hapus!";

    // Tampilkan Modal
    overlay.classList.add("active");

    // Event Klik Batal
    btnCancel.onclick = function () {
        closeCustomAlert();
    };

    // Event Klik Konfirmasi (Jalankan Callback)
    btnConfirm.onclick = function () {
        closeCustomAlert();
        if (typeof onConfirm === "function") {
            onConfirm();
        }
    };
}

// Fungsi Notifikasi Informasi / Berhasil
function showAlertSuccess(title, message) {
    const overlay = document.getElementById("customAlertOverlay");
    const icon = document.getElementById("customAlertIcon");
    const titleEl = document.getElementById("customAlertTitle");
    const msgEl = document.getElementById("customAlertMessage");
    const btnCancel = document.getElementById("customAlertBtnCancel");
    const btnConfirm = document.getElementById("customAlertBtnConfirm");

    // Set Konten
    icon.className = "custom-alert-icon success";
    icon.innerHTML = '<i class="fa-solid fa-check"></i>';
    titleEl.innerText = title;
    msgEl.innerText = message;

    btnCancel.style.display = "none"; // Sembunyikan tombol batal

    btnConfirm.className = "custom-alert-btn confirm-success";
    btnConfirm.innerText = "OK";

    // Tampilkan Modal
    overlay.classList.add("active");

    btnConfirm.onclick = function () {
        closeCustomAlert();
    };
}

// Fungsi Tutup Modal
function closeCustomAlert() {
    const overlay = document.getElementById("customAlertOverlay");
    overlay.classList.remove("active");
}
