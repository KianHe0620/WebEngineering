
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


// Retrieve parking data from the database
$sql = "SELECT * FROM parking";
$result = $conn->query($sql);

// Check if there are any parking spaces
if ($result->num_rows > 0) {
    $parkingSpaces = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $parkingSpaces = [];
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
    <title>Student View Parking</title>
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
            <td><a href="student_view_parking.php">View Parking</a></td>
        </tr>
        <tr>
            <th>Parking Booking</th>
        </tr>
        <tr>
            <td><a href="../manageBooking/booking.php">Booking</a></td>
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
    <div class="container mt-5">
        <h2>Parking Spaces</h2>
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
            <tr>
                <th scope="col">Parking Area</th>
                <th scope="col">Parking Number</th>
                <th scope="col">Vehicle Type</th>
                <th scope="col">Status</th>
                <th scope="col">QR code</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['Parking_area']) . "</td>
                            <td>" . htmlspecialchars($row['Parking_number']) . "</td>
                            <td>" . htmlspecialchars($row['vehicle_type']) . "</td>
                            <td>" . htmlspecialchars($row['Parking_status']) . "</td>
                            <td><img src='data:image/png;base64," . base64_encode($row['qrImage']) . "' alt='QR Code'></td>
                </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No parking areas found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
