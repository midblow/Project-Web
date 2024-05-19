let currentPage = 1;
const totalPages = 5; // Ganti dengan jumlah halaman total yang kamu miliki

document.getElementById("prev-button").addEventListener("click", function () {
  if (currentPage > 1) {
    currentPage--;
    updatePageNumber();
    loadPage(currentPage);
  }
});

document.getElementById("next-button").addEventListener("click", function () {
  if (currentPage < totalPages) {
    currentPage++;
    updatePageNumber();
    loadPage(currentPage);
  }
});

function updatePageNumber() {
  document.querySelector(".page-number").textContent = currentPage;
}

function loadPage(page) {
  // Logika untuk memuat halaman yang sesuai
  window.location.href = `events${page}.html`;
}
