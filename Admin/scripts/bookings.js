// scripts/bookings.js

function deleteBooking(bookingId) {
    if (confirm("Are you sure you want to delete this booking?")) {
        fetch('admin_delete_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'booking_id': bookingId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert("Booking deleted successfully!");
                location.reload(); // Reload the page to reflect changes
            } else {
                alert("Failed to delete booking: " + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
