<?php
session_start();

// if (!isset($_SESSION['student_id'])) {
//     header("Location: ../login/login.php");
//     exit();
// }

date_default_timezone_set('Asia/Kuala_Lumpur');

require "../database/conn_db.php";

// $student_id = $_SESSION['student_id'];
$student_id = "S001";

$sql = "SELECT * FROM booking
        WHERE Student_id = :student_id";

$stmt = $conn->prepare($sql);
$stmt->execute(['student_id' => $student_id]);

if ($stmt === false) {
    die("Error: " . $conn->errorInfo()[2]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
    <script defer src="../js/cancelBooking.js"></script>
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
            <h2>View Booking</h2>
            <br>
            <table class="table table-bordered"> 
                <thead> 
                    <tr> 
                        <th>Parking Number</th>
                        <th>Date</th> 
                        <th>Start_time</th> 
                        <th>End_time</th>
                        <th>Action</th>
                    </tr> 
                </thead> 
                <tbody id="tableDetails"> 
                <?php 
                if (!isset($stmt)) {
                        echo 'No record found.';
                    }
                while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $startTime = date("h:i A", strtotime($rows['Start_time']));
                    $endTime = date("h:i A", strtotime($rows['End_time']));
                ?>
                <tr>
                    <td><?php echo $rows['Parking_number']; ?></td>
                    <td><?php echo $rows['Booking_date']; ?></td>
                    <td><?php echo $startTime; ?></td>
                    <td><?php echo $endTime; ?></td>
                    <td>
                    <a href="reference.php?booking_id=<?php echo $rows['Booking_id']; ?>" class="btn btn-primary">View & Update</a>
                        <form class="cancel-booking-form">
                            <input type="hidden" name="booking_id" value="<?php echo $rows['Booking_id']; ?>">
                            <button type="button" class="btn btn-danger cancel-booking-btn" onclick="cancelBooking(this)">Cancel Booking</button>
                        </form>
                    </td>
                </tr>
                <?php
                }
                ?>
                </tbody> 
            </table> 
        </div>
    </div>
</body>
</html>
