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
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((result) => {
            if (result.success) {
                fetch("php/venue_calendar.php")
                    .then(response => response.json())
                    .then(bookings => {
                        window.updateCalendar(bookings, currentYear, currentMonth);
                        paymentPopup.style.display = "none";
                    })
                    .catch(error => console.error("Fetch error:", error));
            } else {
                alert("Booking failed: " + result.error);
            }
        })
        .catch((error) => {
            console.error("Fetch error:", error);
        });
    } else {
        alert("Please select valid dates.");
    }
});
