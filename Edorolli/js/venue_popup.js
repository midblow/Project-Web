document.addEventListener('DOMContentLoaded', function() {
    var bookButton = document.getElementById('bookButton');
    var paymentPopup = document.getElementById('paymentPopup');
    var closePopup = document.getElementById('closePopup');

    bookButton.addEventListener('click', function() {
        console.log('Book button clicked');  // Debugging log
        paymentPopup.style.display = 'block';
    });

    closePopup.addEventListener('click', function() {
        console.log('Close button clicked');  // Debugging log
        paymentPopup.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == paymentPopup) {
            console.log('Clicked outside the popup');  // Debugging log
            paymentPopup.style.display = 'none';
        }
    });
});
