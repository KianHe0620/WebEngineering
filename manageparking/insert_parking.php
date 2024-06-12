<?php
session_start();
$user = 'root';
$password = '';
$database = 'myparking';
$servername = 'localhost';

// Create connection
$conn = new mysqli($servername, $user, $password, $database, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['createparking'])) {
    $parking_area = $_POST['Parking_area'];
    $parking_number = $_POST['Parking_number'];
    $parking_status = $_POST['Parking_status'];
    $vehicle_type = $_POST['vehicle_type'];
    $parking_date = $_POST['parking_date'];
    $qrImage = $_POST['qrImage']; // This is the QR code data URL

    // Convert the data URL to binary data
    $qrImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrImage));

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO parking (Parking_area, Parking_number, Parking_status, vehicle_type, parking_date, qrImage) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssb", $parking_area, $parking_number, $parking_status, $vehicle_type, $parking_date, $null);

    // Bind the binary data (BLOB)
    $stmt->send_long_data(5, $qrImageData);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
                alert('New parking record created successfully');
                window.location.href = 'viewparking.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>