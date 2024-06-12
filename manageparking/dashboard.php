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

// Query to get total parking areas
$sqlTotalParkingAreas = "SELECT COUNT(*) AS total_parking_areas FROM parking";

// Query to get parking status summary
$sqlParkingStatusSummary = "SELECT Parking_status, COUNT(*) AS status_count FROM parking GROUP BY Parking_status";

// Query to get the count of available parking spaces
$sqlAvailableParking = "SELECT COUNT(*) AS available_parking FROM parking WHERE Parking_status = 'available'";

// Execute queries
$resultTotalParkingAreas = $conn->query($sqlTotalParkingAreas);
$resultParkingStatusSummary = $conn->query($sqlParkingStatusSummary);
$resultAvailableParking = $conn->query($sqlAvailableParking);

// Initialize available parking count to 0 by default
$availableParkingCount = 0;

// Fetch the result for available parking if available
if ($resultAvailableParking) {
    $rowAvailableParking = $resultAvailableParking->fetch_assoc();
    $availableParkingCount = $rowAvailableParking['available_parking'];
}


// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
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

<h2>Admin Dashboard</h2>
<div class="content">
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <p><?php echo date("l, F j, Y"); ?></p>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">1</h5>
                        <p class="card-text">User</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">2</h5>
                        <p class="card-text">Total Booking</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $availableParkingCount; ?></h5>
                        <p class="card-text">Available Parking</p>
                    </div>
                </div>
            </div>
         </div><br>
                <h2>Parking Status Summary</h2>
                <canvas id="parkingStatusSummaryChart" style="max-width:300px"></canvas>
        </div>
    </div>
</div>

<script>
    // Process data for Parking Status Summary chart
    var parkingStatusSummaryData = <?php echo json_encode($resultParkingStatusSummary->fetch_all(MYSQLI_ASSOC)); ?>;
    var statusLabels = parkingStatusSummaryData.map(function(item) { return item.Parking_status; });
    var statusCounts = parkingStatusSummaryData.map(function(item) { return item.status_count; });
    var total = statusCounts.reduce((a, b) => a + b, 0); // Calculate total count

    // Calculate percentages
    var percentages = statusCounts.map(function(count) {
        return ((count / total) * 100).toFixed(2) + '%';
    });

    // Create labels with counts and percentages
    var statusLabelsFormatted = statusLabels.map(function(label, index) {
        return label + ' (' + statusCounts[index] + ', ' + percentages[index] + ')';
    });

    // Define colors for the pie chart
    var backgroundColors = statusLabels.map(function(label) {
        return label === 'available' ? 'rgba(0, 255, 0, 0.2)' : 'rgba(255, 0, 0, 0.2)';
    });
    var borderColors = statusLabels.map(function(label) {
        return label === 'available' ? 'rgba(0, 255, 0, 1)' : 'rgba(255, 0, 0, 1)';
    });

    // Create Parking Status Summary chart
    var parkingStatusSummaryChartCtx = document.getElementById('parkingStatusSummaryChart').getContext('2d');
    var parkingStatusSummaryChart = new Chart(parkingStatusSummaryChartCtx, {
        type: 'pie',
        data: {
            labels: statusLabelsFormatted, // Use formatted labels
            datasets: [{
                label: 'Parking Status Summary',
                data: statusCounts,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>



</body>
</html>
