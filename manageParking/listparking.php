<?php
require_once('../database/conn_db.php');

// Delete functionality
if (isset($_GET['delete'])) {
    $Parking_number = $_GET['delete'];

    $sql_delete = "DELETE FROM Parking WHERE Parking_number = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bindParam(1, $Parking_number);
    if ($stmt_delete->execute()) {
        header("Location: listparking.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt_delete->errorInfo();
    }
}

// Fetch all parking areas
$sql = "SELECT * FROM Parking";
$stmt = $conn->query($sql);
$parking_areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <!-- Sidebar content -->
    </div>

    <div class="topnav">
        <!-- Top navigation content -->
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