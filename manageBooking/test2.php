<?php
    date_default_timezone_set('Asia/Kuala_Lumpur');

    require "../database/conn_db.php";

    $filterDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    $filterTime = isset($_GET['time']) ? $_GET['time'] : date('g a');

    $sql = "SELECT parking.Parking_number AS parking_number, parking.Parking_area, booking.* 
            FROM parking 
            LEFT JOIN booking ON parking.Parking_number = booking.Parking_number 
            AND booking.Booking_date = '$filterDate' 
            AND STR_TO_DATE(booking.Start_time, '%l%p') <= STR_TO_DATE('$filterTime', '%l%p') 
            AND STR_TO_DATE(booking.End_time, '%l%p') >= STR_TO_DATE('$filterTime', '%l%p') 
            WHERE booking.Booking_id IS NULL 
            OR (booking.Booking_id IS NOT NULL 
            AND (STR_TO_DATE(booking.Start_time, '%l%p') > DATE_ADD(STR_TO_DATE('$filterTime', '%l%p'), INTERVAL 1 HOUR) 
            OR STR_TO_DATE(booking.End_time, '%l%p') < STR_TO_DATE('$filterTime', '%l%p'))) 
            ORDER BY parking.Parking_number";

    // Execute the query and handle errors
    $result = $mysqli->query($sql);
    if ($result === false) {
        echo "Error: " . $mysqli->error;
        exit;
    }

    $currentTime = date('g a');
    $endTimeLimit = date('g a', strtotime('+2 hours', strtotime($currentTime)));
    $updateSql = "UPDATE parking, booking 
                  SET parking.parking_status = 'booked' 
                  WHERE booking.bookingStatus = 'confirmed' 
                  AND STR_TO_DATE(booking.Start_time, '%l%p') <= STR_TO_DATE('$currentTime', '%l%p') 
                  AND STR_TO_DATE(booking.End_time, '%l%p') >= STR_TO_DATE('$endTimeLimit', '%l%p') 
                  AND parking.Parking_number = booking.Parking_number";

    if ($mysqli->query($updateSql) === false) {
        echo "Error: " . $mysqli->error;
        exit;
    }

    $mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Parking Booking</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
    <script defer src="../js/filter.js"></script>
</head>
<body>
    <div class="sidebar">
        <!-- Sidebar content here -->
    </div>

    <div class="topnav">
        <!-- Topnav content here -->
    </div>

    <div class="content">
        <div class="container mt-3"> 
            <h2>Student Parking Booking</h2>
            <br>
            <div class="filter">
                <img src="../image/filter.png" alt="filter icon" width="30px" height="30px"><b>  Filter</b>
            </div>
            <br>
            <div class="filter">
                <form action="" method="GET">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" value="<?php echo $filterDate; ?>">
                    <label for="time">Time:</label>
                    <select id="time" name="time" required>
                        <?php
                        $times = [
                            '12am', '1am', '2am', '3am', '4am', '5am', '6am', '7am', '8am', '9am', '10am', '11am',
                            '12pm', '1pm', '2pm', '3pm', '4pm', '5pm', '6pm', '7pm', '8pm', '9pm', '10pm', '11pm'
                        ];
                        foreach ($times as $time) {
                            $selected = ($time == $filterTime) ? 'selected' : '';
                            echo "<option value=\"$time\" $selected>$time</option>";
                        }
                        ?>
                    </select>
                    <button type="submit">Filter</button>
                </form>
            </div> 
            <br>
            <input type="text" class="form-control" placeholder="Search Here" id="txtInputTable"> 
            <br> 
            <table class="table table-bordered"> 
                <thead> 
                    <tr> 
                        <th>Parking Number</th> 
                        <th>Parking Area</th> 
                        <th>Action</th>
                    </tr> 
                </thead> 
                <tbody id="tableDetails"> 
                <?php 
                while ($rows = $result->fetch_assoc()) {
                    $buttonDisabled = '';
                    $buttonText = 'Book';
                    
                    if ($rows['Booking_id']) {
                        if (strtotime($filterTime) >= strtotime($rows['Start_time']) && strtotime($filterTime) <= strtotime($rows['End_time'])) {
                            $buttonDisabled = 'disabled'; 
                            $buttonText = 'Booked';
                        }
                    }
                ?>
                <tr>
                    <td><?php echo $rows['parking_number']; ?></td>
                    <td><?php echo $rows['Parking_area']; ?></td>
                    <td>
                        <button class="btn btn-primary book-btn" <?php echo $buttonDisabled; ?> data-parking-number="<?php echo $rows['parking_number']; ?>"><?php echo $buttonText; ?></button>
                    </td>
                </tr>
                <?php
                }
                ?>
                </tbody> 
            </table> 
        </div> 
    </div>

    <!-- Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Book Parking Spot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="bookingForm">
                    <div class="mb-3">
                        <label for="parkingNumber" class="form-label">Parking Number</label>
                        <input type="text" class="form-control" id="parkingNumber" name="parkingNumber" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="startTime" class="form-label">Start Time</label>
                        <select id="startTime" name="startTime" class="form-control" required>
                            <?php
                            foreach ($times as $time) {
                                echo "<option value=\"$time\">$time</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="endTime" class="form-label">End Time</label>
                        <select id="endTime" name="endTime" class="form-control" required>
                            <?php
                            foreach ($times as $time) {
                                echo "<option value=\"$time\">$time</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirm Booking</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
        var bookingForm = document.getElementById('bookingForm');

        document.querySelectorAll('.book-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                var parkingNumber = this.getAttribute('data-parking-number');
                document.getElementById('parkingNumber').value = parkingNumber;
                bookingModal.show();
            });
        });

        bookingForm.addEventListener('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(bookingForm);
            
            console.log("Submitting form with data:", Object.fromEntries(formData.entries())); // Debug form data

            fetch('booking_update.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log("Response status:", response.status); // Debug response status
                return response.json();
            })
            .then(data => {
                console.log("Response data:", data); // Debug response data
                if (data.success) {
                    alert(data.message);
                    bookingModal.hide();
                    location.reload(); // Optionally refresh the page
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
    </script>

</body>
</html>
