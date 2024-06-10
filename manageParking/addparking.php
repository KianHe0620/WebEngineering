<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fk_parking_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['createparking'])) {
    $Parking_area = $_POST['Parking_area'];
    $Parking_number = $_POST['Parking_number'];
    $vehicletype = $_POST['vehicletype'];
    $parkingdate = $_POST['parkingdate'];
    $qrImage = $_POST['qrImage'];

    // Check if a parking spot already exists at the same location and time
    $sql_check = "SELECT * FROM Parking WHERE Parking_area = ? AND parkingdate = ?";
    $stmt_check = $conn->prepare($sql_check);
    if ($stmt_check === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt_check->bind_param("ss", $Parking_area, $parkingdate);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // If a record exists, set Parking_status to 'unavailable'
        $Parking_status = "unavailable";
    } else {
        // If no record exists, set Parking_status to 'available'
        $Parking_status = "available";
    }

    // Insert data into database
    $sql = "INSERT INTO Parking (Parking_number, Parking_area, Parking_status, Vehicletype, parkingdate, qrImage) 
            VALUES (?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssssss", $Parking_number, $Parking_area, $Parking_status, $vehicletype, $parkingdate, $qrImage);
    
    if ($stmt->execute()) {
        // Redirect to viewparking.php after successful insertion
        header("Location: listparking.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Parking - FKPark</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
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
                <td><a href="/manageBooking/booking.php">Booking</a></td>
            </tr>
            <tr>
                <td><a href="/manageBooking/view.php">View Booking</a></td>
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
        <h2>Create New Parking Area</h2>
        <p>Fill in the information below:</p>
        <form action="listparking.php" method="POST"> <!-- Corrected form method -->
            <div class="mb-3">
                <label for="Parking_area" class="form-label">Parking Area: </label>
                <select class="form-select" id="Parking_area" name="Parking_area">
                    <option value="choose">choose...</option>
                    <option value="A1">A1</option>
                    <option value="A2">A2</option>
                    <option value="A3">A3</option>
                    <option value="B1">B1</option>
                    <option value="B2">B2</option>
                </select>
                </div>
                <div class="mb-3">
                <label for="Parking_number" class="form-label">Parking Number: </label>
                <input type="text" class="form-control" id="Parking_number" name="Parking_number">
            </div>
            <div class="mb-3">
                <label for="vehicletype" class="form-label">Vehicle Type</label>
                <select class="form-select" id="vehicletype" name="vehicletype" required>
                    <option value="Car">Car</option>
                    <option value="Motorcycle">Motorcycle</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="parkingdate" class="form-label">Date</label>
                <input type="datetime-local" class="form-control" id="parkingdate" name="parkingdate" required>
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
                <button type="submit" value="Save" name="createparking" class="btn btn-primary">Create Parking</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('generateQrBtn').addEventListener('click', function() {
            var parkingArea = document.getElementById('Parking_area').value;
            var parkingNumber = document.getElementById('Parking_number').value;
            var vehicleType = document.getElementById('vehicletype').value;
            var parkingDate = document.getElementById('parkingdate').value;

            var parkingInfo = "Parking Area: " + parkingArea + "\n" +
                              "Parking Number: " + parkingNumber + "\n" +
                              "Vehicle Type: " + vehicleType + "\n" +
                              "Date: " + parkingDate;

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