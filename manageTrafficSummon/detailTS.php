<?php
session_start();

require "../database/conn_db.php";

// Check if there is a message in the session and display it
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success' role='alert'>";
    echo $_SESSION['message'];
    echo "</div>";

    // Clear the message from the session
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Traffic Summon</title>
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
                <td><a href="detailTS.php">Detail Traffic Summon</a></td>
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
        <h2>Detail Traffic Summon</h2>
        <form class="d-flex mb-3">
            <input class="form-control me-2" type="search" placeholder="Search Summon ID/Student ID" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Summon ID</th>
                    <th>Unit Keselamatan ID</th>
                    <th>Student ID</th>
                    <th>Date</th>
                    <th>Type of Violation</th>
                    <th>Type of Enforcement</th>
                    <th>Demerit Points</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM trafficsummon";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['TSummon_id']}</td>
                            <td>{$row['UKStaff_id']}</td>
                            <td>{$row['Student_id']}</td>
                            <td>{$row['TSummon_date']}</td>
                            <td>{$row['Violation_type']}</td>
                            <td>{$row['Enforcement_type']}</td>
                            <td>{$row['Demerit_point']}</td>
                            <td>
                                <a href='updateTSedit.php?TSummon_id={$row['TSummon_id']}' class='btn btn-success'>Update</a>
                                <a href='viewTS.php?TSummon_id={$row['TSummon_id']}' class='btn btn-primary'>View</a>
                                <form action='deleteTS.php' method='POST' class='d-inline'>
                                    <input type='hidden' name='TSummon_id' value='{$row['TSummon_id']}'>
                                    <button type='submit' class='btn btn-danger'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
