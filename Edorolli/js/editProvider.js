document.addEventListener("DOMContentLoaded", function () {
    const editBtn = document.getElementById("editBtn");
    const cancelBtn = document.getElementById("cancelBtn");
    const saveBtn = document.getElementById("saveBtn");
    const formElements = document.querySelectorAll("#profileForm input, #profileForm textarea");

    editBtn.addEventListener("click", () => {
        formElements.forEach((element) => {
            element.disabled = false;
        });
        editBtn.style.display = "none";
        cancelBtn.style.display = "inline-block";
        saveBtn.style.display = "inline-block";
    });

    cancelBtn.addEventListener("click", () => {
        formElements.forEach((element) => {
            element.disabled = true;
        });
        editBtn.style.display = "inline-block";
        cancelBtn.style.display = "none";
        saveBtn.style.display = "none";
    });
});
