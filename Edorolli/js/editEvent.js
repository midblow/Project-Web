function enableEditing() {
    var elements = document.querySelectorAll(
        '#event-form input, #event-form textarea, #event-form input[type="file"], #event-form input[type="checkbox"]'
    );
    elements.forEach(function (element) {
        element.disabled = false;
        if (element.tagName === 'TEXTAREA') {
            element.removeAttribute('readonly');
        }
        else if (element.tagName === 'INPUT' && element.type === 'text') {
            element.removeAttribute('readonly');
        }
    });

    document.querySelector(".edit-button").style.display = "none";
    document.querySelector(".delete-button").style.display = "none";
    document.querySelector(".submit-button1").style.display = "block";
    document.querySelector(".cancel-button").style.display = "block";
}
function cancelEditing() {
    var elements = document.querySelectorAll(
        '#event-form input, #event-form textarea, #event-form input[type="file"], #event-form input[type="checkbox"]'
    );
    elements.forEach(function (element) {
        element.disabled = true;
        if (element.tagName === 'TEXTAREA') {
            element.setAttribute('readonly', true);
        }
    });

    document.querySelector(".edit-button").style.display = "block";
    document.querySelector(".delete-button").style.display = "block";
    document.querySelector(".submit-button").style.display = "none";
    document.querySelector(".cancel-button").style.display = "none";
}

function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById("preview-image-upload");
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

function deleteEvent(eventId) {
    if (confirm("Are you sure you want to delete this event?")) {
        window.location.href = "../php/delete_event.php?id_event=" + eventId;
    }
}
