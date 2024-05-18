<?php
    date_default_timezone_set('Asia/Kuala_Lumpur');

    require "../database/conn_db.php";

    $filterDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    $filterTime = isset($_GET['time']) ? $_GET['time'] : date('H:i:s');

    $sql = "SELECT parking.Parking_number AS parking_number, parking.Parking_area, booking.* FROM parking 
    LEFT JOIN booking ON parking.Parking_number = booking.Parking_number 
    AND booking.Booking_date = '$filterDate' 
    AND booking.Start_time <= '$filterTime' 
    AND booking.End_time >= '$filterTime' 
    WHERE booking.Booking_id IS NULL 
    OR (booking.Booking_id IS NOT NULL AND (booking.Start_time > DATE_ADD('$filterTime', INTERVAL 1 HOUR) OR booking.End_time < '$filterTime')) 
    ORDER BY parking.Parking_number";
    $result = $mysqli->query($sql);

    $currentTime = date('H:i:s');
    $endTimeLimit = date('H:i:s', strtotime('+2 hours', strtotime($currentTime))); // Assuming 2 hours is the time limit for parking booking
    $updateSql = "UPDATE parking, booking 
    SET parking.parking_status = 'booked' 
    WHERE booking.bookingStatus = 'confirmed' 
    AND booking.start_time <= '$currentTime' 
    AND booking.end_time >= '$endTimeLimit' 
    AND parking.Parking_number = booking.Parking_number";
    $mysqli->query($updateSql);

    if ($result === false) {
        echo "Error: " . $mysqli->error;
    }

    $mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Parking Booking</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
    <script defer src="../js/filter.js"></script> 
</head>
<body>
    <div class="sidebar">
        <table>
            <tr>
                <th>User Profile</th>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <th>Parking Area</th>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <th>Parking Booking</th>
            </tr>
            <tr>
                <td><a href="booking.php">Booking</a></td>
            </tr>
            <tr>
                <td><a href="view.php">View Booking</a></td>
            </tr>
            <tr>
                <th>Traffic Summon</th>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <th><a href="">Log Out</a></th>
            </tr>
        </table>
    </div>

    <div class="topnav">
        <div id="menuBtn">&#9776;</div>
        <div class="logo">
            <img src="../image/umpsa_logo.png" alt="Logo" width="150" height="50">
        </div>
        <div class="search-bar">
            <form action="" method="">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><img src="../image/search.png" height="20px" width="20px"></button>
            </form>
        </div>
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#contact">Contact</a>
    </div>

    <div class="content">
        <div class="container mt-3"> 
            <h2>Student Parking Booking</h2>
            <br>
            <div class="filter"><img src="../image/filter.png" alt="filter icon" width="30px" height="30px"><b>  Filter</b></div> 
            <br>
            <div class="filter">
                <form action="" method="GET">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" value="<?php echo $filterDate; ?>">
                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time" value="<?php echo isset($_GET['time']) ? $_GET['time'] : date('H:i:s'); ?>">
                    <button type="submit">Filter</button>
                </form>
            </div> 
            <br>
            <input type="text" 
                class="form-control" 
                placeholder="Search Here"
                id="txtInputTable"> 
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
                // LOOP TILL END OF DATA
                while($rows = $result->fetch_assoc()) {
                    // Check if parking status is booked
                    $buttonDisabled = '';
                    $buttonText = 'Book';
                    
                    // If there is a booking for this parking slot
                    if ($rows['Booking_id']) {
                        // Check if the filtered time falls within the booked slot
                        if (strtotime($filterTime) >= strtotime($rows['Start_time']) && strtotime($filterTime) <= strtotime($rows['End_time'])) {
                            $buttonDisabled = 'disabled'; // Disable button if filtered time falls within booked slot
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
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to generate QR code
        function generateQRCode(text) {
            // Code to generate QR code (you need to implement this part)
            // You can use libraries like QRCode.js (https://davidshimjs.github.io/qrcodejs/)
            // Example usage:
            // new QRCode(document.getElementById("qrcode"), text);
        }

        // Add click event listener to all book buttons
        var bookButtons = document.querySelectorAll('.book-btn');
        bookButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                // Get the parking number
                var parkingNumber = this.getAttribute('data-parking-number');
                
                // Prompt user for confirmation with parking number
                var confirmBooking = confirm("Are you sure you want to book parking spot " + parkingNumber + "?");
                if (confirmBooking) {
                    // You can replace the alert with any other action you want to take after confirmation
                    alert("Booking confirmed for parking spot " + parkingNumber);
                    
                    // Generate QR code (replace 'yourText' with the data you want to encode)
                    var qrCodeText = "Parking Spot: " + parkingNumber; // Example text
                    generateQRCode(qrCodeText);
                }
            });
        });
    });
</script>

</body>
</html>
