const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('status');
const popup = document.getElementById('popup');

if (status === 'success') {
    popup.textContent = 'Terimakasih! Pesan anda telah terkirim^^';
    popup.classList.add('success');
    popup.style.visibility = 'visible';
} else if (status === 'error') {
    popup.textContent = 'Maaf, pesan anda tidak terkirim. Silahkan mengirimkan kembali';
    popup.classList.add('error');
    popup.style.visibility = 'visible';
}

// Menghilangkan popup setelah 5 detik
if (status) {
    setTimeout(() => {
        popup.style.visibility = 'hidden';
    }, 5000);
}