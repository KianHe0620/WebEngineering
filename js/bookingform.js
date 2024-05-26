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
    var time = $('#startTime').val(); // Get the time from the start time input field
    
    var formattedStartTime = formatStartTime(time); // Format start time to HH:00:00
    var formattedEndTime = formatEndTime(time); // Format end time to (HH+1):00:00
    
    // Check for time clash
    checkTimeClash(parkingNumber, bookingDate, formattedStartTime, formattedEndTime);
}

function formatStartTime(time) {
    var hours = parseInt(time.split(':')[0]);
    var formattedStartTime = (hours < 10 ? '0' : '') + hours + ':00:00';
    return formattedStartTime;
}

function formatEndTime(time) {
    var hours = parseInt(time.split(':')[0]) + 1; // Increment hour by 1
    var formattedEndTime = (hours < 10 ? '0' : '') + hours + ':00:00';
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
                // Hide the modal
                $('#bookingModal').modal('hide'); 
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
