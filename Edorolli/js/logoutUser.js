document.getElementById("logoutBtn").addEventListener("click", function () {
  document.getElementById("logoutPopup").style.display = "flex";
});

document.getElementById("cancelBtnLO").addEventListener("click", function () {
  document.getElementById("logoutPopup").style.display = "none";
});

document.getElementById("confirmBtnLO").addEventListener("click", function () {
  window.location.href = "homepage.html";
});
