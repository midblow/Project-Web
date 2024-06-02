function previewImage(event) {
  var reader = new FileReader();
  reader.onload = function () {
    var output = document.getElementById("preview-image");
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
}

function validateForm() {
  let kapasitas = document.getElementById("kapasitas").value;
  let harga = document.getElementById("harga").value;
  let pemerintah = document.getElementById("pemerintah").checked;
  let swasta = document.getElementById("swasta").checked;

  // Validate kapasitas and harga to be numbers
  kapasitas = kapasitas.replace(/\./g, "");
  harga = harga.replace(/\./g, "");

  if (isNaN(kapasitas) || isNaN(harga)) {
    alert("Kapasitas dan Harga harus berupa angka.");
    return false;
  }

  // Ensure at least one radio button is checked
  if (!pemerintah && !swasta) {
    alert("Pilih salah satu jenis instansi.");
    return false;
  }

  // Update form values with cleaned numbers
  document.getElementById("kapasitas").value = kapasitas;
  document.getElementById("harga").value = harga;

  return true;
}

function enableEditing() {
  var elements = document.querySelectorAll(
    '#venue-form input, #venue-form textarea, #venue-form input[type="file"]'
  );
  elements.forEach(function (element) {
    element.disabled = false;
  });
  document.querySelector(".save-cancel-buttons").style.display = "flex";
  document.querySelector(".action-buttons").style.display = "none";
}

function cancelEditing() {
  var elements = document.querySelectorAll(
    '#venue-form input, #venue-form textarea, #venue-form input[type="file"]'
  );
  elements.forEach(function (element) {
    element.disabled = true;
  });
  document.querySelector(".save-cancel-buttons").style.display = "none";
  document.querySelector(".action-buttons").style.display = "flex";
}

function deleteVenue() {
  if (confirm("Are you sure you want to delete this venue?")) {
    var venueId = document.getElementById("venue_id").value;
    window.location.href = "../php/delete_venue.php?id=" + venueId;
  }
}
