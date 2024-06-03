document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.approve-btn').forEach(button => {
      button.addEventListener('click', () => {
        const eventId = button.getAttribute('data-event-id');
        fetch('../php/approve_event.php?id_event=' + eventId)
          .then(response => response.text())
          .then(data => {
            alert(data);
            location.reload();
          });
      });
    });
  
    document.querySelectorAll('.decline-btn').forEach(button => {
      button.addEventListener('click', () => {
        const eventId = button.getAttribute('data-event-id');
        fetch('../php/decline_event.php?id_event=' + eventId)
          .then(response => response.text())
          .then(data => {
            alert(data);
            location.reload();
          });
      });
    });
  });