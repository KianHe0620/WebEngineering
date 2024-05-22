<?php
    include_once('../database/conn_db.php');
    
    if(isset($_POST['save']))
    {
        $Parking_area=$_POST['Parking_area'];
        $Parking_number=$_POST['Parking_number'];
    
        $sql   ="INSERT INTO `Parking`(`Parking_area`, `Parking_number`) VALUES ('$Parking_area','$Parking_number')";
        $result=mysqli_query($conn,$sql);
        if($result){ 
        header('location:managearea.php');
        echo"<script>alert('New Parking Register Success');</script>";   
        }else{
            die(mysqli_error($conn)) ;
        }
       
    }
    
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
        <h2>Add New Parking Area</h2>
        <p>Fill in the information below:</p>
        <form action="/action_page.php">
            <div class="mb-3">
                <label for="Parking_area" class="form-label">Area: </label>
                <input type="text" class="form-control" id="Parking_area">
            </div>
            <div class="mb-3">
                <label for="Parking_number" class="form-label">Parking Number: </label>
                <input type="text" class="form-control" id="Parking_number">
            </div>
            <button type="submit" value="Save" name="save"class="btn btn-primary">Save and Generate QR</button>
        </form>
    </div>
</body>
</html>
