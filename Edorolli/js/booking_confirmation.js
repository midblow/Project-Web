document.addEventListener("DOMContentLoaded", function () {
  var approveButtons = document.querySelectorAll(".approve");

  approveButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      alert("Success!");
      var orderItem = button.closest(".order-item");
      var statusDiv = document.createElement("div");
      statusDiv.classList.add("order-status", "success");
      statusDiv.textContent = "SUCCESS!!!";
      loadWindow();
      orderItem.appendChild(statusDiv);

      var actionsDiv = orderItem.querySelector(".order-actions");
      if (actionsDiv) {
        actionsDiv.remove();
      }
    });
  });
});
