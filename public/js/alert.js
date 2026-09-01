// public/js/alert.js

window.showAlertSuccess = function (title, message) {
const overlay = document.getElementById("customAlertOverlay");
const icon = document.getElementById("customAlertIcon");
const iconTag = document.getElementById("customAlertIconTag");
const titleEl = document.getElementById("customAlertTitle");
const msgEl = document.getElementById("customAlertMessage");
const btnCancel = document.getElementById("customAlertBtnCancel");
const btnConfirm = document.getElementById("customAlertBtnConfirm");

if (!overlay) return;

icon.className = "custom-alert-icon success";
if (iconTag) iconTag.className = "fa-solid fa-check";

titleEl.innerText = title;
msgEl.innerText = message;

btnCancel.style.display = "none";

btnConfirm.className = "custom-alert-btn confirm-success";
btnConfirm.innerText = "OK";

overlay.classList.add("active");

btnConfirm.onclick = function () {
overlay.classList.remove("active");
};
};

window.showAlertConfirm = function (title, message, onConfirm) {
const overlay = document.getElementById("customAlertOverlay");
const icon = document.getElementById("customAlertIcon");
const iconTag = document.getElementById("customAlertIconTag");
const titleEl = document.getElementById("customAlertTitle");
const msgEl = document.getElementById("customAlertMessage");
const btnCancel = document.getElementById("customAlertBtnCancel");
const btnConfirm = document.getElementById("customAlertBtnConfirm");

if (!overlay) return;

icon.className = "custom-alert-icon danger";
if (iconTag) iconTag.className = "fa-solid fa-triangle-exclamation";

titleEl.innerText = title;
msgEl.innerText = message;

btnCancel.style.display = "block";
btnCancel.innerText = "Batal";

btnConfirm.className = "custom-alert-btn confirm-danger";
btnConfirm.innerText = "Ya, Yakin!";

overlay.classList.add("active");

btnCancel.onclick = function () {
overlay.classList.remove("active");
};

btnConfirm.onclick = function () {
overlay.classList.remove("active");
if (typeof onConfirm === "function") {
onConfirm();
}
};
};

window.hapus = function (formId, namaItem = "data ini") {
window.showAlertConfirm(
"Hapus Data?",
`Apakah kamu yakin ingin menghapus ${namaItem}?`,
function () {
const targetForm = document.getElementById(formId);
if (targetForm) {
targetForm.submit();
}
},
);
};
