<?php
session_start();

require "../database/conn_db.php"; 

$booking_id = $_GET['booking_id'];

$sql = "SELECT b.*, v.* 
        FROM booking AS b
        LEFT JOIN vehicle AS v
        ON v.Student_id = b.Student_id
        WHERE b.Booking_id = :booking_id";

$stmt = $conn->prepare($sql);
$stmt->execute(['booking_id' => $booking_id]);

if ($stmt === false) {
    die("Error: " . $conn->errorInfo()[2]);
}

$booking = $stmt->fetch(PDO::FETCH_ASSOC);

$student_id = $booking['Student_id'];
$parking_number = $booking['Parking_number'];
$booking_date = $booking['Booking_date'];
$start_time_24 = date("H:i", strtotime($booking['Start_time'])); // 24-hour format for edit form
$end_time_24 = date("H:i", strtotime($booking['End_time'])); // 24-hour format for edit form
$start_time_12 = date("h:i A", strtotime($booking['Start_time'])); // 12-hour format for display
$end_time_12 = date("h:i A", strtotime($booking['End_time'])); // 12-hour format for display

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Reference</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
    <script defer src="../js/editform.js"></script>
</head>
<body>
    <div class="sidebar">
        <table>
            <tr><th>User Profile</th></tr>
            <tr><td><a href="">Content</a></td></tr>
            <tr><td><a href="">Content</a></td></tr>
            <tr><th>Parking Area</th></tr>
            <tr><td><a href="">Content</a></td></tr>
            <tr><td><a href="">Content</a></td></tr>
            <tr><th>Parking Booking</th></tr>
            <tr><td><a href="booking.php">Booking</a></td></tr>
            <tr><td><a href="view.php">View Booking</a></td></tr>
            <tr><th>Traffic Summon</th></tr>
            <tr><td><a href="">Content</a></td></tr>
            <tr><td><a href="">Content</a></td></tr>
            <tr><th><a href="">Log Out</a></th></tr>
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
            <h2>Booking Reference</h2>
            <form id="editForm" action="edit_update.php" method="POST" style="display: none;">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
            <input type="hidden" name="booking_date" value="<?php echo $booking_date; ?>">
            <input type="hidden" name="parking_number" value="<?php echo $parking_number; ?>">
                <div class="mb-3">
                    <label for="start_time" class="form-label"><strong>Start Time:</strong></label>
                    <input type="time" class="form-control" id="start_time" name="start_time" value="<?php echo $start_time_24; ?>">
                </div>
                <div class="mb-3">
                    <label for="end_time" class="form-label"><strong>End Time:</strong></label>
                    <input type="time" class="form-control" id="end_time" name="end_time" value="<?php echo $end_time_24; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
            <div id="displayInfo">
                <p><strong>Student ID:</strong> <?php echo $student_id; ?></p>
                <p><strong>Parking Number:</strong> <?php echo $parking_number; ?></p>
                <p><strong>Booking Date:</strong> <?php echo $booking_date; ?></p>
                <p><strong>Start Time:</strong> <?php echo $start_time_12; ?></p>
                <p><strong>End Time:</strong> <?php echo $end_time_12; ?></p>
                <button id="editButton" class="btn btn-primary">Edit</button>
                <a href="http://localhost/WebEngineering/ManageBooking/view.php" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</body>
</html>
