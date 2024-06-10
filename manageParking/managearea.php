<?php
    require "../database/conn_db.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Side and Top Navigation</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script> 
    <style>
        input[type="text"], input[type="date"], input[type="time"]{
        width: 30%;
        border-radius: 4px;
      }
    </style>
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
        <h2>Manage Parking Area</h2>
        <p>Choose area and fill in the correct information:</p>
        <form>
            <div class="col-auto">
            <label for="Parking_area" class="form-label">Parking Area: </label>
                <select class="form-select" id="Parking_area" name="Parking_area">
                    <option value="choose">choose...</option>
                    <option value="A1">A1</option>
                    <option value="A2">A2</option>
                    <option value="A3">A3</option>
                    <option value="B1">B1</option>
                    <option value="B2">B2</option>
                </select>
            </div>
            <div class="mb-7">
                <label for="date_from" class="form-label">Date from: </label>
                <input type="date" class="form-control" id="date_from">
            </div>
            <div class="mb-7">
            <label for="date_until" class="form-label">Date until: </label>
                <input type="date" class="form-control" id="date_until">
            </div>
            <div class="mb-7">
    <label for="start_time" class="form-label">Start time:</label>
    <input type="time" class="form-control" id="start_time" step="1800">
    <!-- step="1800" means intervals of 30 minutes (30 * 60 = 1800 seconds) -->
</div>
<div class="mb-7">
    <label for="end_time" class="form-label">End time:</label>
    <input type="time" class="form-control" id="end_time" step="1800">
</div>

            <div class="mb-7">
                <label for="ereason" class="form-label">Event/Reason: </label>
                <input type="text" class="form-control" id="ereason"><br>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        </div>
    </div>
</body>
</html>