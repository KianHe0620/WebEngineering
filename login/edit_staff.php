<?php
session_start();
require '../database/conn_db.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])|| !isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch the logged-in user's profile information from the database
$sql = "SELECT * FROM staff WHERE username=?";
$stmt = $mysqli->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $staff = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $mysqli->error;
    exit(); // Stop further execution
}

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $ic = $_POST['ic'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Update staff information in the database
    $update_sql = "UPDATE staff SET Staff_name=?, Staff_IC=?, Staff_phoneNum=?, Staff_email=? WHERE username=?";
    $update_stmt = $mysqli->prepare($update_sql);
    if ($update_stmt) {
        $update_stmt->bind_param("sssss", $name, $ic, $phone, $email, $username);
        if ($update_stmt->execute()) {
            echo "Profile updated successfully!";
            // Optionally, you can redirect the user back to their dashboard
            // header("Location: dashboard.php");
            // exit();
        } else {
            echo "Error: " . $update_stmt->error;
        }
        $update_stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="style.css"> 
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
</head>
<body class="editProfile">
    <div class="sidebar">
        <table>
            <tr>
                <th>User Profile</th>
            </tr>
            <tr>
                <td><a href="edit_profile.php">Manage Profile</a></td>
            </tr>
            <tr>
                <td>
                    <!-- Register Vehicles -->
                    <a href="manage_vehicle.php">Register Vehicle</a>
                </td>
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
        <div id="editProfile" class="edit-profile">
            <img src="../image/avatar.png" alt="Logo" width="150" height="150">
            <h1>Edit Profile</h1>
            <form action="edit_profile.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $staff['Staff_name']; ?>">
                <br><br>
                <label for="ic">IC:</label>
                <input type="text" id="ic" name="ic" value="<?php echo $staff['Staff_IC']; ?>">
                <br><br>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $staff['Staff_phoneNum']; ?>">
                <br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $staff['Staff_email']; ?>">
                <br><br>
                <input type="submit" name="update" value="Update Profile">
            </form>
        </div>
    </div>
</body>
</html>
