document
  .getElementById("changePasswordBtn")
  .addEventListener("click", function () {
    console.log("Ganti Kata Sandi button clicked");
    document.getElementById("manageAccountButtons").style.display = "none";
    document.getElementById("changePasswordForm").style.display = "block";
  });

document
  .getElementById("cancelChangePasswordBtn")
  .addEventListener("click", function () {
    console.log("Batal button clicked");
    document.getElementById("manageAccountButtons").style.display = "flex";
    document.getElementById("changePasswordForm").style.display = "none";
  });

document
  .getElementById("passwordForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    console.log("Form submitted");

    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    // if (newPassword.length < 3 || !/\d/.test(newPassword))
    if (newPassword.length < 3) {
      showPopup(false, "Kata Sandi Gagal Disimpan");
      return;
    }

    if (newPassword !== confirmPassword) {
      showPopup(false, "Kata sandi dan konfirmasi kata sandi tidak cocok.");
      return;
    }

    // Lakukan submit form jika validasi berhasil
    console.log("Form is valid");
    this.submit();
  });

document.getElementById("closePopupBtn").addEventListener("click", function () {
  console.log("Popup close button clicked");
  document.getElementById("popup").style.display = "none";
});

function showPopup(success, message) {
  console.log("Show popup:", success, message);
  document.getElementById("popupMessage").textContent = message;
  document.getElementById("popup").style.display = "flex";
  if (success) {
    document.getElementById("popupIcon").style.display = "block";
    document.getElementById("popupErrorIcon").style.display = "none";
  } else {
    document.getElementById("popupIcon").style.display = "none";
    document.getElementById("popupErrorIcon").style.display = "block";
  }
}
