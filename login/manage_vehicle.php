<?php
require '../database/conn_db.php'; // Database connection file
require '../vendor/autoload.php'; // Composer autoload file for Endroid QR Code library

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;

// Function to generate QR code
function generateQRCode($data) {
    // Ensure the QR codes directory exists
    if (!is_dir('qrcodes')) {
        mkdir('qrcodes', 0777, true);
    }

    // Define the output file path
    $filePath = 'qrcodes/' . uniqid() . '.png';

    // Build the QR code
    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($data)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(ErrorCorrectionLevel::Q) // Specify a different error correction level
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->build();

    // Save the QR code to a file
    $result->saveToFile($filePath);

    // Return the file path
    return $filePath;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are set
    if (isset($_POST['vehicle_platenum'], $_POST['vehicle_type'], $_POST['student_id'])) {
        // Retrieve form data
        $vehiclePlateNum = $_POST['vehicle_platenum'];
        $vehicleType = $_POST['vehicle_type'];
        $studentID = $_POST['student_id'];

        // Insert data into database
        $sql = "INSERT INTO vehicle (Vehicle_platenum, Vehicle_type, Student_id) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $vehiclePlateNum, $vehicleType, $studentID);
            if ($stmt->execute()) {
                // Generate QR code
                $qrCodeData = "Vehicle Plate Num: $vehiclePlateNum\nVehicle Type: $vehicleType\nOwner: $studentID";
                $qrCodeURL = generateQRCode($qrCodeData);
        
                // Display QR code
                echo "<img src='$qrCodeURL' alt='QR Code'>";
                echo "<p>Vehicle registered successfully!</p>";        
            } else {
                if ($stmt->errno == 1062) { // Duplicate entry error code
                    echo "Error: Vehicle with plate number $vehiclePlateNum already exists.";
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
    } else {
        echo "Form fields are not set.";
    }
    mysqli_close($mysqli);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vehicle</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="style.css"> <!-- Link to the external style.css file -->
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
</head>
<body class="ManageVehicle">
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

    <div class="vehicleRegister">
        <div class="content">
            <h2>Register Vehicle</h2>
            <img src="../image/carRegister.jpg" height="200px" width="300px">
            <h4>Fill in your vehicle details</h4>
            <br>
            <form id="vehicle-register-form" action="manage_vehicle.php" method="post">
                <div class="form-group">
                    <label for="vehicle_platenum">Vehicle Plate Number:</label>
                    <input type="text" id="vehicle_platenum" name="vehicle_platenum" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="vehicle_type">Vehicle Type:</label>
                    <input type="text" id="vehicle_type" name="vehicle_type" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" required>
                </div>
                <br>
                <input type="submit" value="Register">
            </form>
        </div>
    </div>
</body>
</html>
