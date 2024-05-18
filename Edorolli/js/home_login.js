$(document).ready(function () {
  $("#venue-carousel").owlCarousel({
    items: 4,
    margin: 10,
    loop: true,
    nav: true,
    dots: false,
  });

  $("#event-carousel").owlCarousel({
    items: 3,
    loop: true,
    margin: 10,
    nav: true,
    dots: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3,
      },
    },
  });

  document.querySelectorAll(".nav-item").forEach((item) => {
    item.addEventListener("click", function () {
      document.querySelectorAll(".nav-item").forEach((nav) => {
        nav.classList.remove("active");
      });
      this.classList.add("active");
    });
  });
});
