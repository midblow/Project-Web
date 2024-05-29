let currentPage = 1;
const totalPages = 5; // jumlah halaman total 

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
  // untuk memuat halaman
  window.location.href = `events${page}.html`;
}
