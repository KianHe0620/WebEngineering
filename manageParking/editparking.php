<?php
session_start();

// Initialize parking areas array in session if not already set
if (!isset($_SESSION['parking_areas'])) {
    header("Location: listparking.php");
    exit();
}

$parking_areas = &$_SESSION['parking_areas'];

if (isset($_GET['Parking_number'])) {
    $Parking_number = $_GET['Parking_number'];
    
    // Find the parking area to edit
    foreach ($parking_areas as $key => $parking_area) {
        if ($parking_area['Parking_number'] == $Parking_number) {
            $edit_parking_area = $parking_area;
            $edit_key = $key;
            break;
        }
    }
}

// Rest of your code for editing and updating parking area goes here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parking - FKPark</title>
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
                <td><a href="managearea.php">Manage Area</a></td>
            </tr>
            <tr>
                <td><a href="admindashboard.php">Dashboard</a></td>
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
        <h2>Edit Parking Area</h2>
        <p>Update the information below:</p>
        <form action="updateparking.php" method="POST">
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
                <button type="submit" value="Save" name="editparking" class="btn btn-primary" >Save Changes</button>
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
