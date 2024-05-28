function submitForm() {
    // Menggunakan FormData untuk mengirimkan data gambar bersamaan dengan formulir
    var formData = new FormData(document.getElementById("venue-form"));
    var imageFormData = new FormData(document.getElementById("image-upload-form"));
    var fileInput = document.getElementById("file");

    // Menambahkan file gambar ke FormData jika dipilih
    if (fileInput.files.length > 0) {
        formData.append("file", fileInput.files[0]);
    }

    // Mengirimkan data formulir dan gambar
    fetch("/upload", {
        method: "POST",
        body: formData
    }).then(response => {
        // Lakukan sesuatu setelah pengiriman selesai, seperti menampilkan pesan atau meredirect
    }).catch(error => {
        console.error("Error:", error);
    });

    // Submit formulir utama
    fetch("../php/add_venue.php", {
        method: "POST",
        body: formData
    }).then(response => {
        // Lakukan sesuatu setelah pengiriman selesai, seperti menampilkan pesan atau meredirect
    }).catch(error => {
        console.error("Error:", error);
    });
}