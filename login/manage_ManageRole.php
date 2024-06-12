<?php
session_start();

// Include database connection file
include_once("../database/conn_db.php");

// Check if the login form is submitted
if (isset($_POST['submit'])) {
    // Escape user inputs to prevent SQL injection
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    
    // Query to select user based on email, password, and role
    $query = "SELECT * FROM $role WHERE username='$username' AND password='$password'";
    $result = mysqli_query($con, $query);
    
    // Check if a single row is returned, indicating successful login
    if ($result && mysqli_num_rows($result) == 1) {
        // Store user information in session variables
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        
        // Redirect user to the appropriate dashboard based on role
        switch ($role) {
            case 'admin':
                header("Location: admin_dashboard.php");
                exit();
            case 'unit_keselamatan':
                header("Location: unit_keselamatan_dashboard.php");
                exit();
            case 'student':
                header("Location: student_dashboard.php");
                exit();
            default:
                // Handle other roles or errors
                break;
        }
    } else {
        // Authentication failed, display error message
        echo "Invalid email or password.";
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
    <link rel="stylesheet" href="style.css">
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
                <td><a href="manage_profile.php">Manage Profile</a></td>
            </tr>
            <tr>
                <td><a href="manage_profilee.php">Manage Profilee</a></td>
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
                <th><a href="logout.php">Log Out</a></th>
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
        <div class="mainreg">
            <h1 class="register">MANAGE ROLE:</h1>
            <form class="sgform">
                <ul class="register">
                    <li><button class="unique-button"><a href="register_admin.php">Administrator</a></button></li>
                    <li><button class="unique-button"><a href="register_student.php">Student</a></button></li>
                    <li><button class="unique-button"><a href="register_staff.php">Unit Keselamatan Staff</a></button></li>
                </ul>
            </form>  
        </div>
    </div>
</body>
</html>