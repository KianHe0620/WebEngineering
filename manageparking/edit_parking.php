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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editparking'])) {
    $parking_area = $_POST['Parking_area'];
    $parking_number = $_POST['Parking_number'];
    $parking_status = $_POST['Parking_status'];
    $vehicle_type = $_POST['vehicle_type'];
    $parking_date = $_POST['parking_date'];
    $qrImage = $_POST['qrImage'];

    // Convert the data URL to binary data
    $qrImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrImage));

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE parking SET Parking_area = ?, Parking_number = ?, Parking_status = ?, vehicle_type = ?, parking_date = ?, qrImage = ? WHERE Parking_id = ?");
    $stmt->bind_param("sssssbi", $parking_area, $parking_number, $parking_status, $vehicle_type, $parking_date, $null, $id);

    // Bind the binary data (BLOB)
    $stmt->send_long_data(5, $qrImageData);
    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
                alert('Parking record updated successfully');
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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parking Details - FKPark</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Parking Details</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="Parking_area" class="form-label">Parking Area:</label>
            <select class="form-select" id="Parking_area" name="Parking_area" required>
                <option value="choose">choose...</option>
                <option value="A1" <?php echo ($parking['Parking_area'] == 'A1') ? 'selected' : ''; ?>>A1</option>
                <option value="A2" <?php echo ($parking['Parking_area'] == 'A2') ? 'selected' : ''; ?>>A2</option>
                <option value="A3" <?php echo ($parking['Parking_area'] == 'A3') ? 'selected' : ''; ?>>A3</option>
                <option value="B1" <?php echo ($parking['Parking_area'] == 'B1') ? 'selected' : ''; ?>>B1</option>
                <option value="B2" <?php echo ($parking['Parking_area'] == 'B2') ? 'selected' : ''; ?>>B2</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="Parking_number" class="form-label">Parking Number:</label>
            <input type="text" class="form-control" id="Parking_number" name="Parking_number" value="<?php echo htmlspecialchars($parking['Parking_number']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="Parking_status" class="form-label">Parking Status:</label>
            <select class="form-select" id="Parking_status" name="Parking_status" required>
                <option value="available" <?php echo ($parking['Parking_status'] == 'available') ? 'selected' : ''; ?>>Available</option>
                <option value="unavailable" <?php echo ($parking['Parking_status'] == 'unavailable') ? 'selected' : ''; ?>>Unavailable</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="vehicle_type" class="form-label">Vehicle Type:</label>
            <select class="form-select" id="vehicle_type" name="vehicle_type" required>
                <option value="Car" <?php echo ($parking['vehicle_type'] == 'Car') ? 'selected' : ''; ?>>Car</option>
                <option value="Motorcycle" <?php echo ($parking['vehicle_type'] == 'Motorcycle') ? 'selected' : ''; ?>>Motorcycle</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="parking_date" class="form-label">Update Date:</label>
            <input type="datetime-local" class="form-control" id="parking_date" name="parking_date" value="<?php echo date('Y-m-d\TH:i', strtotime($parking['parking_date'])); ?>" required>
        </div>
        <input type="hidden" id="qrImage" name="qrImage">
        <div class="mb-3">
            <button type="button" id="generateQrBtn" class="btn btn-primary">Generate QR Code</button>
        </div>
        <div class="qr-code" id="qrCodeContainer"></div>
        <div class="mb-3">
            <button type="button" id="viewQRBtn" class="btn btn-primary" style="display: none;">View QR Code</button>
        </div>
        <div class="mb-3">
            <button type="submit" name="editparking" value="Save" class="btn btn-primary">Update Parking</button>
        </div>
    </form>
    <a href="viewparking.php" class="btn btn-secondary">Cancel</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
<script>
document.getElementById('generateQrBtn').addEventListener('click', function() {
    var parkingArea = document.getElementById('Parking_area').value;
    var parkingNumber = document.getElementById('Parking_number').value;
    var vehicleType = document.getElementById('vehicle_type').value;
    var parkingDate = document.getElementById('parking_date').value;
    var parkingStatus = document.getElementById('Parking_status').value;

    var parkingInfo = "Parking Area: " + parkingArea + "\n" +
                      "Parking Number: " + parkingNumber + "\n" +
                      "Vehicle Type: " + vehicleType + "\n" +
                      "Date: " + parkingDate + "\n" +
                      "Status: " + parkingStatus;

    var qrCodeContainer = document.getElementById('qrCodeContainer');
    qrCodeContainer.innerHTML = ""; // Clear any previous QR code

    var qr = qrcode(0, 'M');
    qr.addData(parkingInfo);
    qr.make();

    var imgTag = qr.createImgTag();
    qrCodeContainer.innerHTML = imgTag;
    qrCodeContainer.setAttribute("data-parking-info", parkingInfo);

    var qrImage = qr.createDataURL();
    document.getElementById('qrImage').value = qrImage;

    var viewQRBtn = document.getElementById('viewQRBtn');
    viewQRBtn.style.display = "block";
});

document.getElementById('viewQRBtn').addEventListener('click', function() {
    var parkingInfo = document.getElementById('qrCodeContainer').getAttribute("data-parking-info");
    alert("Parking Information:\n\n" + parkingInfo);
});
</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
