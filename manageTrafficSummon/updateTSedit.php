<?php

include_once('../database/conn_db.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    // Retrieve and sanitize input data
    $TSummon_id = $conn->real_escape_string($_POST['TSummon_id']);
    $UKStaff_id = $conn->real_escape_string($_POST['UKStaff_id']);
    $Student_id = $conn->real_escape_string($_POST['Student_id']);
    $TSummon_date = $conn->real_escape_string($_POST['TSummon_date']);
    $Violation_type = $conn->real_escape_string($_POST['Violation_type']);
    $Enforcement_type = $conn->real_escape_string($_POST['Enforcement_type']);
    $Demerit_point = $conn->real_escape_string($_POST['Demerit_point']);

    // Prepare and bind parameters for the SQL UPDATE statement
    $stmt = $conn->prepare("UPDATE trafficsummon SET UKStaff_id=?, Student_id=?, TSummon_date=?, Violation_type=?, Enforcement_type=?, Demerit_point=? WHERE TSummon_id=?");
    $stmt->bind_param("ssssssi", $UKStaff_id, $Student_id, $TSummon_date, $Violation_type, $Enforcement_type, $Demerit_point, $TSummon_id);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "<script>alert('Traffic summon updated successfully');</script>";
        header('Location: detailTS.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
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
        <h2>Update Traffic Summon</h2>
        <p>Update the information below:</p>
        <form action="updateTSedit.php" method="POST">
            <div class="mb-3">
                <label for="TSummon_id" class="form-label">Summon ID: </label>
                <input type="text" class="form-control" id="TSummon_id" name="TSummon_id" required>
            </div>
            <div class="mb-3">
                <label for="UKStaff_id" class="form-label">Unit Keselamatan ID: </label>
                <input type="text" class="form-control" id="UKStaff_id" name="UKStaff_id" required>
            </div>
            <div class="mb-3">
                <label for="Student_id" class="form-label">Student ID: </label>
                <input type="text" class="form-control" id="Student_id" name="Student_id" required>
            </div>
            <div class="mb-3">
                <label for="TSummon_date" class="form-label">Date</label>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="date" name="selectedDate" class="date-picker">
            </form>
            </div>
            <div class="mb-3">
                <label for="Violation_type" class="form-label">Type of Violation: </label>
                <select class="form-control" id="Violation_type" name="Violation_type" required>
                    <option value="" disabled selected>Choose...</option>
                    <option value="Parking Violation">Parking Violation</option>
                    <option value="Not Complying with Campus Traffic Regulations">Not Complying with Campus Traffic Regulations</option>
                    <option value="Accident Caused">Accident Caused</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="Enforcement_type" class="form-label">Type of Enforcement: </label>
                <select class="form-control" id="Enforcement_type" name="Enforcement_type" required>
                    <option value="" disabled selected>Choose...</option>
                    <option value="Warning Given">Warning Given</option>
                    <option value="Revoke of in campus vehicle permission for 1 semester">Revoke of in campus vehicle permission for 1 semester</option>
                    <option value="Revoke of in campus vehicle permission for 2 semester">Revoke of in campus vehicle permission for 2 semester</option>
                    <option value="Revoke of in campus vehicle permission for the entire study duration">Revoke of in campus vehicle permission for the entire study duration</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="Demerit_point" class="form-label">Demerit Points: </label>
                <input type="text" class="form-control" id="Demerit_point" name="Demerit_point" required>
            </div>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='manageTrafficSummon.php'">Cancel</button>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</body>
</html>