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


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch parking record by ID
    $stmt = $conn->prepare("SELECT * FROM parking WHERE Parking_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $parking = $result->fetch_assoc();
    } else {
        echo "No record found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Parking Details - FKPark</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Parking Details</h2>
    <p><strong>Parking Area:</strong> <?php echo htmlspecialchars($parking['Parking_area']); ?></p>
    <p><strong>Parking Number:</strong> <?php echo htmlspecialchars($parking['Parking_number']); ?></p>
    <p><strong>Parking Status:</strong> <?php echo htmlspecialchars($parking['Parking_status']); ?></p>
    <p><strong>Vehicle Type:</strong> <?php echo htmlspecialchars($parking['vehicle_type']); ?></p>
    <p><strong>Parking Date:</strong> <?php echo htmlspecialchars($parking['parking_date']); ?></p>
    <p><strong>QR Code:</strong> <img src="data:image/png;base64,<?php echo base64_encode($parking['qrImage']); ?>" alt="QR Code"></p>
    <a href="viewparking.php" class="btn btn-primary">Back to List</a>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
