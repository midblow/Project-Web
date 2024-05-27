
document.addEventListener("DOMContentLoaded", function () {
    var bookButton = document.getElementById("bookButton");
    var paymentPopup = document.getElementById("paymentPopup");
    var closePopup = document.getElementById("closePopup");
    var confirmPaymentButton = document.querySelector(".confirm-payment");
    var dropdowns = document.getElementsByClassName("dropdown");
  
    var startDateInput = document.getElementById("start_date");
    var endDateInput = document.getElementById("end_date");
  
    const paymentOptions = {
      bank: [
        { id: "bri", name: "BANK BRI", detail: "transfer ke (ATM, BRI Mobile, Internet Banking)", fee: "Rp. 0", logo: "bri.png" },
        { id: "bca", name: "BCA", detail: "transfer ke (ATM, m_BCA, Internet Banking)", fee: "Rp. 2.500", logo: "bca.png" },
        { id: "mandiri", name: "mandiri", detail: "transfer ke (ATM, mandiri Mobile, Internet Banking)", fee: "Rp. 1.000", logo: "mandiri.png" },
        { id: "bni", name: "BNI", detail: "transfer ke (ATM, BNI Mobile, Internet Banking)", fee: "Rp. 2.500", logo: "bni.png" },
      ],
      gerai: [
        { id: "alfamart", name: "Alfamart", detail: "", fee: "", logo: "alfamart.png" },
        { id: "indomaret", name: "Indomaret", detail: "", fee: "", logo: "indomaret.png" },
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
      paymentPopup.style.display = "block";
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
  
        // Close all other dropdowns
        for (let j = 0; j < dropdowns.length; j++) {
          if (dropdowns[j].querySelector(".dropdown-content") !== currentDropdown) {
            dropdowns[j].querySelector(".dropdown-content").classList.remove("show");
            dropdowns[j].querySelector(".dropbtn i").classList.remove("fa-caret-up");
            dropdowns[j].querySelector(".dropbtn i").classList.add("fa-caret-down");
          }
        }
  
        // Toggle current dropdown
        currentDropdown.classList.toggle("show");
        icon.classList.toggle("fa-caret-up");
        icon.classList.toggle("fa-caret-down");
      });
    }
  
    confirmPaymentButton.addEventListener("click", function () {
      const startDate = startDateInput.value;
      const endDate = endDateInput.value;
  
      if (startDate && endDate) {
        fetch("add_booking.php", {
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
            updateCalendar(bookings);
            paymentPopup.style.display = "none";
          });
      }
    });
  
    function renderCalendar() {
      const calendar = document.getElementById("calendar");
      const today = new Date();
      const currentMonth = today.getMonth();
      const currentYear = today.getFullYear();
  
      calendar.innerHTML = "";
  
      const firstDay = new Date(currentYear, currentMonth, 1).getDay();
      const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
      const monthName = today.toLocaleString("default", { month: "long" });
  
      const calendarTitle = document.getElementById("calendar-title");
      calendarTitle.textContent = `${monthName} ${currentYear}`;
  
      // Add blank days for the first week
      for (let i = 0; i < firstDay; i++) {
        const blankDay = document.createElement("div");
        calendar.appendChild(blankDay);
      }
  
      // Add days of the month
      for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement("div");
        dayElement.textContent = day;
        dayElement.classList.add("day");
        calendar.appendChild(dayElement);
      }
  
      // Fetch booking data from the server
      fetch("php/venue_calendar.php")
      .then((response) => {
          if (!response.ok) {
              throw new Error("Network response was not ok");
          }
          return response.json();
      })
      .then((bookings) => {
          updateCalendar(bookings);
      })
      .catch((error) => {
          console.error("Fetch error:", error);
      });
    }
  
    function updateCalendar(bookings) {
      const calendar = document.getElementById("calendar");
      const dayElements = calendar.querySelectorAll(".day");
  
      dayElements.forEach((dayElement) => {
        const day = dayElement.textContent;
        const currentYear = new Date().getFullYear();
        const currentMonth = new Date().getMonth();
        const date = `${currentYear}-${String(currentMonth + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
  
        if (bookings[date]) {
          dayElement.classList.add(bookings[date]);
        } else {
          dayElement.classList.remove("waiting", "confirmed", "reserved");
        }
      });
    }
  
    function validateDates() {
      const startDate = new Date(startDateInput.value);
      const endDate = new Date(endDateInput.value);
  
      console.log("Start Date:", startDate);
      console.log("End Date:", endDate);
  
      if (startDate && endDate && startDate <= endDate) {
        bookButton.removeAttribute("disabled");
        console.log("Book button enabled");
      } else {
        bookButton.setAttribute("disabled", "true");
        console.log("Book button disabled");
      }
    }
  
    startDateInput.addEventListener("input", validateDates);
    endDateInput.addEventListener("input", validateDates);
  
    renderCalendar();
  });
  