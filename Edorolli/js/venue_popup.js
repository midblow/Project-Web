document.addEventListener("DOMContentLoaded", function () {
  var idVenue = document.body.getAttribute('data-venue-id');
  // console.log("idVenue from PHP:", idVenue); //log ini untuk memastikan nilai idVenue diatur dengan benar
  window.idVenue = idVenue; // Menyimpan idVenue ke dalam window global untuk diakses dari script lain

  // console.log("idVenue on DOMContentLoaded:", window.idVenue); //log ini untuk memastikan idVenue diakses dengan benar

  var bookButton = document.getElementById("bookButton");
  var paymentPopup = document.getElementById("paymentPopup");
  var closePopup = document.getElementById("closePopup");
  var confirmPaymentButton = document.getElementById("pilihButton");
  var dropdowns = document.getElementsByClassName("dropdown");

  var startDateInput = document.getElementById("start_date");
  var endDateInput = document.getElementById("end_date");

  const paymentOptions = {
      bank: [
          { id: "bri", name: "BANK BRI", logo: "bank BRI.png" },
          { id: "bca", name: "BCA", logo: "bank BCA.png" },
          { id: "mandiri", name: "mandiri", logo: "bank Mandiri.jpeg" },
          { id: "bni", name: "BNI", logo: "bank BNI.png" },
      ],
      gerai: [
          { id: "alfamart", name: "Alfamart", logo: "Alfamart.webp" },
          { id: "indomart", name: "Indomart", logo: "Indomart.png" },
      ],
      ewallet: [
          { id: "dana", name: "DANA", logo: "dana.png" },
          { id: "ovo", name: "OVO", logo: "ovo.png" },
          { id: "shopeepay", name: "ShopeePay", logo: "shopeepay.png" },
          { id: "linkaja", name: "LinkAja", logo: "linkaja.png" },
      ],
  };

  function createPaymentOptions(options, containerId) {
      const container = document.getElementById(containerId);
      container.innerHTML = options
          .map(option => `
              <div>
                  <input type="radio" id="${option.id}" name="payment_method" value="${option.id}" />
                  <label for="${option.id}">
                      <img src="../image/${option.logo}" alt="${option.name}" class="payment-logo" />
                      ${option.name}
                  </label>
              </div>
          `)
          .join('');
  }

  createPaymentOptions(paymentOptions.bank, "bankMethods");
  createPaymentOptions(paymentOptions.gerai, "geraiMethods");
  createPaymentOptions(paymentOptions.ewallet, "ewalletMethods");

  bookButton.addEventListener("click", function () {
      if (startDateInput.value && endDateInput.value) {
          paymentPopup.style.display = "block";
      } else {
          alert("Please select valid dates.");
      }
  });

  closePopup.addEventListener("click", function () {
      paymentPopup.style.display = "none";
  });

  window.addEventListener("click", function (event) {
      if (event.target == paymentPopup) {
          paymentPopup.style.display = "none";
      }
  });

  for (let i = 0; i < dropdowns.length; i++) {
      dropdowns[i].querySelector(".dropbtn").addEventListener("click", function () {
          let currentDropdown = this.nextElementSibling;
          let icon = this.querySelector("i");

          for (let j = 0; j < dropdowns.length; j++) {
              if (dropdowns[j].querySelector(".dropdown-content") !== currentDropdown) {
                  dropdowns[j].querySelector(".dropdown-content").classList.remove("show");
                  dropdowns[j].querySelector(".dropbtn i").classList.remove("fa-caret-up");
                  dropdowns[j].querySelector(".dropbtn i").classList.add("fa-caret-down");
              }
          }

          currentDropdown.classList.toggle("show");
          icon.classList.toggle("fa-caret-up");
          icon.classList.toggle("fa-caret-down");
      });
  }

  confirmPaymentButton.addEventListener("click", function () {
      const startDate = startDateInput.value;
      const endDate = endDateInput.value;
      const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

      if (startDate && endDate && paymentMethod) {
          const bookingData = {
              start_date: startDate,
              end_date: endDate,
              status: "waiting",
              payment_method: paymentMethod,
              id_venue: window.idVenue // Gunakan idVenue dari window global
          };

          fetch("../php/add_booking.php", {
              method: "POST",
              headers: {
                  "Content-Type": "application/json",
              },
              body: JSON.stringify(bookingData),
          })
          .then((response) => response.json())
          .then((data) => {
              console.log("Response data:", data); // Log respons untuk debugging
              if (data.success) {
                  paymentPopup.style.display = "none";
                  alert("Mohon Tunggu Konfirmasi Booking Anda");
                  location.reload();
                  window.updateCalendar(data.bookings);
              } else {
                  alert(data.error || "An error occurred");
              }
          })
          .catch((error) => {
              console.error("Fetch error:", error);
          });
      } else {
          alert("Please select valid dates and payment method.");
      }
  });

  function validateDates() {
      const startDate = new Date(startDateInput.value);
      const endDate = new Date(endDateInput.value);

      if (startDate && endDate && startDate <= endDate) {
          bookButton.removeAttribute("disabled");
      } else {
          bookButton.setAttribute("disabled", "true");
      }
  }

  startDateInput.addEventListener("input", validateDates);
  endDateInput.addEventListener("input", validateDates);
});