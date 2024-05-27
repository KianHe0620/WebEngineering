function cancelBooking(button) {
    if (confirm('Are you sure you want to cancel this booking?')) {
        var form = $(button).closest('.cancel-booking-form');
        $.post('cancel_booking.php', form.serialize())
            .done(function(response) {
                console.log(response);
                form.closest('tr').remove();
            })
            .fail(function(xhr, status, error) {
                console.error(xhr.responseText);
            });
    }
}
