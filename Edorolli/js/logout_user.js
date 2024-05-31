document.getElementById('logoutBtn').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('logoutPopup').style.display = 'flex';
});

document.getElementById('cancelBtnLO').addEventListener('click', function() {
    document.getElementById('logoutPopup').style.display = 'none';
});

document.getElementById('confirmBtnLO').addEventListener('click', function() {
    window.location.href = 'User.php?action=logout';
});