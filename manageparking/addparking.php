

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Parking - FKPark</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
    <style>
        
        </style>
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
            <td><a href="viewparking.php">Manage Parking</a></td>
        </tr>
        <tr>
            <td><a href="dashboard.php">Dashboard</a></td>
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
            <th><a href="../Login/logout.php">Log Out</a></th>
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
    <form action="insert_parking.php" method="POST">

        <div class="mb-3">
            <label for="Parking_area" class="form-label">Parking Area: </label>
            <select class="form-select" id="Parking_area" name="Parking_area" required>
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
            <input type="text" class="form-control" id="Parking_number" name="Parking_number" required>
        </div>
        <div class="mb-3">
            <label for="Parking_status" class="form-label">Parking Status:</label>
            <select class="form-select" id="Parking_status" name="Parking_status" required>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="vehicle_type" class="form-label">Vehicle Type</label>
            <select class="form-select" id="vehicle_type" name="vehicle_type" required>
                <option value="Car">Car</option>
                <option value="Motorcycle">Motorcycle</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="parking_date" class="form-label">Date</label>
            <input type="datetime-local" class="form-control" id="parking_date" name="parking_date" required>
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
            <button type="submit" name="createparking" value="Save" class="btn btn-primary">Create Parking</button>
        </div>
    </form>
</div>
<script>
    document.getElementById('generateQrBtn').addEventListener('click', function() {
        var parkingArea = document.getElementById('Parking_area').value;
        var parkingNumber = document.getElementById('Parking_number').value;
        var vehicleType = document.getElementById('vehicle_type').value;
        var parkingDate = document.getElementById('parking_date').value;
        var parkingStatus = document.getElementById('Parking_status').value; // New line to get parking status

        var parkingInfo = "Parking Area: " + parkingArea + "\n" +
                          "Parking Number: " + parkingNumber + "\n" +
                          "Vehicle Type: " + vehicleType + "\n" +
                          "Date: " + parkingDate + "\n" +
                          "Status: " + parkingStatus; // Include parking status

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