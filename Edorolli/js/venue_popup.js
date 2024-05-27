document.addEventListener("DOMContentLoaded", function () {
  var bookButton = document.getElementById("bookButton");
  var paymentPopup = document.getElementById("paymentPopup");
  var closePopup = document.getElementById("closePopup");
  var confirmPaymentButton = document.getElementById("pilihButton");
  var dropdowns = document.getElementsByClassName("dropdown");

  var startDateInput = document.getElementById("start_date");
  var endDateInput = document.getElementById("end_date");

  const paymentOptions = {
      bank: [
          { id: "bri", name: "BANK BRI", detail: "transfer ke (ATM, BRI Mobile, Internet Banking)", fee: "Rp. 0", logo: "bank BRI.png" },
          { id: "bca", name: "BCA", detail: "transfer ke (ATM, m_BCA, Internet Banking)", fee: "Rp. 2.500", logo: "bank BCA.png" },
          { id: "mandiri", name: "mandiri", detail: "transfer ke (ATM, mandiri Mobile, Internet Banking)", fee: "Rp. 1.000", logo: "bank Mandiri.jpeg" },
          { id: "bni", name: "BNI", detail: "transfer ke (ATM, BNI Mobile, Internet Banking)", fee: "Rp. 2.500", logo: "bank BNI.png" },
      ],
      gerai: [
          { id: "alfamart", name: "Alfamart", detail: "", fee: "", logo: "Alfamart.webp" },
          { id: "indomaret", name: "Indomaret", detail: "", fee: "", logo: "Indomaret.png" },
      ],
      ewallet: [
          { id: "dana", name: "DANA", detail: "", fee: "", logo: "dana.png" },
          { id: "ovo", name: "OVO", detail: "", fee: "", logo: "ovo.png" },
          { id: "shopeepay", name: "ShopeePay", detail: "", fee: "", logo: "shopeepay.png" },
          { id: "linkaja", name: "LinkAja", detail: "", fee: "", logo: "linkaja.png" },
      ],
  };

  function createPaymentOptions(options, containerId) {
      const container = document.getElementById(containerId);
      container.innerHTML = options
          .map(option => `
              <div>
                  <input type="radio" id="${option.id}" name="${containerId}" value="${option.id}" />
                  <label for="${option.id}">
                      <img src="../Edorolli/image/${option.logo}" alt="${option.name}" class="payment-logo" />
                      ${option.name} ${option.detail} ${option.fee}
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

      if (startDate && endDate) {
          fetch("php/add_booking.php", {
              method: "POST",
              headers: {
                  "Content-Type": "application/json",
              },
              body: JSON.stringify({
                  start_date: startDate,
                  end_date: endDate,
                  status: "waiting",
              }),
          })
              .then((response) => response.json())
              .then((bookings) => {
                  window.updateCalendar(bookings, currentYear, currentMonth);
                  paymentPopup.style.display = "none";
              })
              .catch((error) => {
                  console.error("Fetch error:", error);
              });
      } else {
          alert("Please select valid dates.");
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
