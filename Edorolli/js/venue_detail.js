document.addEventListener("DOMContentLoaded", function () {
  const calendarTitle = document.getElementById("calendar-title");
  const calendar = document.getElementById("calendar");
  const bookButton = document.getElementById("bookButton");
  const startDateInput = document.getElementById("start_date");
  const endDateInput = document.getElementById("end_date");
  const paymentPopup = document.getElementById("paymentPopup");
  const prevMonthButton = document.getElementById("prevMonth");
  const nextMonthButton = document.getElementById("nextMonth");

  let today = new Date();
  let currentMonth = today.getMonth();
  let currentYear = today.getFullYear();

  function renderCalendar(month, year) {
    calendar.innerHTML = "";
    const firstDay = new Date(year, month).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const monthName = new Date(year, month).toLocaleString("default", {
      month: "long",
    });

    calendarTitle.textContent = `${monthName} ${year}`;

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

  function updateCalendar(bookings, year, month) {
    const dayElements = calendar.querySelectorAll(".day");
    dayElements.forEach((dayElement, index) => {
      const day = dayElement.textContent;
      const date = `${year}-${String(month + 1).padStart(2, "0")}-${String(
        day
      ).padStart(2, "0")}`;
      if (bookings[date]) {
        dayElement.classList.add(bookings[date]);
      } else {
        dayElement.classList.remove("waiting", "confirmed", "reserved");
      }
    });
  }

  prevMonthButton.addEventListener("click", function () {
    if (currentMonth === 0) {
      currentMonth = 11;
      currentYear -= 1;
    } else {
      currentMonth -= 1;
    }
    renderCalendar(currentMonth, currentYear);
  });

  nextMonthButton.addEventListener("click", function () {
    if (currentMonth === 11) {
      currentMonth = 0;
      currentYear += 1;
    } else {
      currentMonth += 1;
    }
    renderCalendar(currentMonth, currentYear);
  });

  bookButton.addEventListener("click", function () {
    const startDate = startDateInput.value;
    const endDate = endDateInput.value;
    if (startDate && endDate) {
      // Post new booking to the server
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
          updateCalendar(bookings, currentYear, currentMonth);
          // Show payment popup
          paymentPopup.style.display = "block";
        });
    }
  });

  renderCalendar(currentMonth, currentYear);
});