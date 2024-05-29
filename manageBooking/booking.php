<?php
session_start();

//Check if user is not logged in, redirect to login page
// if (!isset($_SESSION['student_id'])) {
//     header("Location: ../login/login.php");
//     exit();
// }

date_default_timezone_set('Asia/Kuala_Lumpur');

require "../database/conn_db.php";

$filterDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$filterTime = isset($_GET['time']) ? $_GET['time'] : date('H:i:s');

$sql = "SELECT parking.Parking_number AS parking_number, parking.Parking_area, booking.* 
        FROM parking 
        LEFT JOIN booking 
        ON parking.Parking_number = booking.Parking_number 
        AND booking.Booking_date = :filterDate 
        AND booking.Start_time <= :filterTime 
        AND booking.End_time >= :filterTime 
        WHERE booking.Booking_id IS NULL 
        OR (booking.Booking_id IS NOT NULL 
        AND (booking.Start_time > :filterTime 
        OR booking.End_time < :filterTime)) 
        ORDER BY parking.Parking_number";

$stmt = $conn->prepare($sql);
$stmt->execute(['filterDate' => $filterDate, 'filterTime' => $filterTime]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Parking Booking</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
    <script defer src="../js/filter.js"></script> 
    <script defer src="../js/bookingform.js"></script>
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
            <div class="filter">
                <img src="../image/filter.png" alt="filter icon" width="30px" height="30px"><b>  Filter</b>
            </div>
            <br>
            <div class="filter">
            <form method="GET">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo $filterDate; ?>" min="<?php echo date('Y-m-d'); ?>">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" value="<?php echo $filterTime; ?>" required>
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
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php echo $rows['parking_number']; ?></td>
                    <td><?php echo $rows['Parking_area']; ?></td>
                    <td>
                        <button class="btn btn-primary book-btn" data-parking-number="<?php echo $rows['parking_number']; ?>" data-date="<?php echo $filterDate; ?>">Book</button>
                    </td>
                </tr>
                <?php
                }
                ?>
                </tbody> 
            </table> 
        </div> 
    </div>

    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Book Parking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookingForm">
                        <div class="mb-3">
                            <label for="parkingNumber" class="form-label">Parking Number</label>
                            <input type="text" class="form-control" id="parkingNumber" name="parkingNumber" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="bookingDate" class="form-label">Date</label>
                            <input type="text" class="form-control" id="bookingDate" name="bookingDate" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="startTime" class="form-label">Start Time (Time will auto formatted like eg)<br>eg: 7:34am => 7:00am</label>
                            <input type="time" class="form-control" id="startTime" name="startTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="endTime" class="form-label">End Time (Time will auto formatted like eg)<br>eg: 8:34am => 8:59am</label>
                            <input type="time" class="form-control" id="endTime" name="endTime" required>
                        </div>
                        <button id="confirmBookingBtn" type="button" class="btn btn-primary">Confirm Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
