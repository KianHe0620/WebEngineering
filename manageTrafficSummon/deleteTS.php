<?php
include_once('../database/conn_db.php');

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM trafficsummon WHERE TSummon_id = '$delete_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Traffic Summon deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting Traffic Summon');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Side and Top Navigation</title>
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
                <td><a href="addnewTS.php">Add New Traffic Summon</a></td>
            </tr>
            <tr>
                <td><a href="updateTS.php">Update Traffic Summon</a></td>
            </tr>
            <tr>
                <td><a href="deleteTS.php">Delete Traffic Summon</a></td>
            </tr>
            <tr>
                <td><a href="recordTS.php">Record Traffic Summon</a></td>
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
        <h2>Record Traffic Summon</h2>
        
        <!-- Search Box -->
        <form class="d-flex mb-3">
            <input class="form-control me-2" type="search" placeholder="Search Summon ID" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        
        <!-- Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Summon ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Type of Violation</th>
                    <th scope="col">Type of Enforcement</th>
                    <th scope="col">Demerit Point</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['search_summon_id'])) {
                    $search_summon_id = $_POST['search_summon_id'];
                    $sql = "SELECT * FROM trafficsummon WHERE TSummon_id = '$search_summon_id'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td>{$row['TSummon_id']}</td>
                                <td>{$row['date']}</td>
                                <td>{$row['Violation_type']}</td>
                                <td>{$row['Enforcement_type']}</td>
                                <td>{$row['Demerit_point']}</td>
                                <td>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='delete_id' value='{$row['TSummon_id']}'>
                                        <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr>
                            <td colspan='6'>No results found for Summon ID: $search_summon_id</td>
                        </tr>";
                    }
                } else {
                    echo "<tr>
                        <td colspan='6'>Enter a Summon ID to search and delete</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
