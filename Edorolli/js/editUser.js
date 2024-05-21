document.getElementById("editBtn").addEventListener("click", function () {
  // Mengaktifkan semua input dan textarea kecuali input gender
  document.getElementById("profileForm")
    .querySelectorAll("input:not(#gender), textarea")
    .forEach(function (element) {
      element.disabled = false;
    });
  document.getElementById("editBtn").style.display = "none";
  document.getElementById("cancelBtn").style.display = "inline-block";
  document.getElementById("saveBtn").style.display = "inline-block";
});

document.getElementById("cancelBtn").addEventListener("click", function () {
  // Menonaktifkan semua input dan textarea
  document.getElementById("profileForm")
    .querySelectorAll("input, textarea")
    .forEach(function (element) {
      element.disabled = true;
    });
  document.getElementById("editBtn").style.display = "inline-block";
  document.getElementById("cancelBtn").style.display = "none";
  document.getElementById("saveBtn").style.display = "none";
});
