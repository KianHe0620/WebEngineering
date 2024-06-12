<?php

include_once('../database/conn_db.php');

// Fetch summary data
$sql_total_summons = "SELECT COUNT(*) as total FROM trafficsummon";
$result_total_summons = $conn->query($sql_total_summons);
$total_summons = $result_total_summons->fetch_assoc()['total'];

$sql_violations = "SELECT Violation_type, COUNT(*) as count FROM trafficsummon GROUP BY Violation_type";
$result_violations = $conn->query($sql_violations);

$sql_enforcements = "SELECT Enforcement_type, COUNT(*) as count FROM trafficsummon GROUP BY Enforcement_type";
$result_enforcements = $conn->query($sql_enforcements);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Keselamatan Dashboard</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
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
                <td><a href="viewparking.php">View Parking</a></td>
            </tr>
            <tr>
                <td><a href="managearea.php">Manage Area</a></td>
            </tr>
            <tr>
                <th>Parking Booking</th>
            </tr>
            <tr>
                <td><a href="../manageBooking/booking.php">Booking</a></td>
            </tr>
            <tr>
                <td><a href="../manageBooking/view.php">View Booking</a></td>
            </tr>
            <tr>
                <th>Traffic Summon</th>
            </tr>
            <tr>
                <td><a href="addnewTS2.php">Add New Traffic Summon</a></td>
            </tr>
            <tr>
                <td><a href="updateTSedit.php">Update Traffic Summon</a></td>
            </tr>
            <tr>
                <td><a href="deleteTS.php">Delete Traffic Summon</a></td>
            </tr>
            <tr>
                <td><a href="recordTS.php">Record Traffic Summon</a></td>
            </tr>
            <tr>
                <td><a href="viewTS.php">View Traffic Summon</a></td>
            </tr>
            <tr>
                <td><a href="dashboard.php">Dashboard</a></td>
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
        <h2>Unit Keselamatan Dashboard</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Summons Issued</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_summons; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Violations by Type</div>
                    <div class="card-body">
                        <?php while($row = $result_violations->fetch_assoc()): ?>
                            <p class="card-text"><?php echo $row['Violation_type']; ?>: <?php echo $row['count']; ?></p>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Enforcements by Type</div>
                    <div class="card-body">
                        <?php while($row = $result_enforcements->fetch_assoc()): ?>
                            <p class="card-text"><?php echo $row['Enforcement_type']; ?>: <?php echo $row['count']; ?></p>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
