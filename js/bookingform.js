function submitBookingForm() {
    var parkingNumber = $('#parkingNumber').val();
    var bookingDate = $('#bookingDate').val();
    var stime = $('#startTime').val();
    var etime = $('#endTime').val();

    var formattedStartTime = formatStartTime(stime);
    var formattedEndTime = formatEndTime(etime);

    // Check for empty fields
    if (!parkingNumber || !bookingDate || !stime || !etime) {
        alert("Please fill in all fields.");
        return;
    }

    // Perform additional validations if needed

    $.ajax({
        url: 'booking_update.php',
        type: 'POST',
        dataType: 'json',
        data: {
            parkingNumber: parkingNumber,
            bookingDate: bookingDate,
            startTime: formattedStartTime,
            endTime: formattedEndTime
        },
        success: function(response) {
            if (response.success) {
                alert(response.message);
                $('#bookingModal').modal('hide');
                window.location.href = "http://localhost/WebEngineering/ManageBooking/qrcode.php?booking_id=" + response.booking_id;
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred while processing your request. Please try again later.");
        }
    });
}

$(document).ready(function() {
    $('.book-btn').click(function() {
        var parkingNumber = $(this).data('parking-number');
        var bookingDate = $(this).data('date');

        $('#parkingNumber').val(parkingNumber);
        $('#bookingDate').val(bookingDate);
        $('#bookingModal').modal('show');
    });

    $('#confirmBookingBtn').click(function() {
        submitBookingForm();
    });
});

function formatStartTime(time) {
    var parts = time.split(':');
    var hours = parseInt(parts[0]);
    return (hours < 10 ? '0' : '') + hours + ':00:00';
}

function formatEndTime(time) {
    var parts = time.split(':');
    var hours = parseInt(parts[0]);
    return (hours < 10 ? '0' : '') + hours + ':59:59';
}