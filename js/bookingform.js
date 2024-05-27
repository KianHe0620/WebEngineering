$(document).ready(function() {
    // Handle click on "Book" button
    $('.book-btn').click(function() {
        var parkingNumber = $(this).data('parking-number');
        var bookingDate = $(this).data('date');
        
        // Set values in modal
        $('#parkingNumber').val(parkingNumber);
        $('#bookingDate').val(bookingDate);
        
        // Open modal
        $('#bookingModal').modal('show');
    });

    // Handle click on "Confirm Booking" button
    $('#confirmBookingBtn').click(function() {
        submitBookingForm();
    });
});

function submitBookingForm() {
    var parkingNumber = $('#parkingNumber').val();
    var bookingDate = $('#bookingDate').val();
    var stime = $('#startTime').val(); // Get the time from the start time input field
    var etime = $('#endTime').val(); // Get the time from the end time input field

    var formattedStartTime = formatStartTime(stime); // Format start time to HH:00:00
    var formattedEndTime = formatEndTime(etime); // Format end time based on the specified condition
    
    checkTimeClash(parkingNumber, bookingDate, formattedStartTime, formattedEndTime);
}

function formatStartTime(time) {
    var parts = time.split(':');
    var hours = parseInt(parts[0]);
    var formattedStartTime = (hours < 10 ? '0' : '') + hours + ':00:00';
    return formattedStartTime;
}

function formatEndTime(time) {
    var parts = time.split(':');
    var hours = parseInt(parts[0]);
    var formattedEndTime = (hours < 10 ? '0' : '') + hours + ':59:59';
    return formattedEndTime;
}

function checkTimeClash(parkingNumber, bookingDate, startTime, endTime) {
    $.ajax({
        url: 'booking_update.php',
        type: 'POST',
        dataType: 'json',
        data: {
            parkingNumber: parkingNumber,
            bookingDate: bookingDate,
            startTime: startTime,
            endTime: endTime
        },
        success: function(response) {
            if (response.success) {
                // Booking successful, display success message or redirect
                alert(response.message);
                $('#bookingModal').modal('hide'); 
                location.reload(true);
            } else {
                // Booking failed due to time clash, display error message
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
        }
    });
}
