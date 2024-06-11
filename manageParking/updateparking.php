<?php
// Hardcoded parking areas data
$parking_areas = [
    [
        'Parking_number' => 'A3-133',
        'Parking_area' => 'A3',
        'Parking_status' => 'unavailable',
        'Vehicletype' => 'Motorcycle',
        'parkingdate' => '2024-06-10 08:00:00',
        'qrImage' => null, // Replace with actual base64-encoded image if needed
    ],
    [
        'Parking_number' => 'B2-122',
        'Parking_area' => 'B2',
        'Parking_status' => 'unavailable',
        'Vehicletype' => 'Car',
        'parkingdate' => '2024-06-11 09:00:00',
        'qrImage' => null, // Replace with actual base64-encoded image if needed
    ],
    // Add more hardcoded parking data as needed
];

// Handle delete action
if (isset($_GET['delete'])) {
    $Parking_number = $_GET['delete'];

    // Find the index of the item to delete
    foreach ($parking_areas as $key => $parking_area) {
        if ($parking_area['Parking_number'] == $Parking_number) {
            unset($parking_areas[$key]);
            break;
        }
    }

    // Redirect to avoid resubmission on refresh
    header("Location: editparking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Parking Areas - FKPark</title>
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
        <h2>List of Parking Areas</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Parking Number</th>
                    <th>Parking Area</th>
                    <th>Status</th>
                    <th>Vehicle Type</th>
                    <th>Date</th>
                    <th>QR Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($parking_areas) > 0): ?>
                    <?php foreach ($parking_areas as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Parking_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['Parking_area']); ?></td>
                            <td><?php echo htmlspecialchars($row['Parking_status']); ?></td>
                            <td><?php echo htmlspecialchars($row['Vehicletype']); ?></td>
                            <td><?php echo htmlspecialchars($row['parkingdate']); ?></td>
                            <td>
                                <?php if ($row['qrImage']): ?>
                                    <img src="data:image/png;base64,<?php echo base64_encode($row['qrImage']); ?>" alt="QR Code" style="width: 50px; height: 50px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="editparking.php?Parking_number=<?php echo $row['Parking_number']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="listparking.php?delete=<?php echo $row['Parking_number']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this parking area?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No parking areas found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
