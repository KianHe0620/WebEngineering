<?php
    require "../database/conn_db.php";
    $parking_spaces = [
        'Parking A (Staff)' => 23,
        'Parking B (Student)' => 23
        // Add more parking areas as needed
    ];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Side and Top Navigation</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css" >
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

    <?php
    // Example data (replace with your actual data retrieval logic)
    $userCount = 13;
    $totalBookingCount = 21;
    $carCount = 15;
    $motorcycleCount = 6;
    ?>

    <h2>Admin Dashboard</h2>
    <div class="content">
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <p><?php echo date("l, F j, Y"); ?></p>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $userCount; ?></h5>
                        <p class="card-text">User</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $totalBookingCount; ?></h5>
                        <p class="card-text">Total Booking</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $carCount; ?></h5>
                        <p class="card-text">Cars</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $motorcycleCount; ?></h5>
                        <p class="card-text">Motorcycle</p>
                    </div>
                </div>
        </div><br><br>
        <div class="row">
            <div class="col-md-12">
                <canvas id="vehicleChart"></canvas>
            </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Example data (replace with your actual data retrieval logic)
    var carCount = <?php echo $carCount; ?>;
    var motorcycleCount = <?php echo $motorcycleCount; ?>;

    // Get the canvas element
    var ctx = document.getElementById('vehicleChart').getContext('2d');

    // Create the pie chart
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Cars', 'Motorcycles'],
            datasets: [{
                label: 'Vehicle Categories',
                data: [carCount, motorcycleCount],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)', // Red for cars
                    'rgba(54, 162, 235, 0.5)' // Blue for motorcycles
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Vehicle Categories'
            }
        }
    });
</script>
</div>

</body>
</html>
