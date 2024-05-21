document.addEventListener('DOMContentLoaded', function() {
    var popup = document.getElementById('popup');
    var popupMessage = document.getElementById('popup-message');
    var close = document.querySelector('.close');

    // Menutup popup ketika tombol 'close' diklik
    close.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    // Menutup popup ketika area luar popup diklik
    window.addEventListener('click', function(event) {
        if (event.target == popup) {
            popup.style.display = 'none';
        }
    });

    // Mendapatkan parameter dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    // Menampilkan pesan popup berdasarkan status
    if (status) {
        if (status === 'success') {
            popupMessage.textContent = 'Thank you for contacting us. We will get back to you soon.';
        } else if (status === 'error') {
            popupMessage.textContent = 'There was an error sending your message. Please try again later.';
        }
        popup.style.display = 'block';
    }
});