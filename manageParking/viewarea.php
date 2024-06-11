<?php
// Include database connection
include "../database/conn_db.php";

// Fetch data from the database
$sql = "SELECT * FROM parking";
$stmt = $conn->prepare($sql);
$stmt->execute();
$parkingAreas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Parking - FKPark</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
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
                <td><a href="addparking.php">Add Parking</a></td>
            </tr>
            <tr>
                <td><a href="managearea.php">Manage Area</a></td>
            </tr>
            <tr>
                <td><a href="admindashboard.php">Dashboard</a></td>
            </tr>
            <tr>
                <th>Parking Booking</th>
            </tr>
            <tr>
                <td><a href="/manageBooking/booking.php">Booking</a></td>
            </tr>
            <tr>
                <td><a href="/manageBooking/view.php">View Booking</a></td>
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
            <form action="addparking.php" method="GET">
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
    <h2>View Parking Areas</h2>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Parking Area</th>
            <th scope="col">Date From</th>
            <th scope="col">Date Until</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
            <th scope="col">Parking Status</th>
            <th scope="col">Event/Reason</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($parkingAreas as $area): ?>
            <tr>
                <td><?= $area['Parking_area'] ?></td>
                <td><?= $area['date_from'] ?></td>
                <td><?= $area['date_until'] ?></td>
                <td><?= $area['start_time'] ?></td>
                <td><?= $area['end_time'] ?></td>
                <td><?= $area['Parking_status'] ?></td>
                <td><?= $area['event_reason'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
