<?php
include "../database/conn_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parkingArea = $_POST['Parking_area'];
    $dateFrom = $_POST['date_from'];
    $dateUntil = $_POST['date_until'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $parkingStatus = $_POST['Parking_status'];
    $eventReason = $_POST['event_reason'];

    try {
        // Prepare an SQL statement to insert the form data into the database
        $sql = "INSERT INTO parking (Parking_area, date_from, date_until, start_time, end_time, Parking_status, event_reason) 
        VALUES (:Parking_area, :date_from, :date_until, :start_time, :end_time, :Parking_status, :event_reason)";

        $stmt = $conn->prepare($sql);

        // Bind the parameters to the SQL query
        $stmt->bindParam(':Parking_area', $parkingArea);
        $stmt->bindParam(':date_from', $dateFrom);
        $stmt->bindParam(':date_until', $dateUntil);
        $stmt->bindParam(':start_time', $startTime);
        $stmt->bindParam(':end_time', $endTime);
        $stmt->bindParam(':Parking_status', $parkingStatus);
        $stmt->bindParam(':event_reason', $eventReason);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to a confirmation page or display a success message
            echo "New parking area managed successfully!";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Parking Area - FKPark</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
    <style>
        input[type="text"], input[type="date"], input[type="time"], select {
            width: 30%;
            border-radius: 4px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timeInputs = document.querySelectorAll('input[type="time"]');

            timeInputs.forEach(input => {
                // Restricting minutes to 00 or 30
                input.addEventListener('input', function(event) {
                    let [hours, minutes] = event.target.value.split(':');
                    if (minutes !== '00' && minutes !== '30') {
                        // Automatically set minutes to closest valid value
                        minutes = (minutes < 15 || minutes > 45) ? '00' : '30';
                        event.target.value = `${hours}:${minutes}`;
                    }
                });

                // On focus, restrict minute values
                input.addEventListener('focus', function(event) {
                    let val = event.target.value;
                    if (!val) {
                        let now = new Date();
                        let hours = now.getHours().toString().padStart(2, '0');
                        let minutes = (now.getMinutes() < 30) ? '00' : '30';
                        event.target.value = `${hours}:${minutes}`;
                    }
                }

                // Initialize with a valid value if empty
                if (!input.value) {
                    let now = new Date();
                    let hours = now.getHours().toString().padStart(2, '0');
                    let minutes = (now.getMinutes() < 30) ? '00' : '30';
                    input.value = `${hours}:${minutes}`;
                }
            });

            // Form submission event listener
            document.querySelector('form').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting immediately

                // Gather form data
                const parkingArea = document.getElementById('Parking_area').value;
                const dateFrom = document.getElementById('date_from').value;
                const dateUntil = document.getElementById('date_until').value;
                const startTime = document.getElementById('start_time').value;
                const endTime = document.getElementById('end_time').value;
                const parkingStatus = document.getElementById('Parking_status').value;
                const eventReason = document.getElementById('ereason').value;

                // Create the confirmation message
                const confirmationMessage = `
                    Please confirm the details below:\n
                    Parking Area: ${parkingArea}\n
                    Date From: ${dateFrom}\n
                    Date Until: ${dateUntil}\n
                    Start Time: ${startTime}\n
                    End Time: ${endTime}\n
                    Parking Status: ${parkingStatus}\n
                    Event/Reason: ${eventReason}\n
                `;

                // Show the confirmation dialog
                if (confirm(confirmationMessage)) {
                    // If the user confirms, submit the form
                    this.submit();
                }
            });
        });
    </script>
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
            <td><a href="managearea.php">Manage Area</a></td>
        </tr>
        <tr>
            <td><a href="admindashboard.php">Dashboard</a></td>
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
    <form method="POST" action="viewarea.php">
        <div class="col-auto">
            <label for="Parking_area" class="form-label">Parking Area:</label>
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
            <label for="date_from" class="form-label">Date from:</label>
            <input type="date" class="form-control" id="date_from" name="date_from">
        </div>
        <div class="mb-7">
            <label for="date_until" class="form-label">Date until:</label>
            <input type="date" class="form-control" id="date_until" name="date_until">
        </div>
        <div class="mb-7">
            <label for="start_time" class="form-label">Start time:</label>
            <input type="time" class="form-control" id="start_time" name="start_time" step="1800" pattern="(?:[01]\d|2[0-3]):(?:00|30)">
        </div>
        <div class="mb-7">
            <label for="end_time" class="form-label">End time:</label>
            <input type="time" class="form-control" id="end_time" name="end_time" step="1800" pattern="(?:[01]\d|2[0-3]):(?:00|30)">
        </div>
        <div class="mb-7">
            <label for="Parking_status" class="form-label">Parking Status:</label>
            <select class="form-select" id="Parking_status" name="Parking_status">
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>
        <div class="mb-7">
            <label for="ereason" class="form-label">Event/Reason:</label>
            <input type="text" class="form-control" id="ereason" name="ereason">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
</body>
</html>
