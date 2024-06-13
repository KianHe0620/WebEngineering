<?php

include_once('../database/conn_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['createtrafficsummon'])) {
    $TSummon_id = $_POST['TSummon_id'];
    $UKStaff_id = $_POST['UKStaff_id'];
    $Student_id = $_POST['Student_id'];
    $TSummon_date = $_POST['TSummon_date'];
    $Violation_type = $_POST['Violation_type'];
    $Enforcement_type = $_POST['Enforcement_type'];
    $Demerit_point = $_POST['Demerit_point'];

    // Check if a traffic summon already exists for the same student and date
    $sql_check = "SELECT * FROM trafficsummon WHERE Student_id = ? AND TSummon_date = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $Student_id, $TSummon_date);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Error: A traffic summon already exists for this student on this date.";
    } else {
        // Insert data into database
        $sql = "INSERT INTO trafficsummon (TSummon_id, UKStaff_id, Student_id, TSummon_date, Violation_type, Enforcement_type, Demerit_point) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $TSummon_id, $UKStaff_id, $Student_id, $TSummon_date, $Violation_type, $Enforcement_type, $Demerit_point);
        
        if ($stmt->execute()) {
            // Redirect to viewTS.php after successful insertion
            header("Location: viewTS.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Traffic Summon</title>
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
                <td><a href="detailTS.php">Record Traffic Summon</a></td>
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
        <h2>Add New Traffic Summon</h2>
        <p>Fill in the information below:</p>
        <form action="addnewTS.php" method="POST">
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
                <input type="date" class="form-control" id="TSummon_date" name="TSummon_date" required>
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
                <input type="number" class="form-control" id="Demerit_point" name="Demerit_point" required>
            </div>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='viewTS.php'">Cancel</button>
            <button type="submit" value="Add" name="add" class="btn btn-primary" onclick="window.location.href='detailTS.php'">Add</button>
        </form>
    </div>
</body>
</html>
