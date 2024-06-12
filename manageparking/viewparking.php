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


// Define search variables and initialize with default values
$search_option = '';
$search_value = '';

if (isset($_GET['search_option'])) {
    $search_option = $_GET['search_option'];
    $search_value = $_GET['search_value'] ?? '';

    // Prepare a SQL query based on the search criteria
    if ($search_option == 'Parking_area') {
        $stmt = $conn->prepare("SELECT * FROM parking WHERE Parking_area LIKE ?");
        $search_param = "%" . $search_value . "%";
        $stmt->bind_param("s", $search_param);
    } elseif ($search_option == 'Parking_status') {
        $stmt = $conn->prepare("SELECT * FROM parking WHERE Parking_status LIKE ?");
        $search_param = "%" . $search_value . "%";
        $stmt->bind_param("s", $search_param);
    } elseif ($search_option == 'vehicle_type') {
        $stmt = $conn->prepare("SELECT * FROM parking WHERE vehicle_type LIKE ?");
        $search_param = "%" . $search_value . "%";
        $stmt->bind_param("s", $search_param);
    } elseif ($search_option == 'All') {
        $stmt = $conn->prepare("SELECT * FROM parking");
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Fetch all parking records
    $sql = "SELECT * FROM parking";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Parking - FKPark</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        updateKeywordOptions(); // Call it on page load in case there's a pre-selected option
    });

    function updateKeywordOptions() {
        const searchOption = document.querySelector('select[name="search_option"]').value;
        const keywordSelect = document.querySelector('select[name="search_value"]');
        keywordSelect.innerHTML = '';

        if (searchOption === 'Parking_area') {
            keywordSelect.innerHTML = `
                <option value="">choose...</option>
                <option value="A1">A1</option>
                <option value="A2">A2</option>
                <option value="A3">A3</option>
                <option value="B1">B1</option>
                <option value="B2">B2</option>
            `;
        } else if (searchOption === 'Parking_status') {
            keywordSelect.innerHTML = `
                <option value="">choose...</option>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            `;
        } else if (searchOption === 'vehicle_type') {
            keywordSelect.innerHTML = `
                <option value="">choose...</option>
                <option value="Car">Car</option>
                <option value="Motorcycle">Motorcycle</option>
            `;
        } else {
            keywordSelect.innerHTML = '<option value="">All</option>';
            keywordSelect.disabled = true; // Disable the search_value dropdown when 'All' is selected
        }
        keywordSelect.disabled = false; // Re-enable the search_value dropdown for other options
    }

    function handleSearchSubmit(event) {
        const searchOption = document.querySelector('select[name="search_option"]').value;
        const searchValue = document.querySelector('select[name="search_value"]');
        if (searchOption === 'All') {
            searchValue.disabled = true; // Disable search_value input to allow form submission
        }
    }
</script>

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
            <td><a href="manage_area.php">Manage Area</a></td>
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
    <input type="text" name="search_value" class="form-control" placeholder="Search.." value="<?php echo htmlspecialchars($search_value); ?>" required>
    <button type="submit" class="btn btn-primary"><img src="../image/search.png" height="20px" width="20px"></button>
    <a href="#home">Home</a>
    <a href="#about">About</a>
    <a href="#services">Services</a>
    <a href="#contact">Contact</a>
</div>

<div class="content">
<div class="container mt-5">
    <h2>List of Created Parking Areas</h2><br>
    <div class="search-bar">
        <form action="" method="GET" class="d-flex" onsubmit="handleSearchSubmit(event)">
            <select name="search_option" class="form-select" onchange="updateKeywordOptions()" required>
                <option value="">Select Search Option</option>
                <option value="All" <?php echo ($search_option == 'All') ? 'selected' : ''; ?>>All</option>
                <option value="Parking_area" <?php echo ($search_option == 'Parking_area') ? 'selected' : ''; ?>>Parking Area</option>
                <option value="Parking_status" <?php echo ($search_option == 'Parking_status') ? 'selected' : ''; ?>>Parking Status</option>
                <option value="vehicle_type" <?php echo ($search_option == 'vehicle_type') ? 'selected' : ''; ?>>Parking For</option>
            </select>
            <select name="search_value" class="form-select" required>
                <option value="">choose...</option>
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Parking Area</th>
                <th>Parking Number</th>
                <th>Parking Status</th>
                <th>Parking For</th>
                <th>Date Created</th>
                <th>QR Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['Parking_area']) . "</td>
                            <td>" . htmlspecialchars($row['Parking_number']) . "</td>
                            <td>" . htmlspecialchars($row['Parking_status']) . "</td>
                            <td>" . htmlspecialchars($row['vehicle_type']) . "</td>
                            <td>" . htmlspecialchars($row['parking_date']) . "</td>
                            <td><img src='data:image/png;base64," . base64_encode($row['qrImage']) . "' alt='QR Code'></td>
                            <td>
                                <a href='view_parking.php?id=" . $row['Parking_id'] . "' class='btn btn-info'>View</a>
                                <a href='edit_parking.php?id=" . $row['Parking_id'] . "' class='btn btn-warning'>Edit</a>
                                <a href='delete_parking.php?id=" . $row['Parking_id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this parking?\")'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No parking areas found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
</body>
</html>

<?php
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
