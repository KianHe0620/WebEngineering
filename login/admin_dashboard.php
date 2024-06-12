<?php
<<<<<<< HEAD
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

=======

session_start();

//Check if user is not logged in, redirect to login page
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: ../login/login.php");
//     exit();
// }

require "./database/conn_db.php";

//$admin_id = $_SESSION['admin_id'];
$admin_id = "1";

$sql = "SELECT * FROM administrator
        WHERE Admin_id = :admin_id";

$stmt = $conn->prepare($sql);
$stmt->execute(['admin_id' => $admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Store the admin's name in the session
$_SESSION['admin_name'] = $admin['Admin_name'];

?>
>>>>>>> 5644ad18460be2edeb0c20204f595ae57aff9396
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Side and Top Navigation</title>
<<<<<<< HEAD
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="style.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
=======
    <link rel="stylesheet" href="./node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="./css/styles.css">
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="./node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="./js/opensidebar.js"></script> 
>>>>>>> 5644ad18460be2edeb0c20204f595ae57aff9396
</head>
<body>
    <div class="sidebar">
        <table>
            <tr>
                <th>User Profile</th>
            </tr>
            <tr>
                <td>
                    <!-- Dropdown for Manage Profile -->
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Profile
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="manage_admin_profile.php">Administrator</a></li>
                            <li><a class="dropdown-item" href="manage_student_profile.php">Student</a></li>
                            <li><a class="dropdown-item" href="manage_staff_profile.php">Unit Keselamatan Staff</a></li>
                        </ul>
                    </div>
                </td>
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
<<<<<<< HEAD
                <td><a href="../manageBooking/booking.php">Booking</a></td>
            </tr>
            <tr>
                <td><a href="../manageBooking/view.php">View Booking</a></td>
=======
                <td><a href="./manageBooking/view.php">View Booking</a></td>
>>>>>>> 5644ad18460be2edeb0c20204f595ae57aff9396
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
<<<<<<< HEAD
            <img src="../image/umpsa_logo.png" alt="Logo" width="150" height="50">
=======
            <a href="admin_side.php"><img src="./image/umpsa_logo.png" alt="Logo" width="150" height="50"></a>
>>>>>>> 5644ad18460be2edeb0c20204f595ae57aff9396
        </div>
        <div class="search-bar">
            <form action="" method="">
                <input type="text" placeholder="Search.." name="search">
<<<<<<< HEAD
                <button type="submit"><img src="../image/search.png" height="20px" width="20px"></button>
=======
                <button type="submit"><img src="./image/search.png" height="20px" width="20px"></button>
>>>>>>> 5644ad18460be2edeb0c20204f595ae57aff9396
            </form>
        </div>
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#contact">Contact</a>
    </div>

    <div class="content">
        <h2>Dashboard</h2>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                                    User</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">40</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1 text-center">
                                    Total Booking</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">21</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-fail text-uppercase mb-1 text-center">
                                    Available Parking</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">10</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
