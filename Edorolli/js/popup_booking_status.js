document.addEventListener("DOMContentLoaded", function () {
    var successMessage = localStorage.getItem("successMessage");
    var errorMessage = localStorage.getItem("errorMessage");
    
    if (successMessage) {
        alert(successMessage);
        localStorage.removeItem("successMessage");
    }

    if (errorMessage) {
        alert(errorMessage);
        localStorage.removeItem("errorMessage");
    }
});
