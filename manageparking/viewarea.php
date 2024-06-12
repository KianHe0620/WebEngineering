<?php
// Include database connection
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


// Fetch data from the database
$sql = "SELECT * FROM parking";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Parking Areas - FKPark</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Your custom styles here */
    </style>
</head>
<body>
    <div class="content">
        <h2>View Parking Areas</h2>
        <p>List of parking areas:</p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Parking Area</th>
                        <th>Date From</th>
                        <th>Date Until</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Parking Status</th>
                        <th>Event/Reason</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through each row of the result set
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Parking_area'] . "</td>";
                        echo "<td>" . $row['date_from'] . "</td>";
                        echo "<td>" . $row['date_until'] . "</td>";
                        echo "<td>" . $row['start_time'] . "</td>";
                        echo "<td>" . $row['end_time'] . "</td>";
                        echo "<td>" . $row['Parking_status'] . "</td>";
                        echo "<td>" . $row['ereason'] . "</td>";
                        // Add edit, delete, view buttons here
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
