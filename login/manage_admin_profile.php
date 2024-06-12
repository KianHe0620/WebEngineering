<?php
session_start();
require '../database/conn_db.php';

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// Only allow admins to manage profiles here
if ($usertype != 'admin') {
    echo "Unauthorized access.";
    exit();
}

// Handle add request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Use password_hash() for secure password hashing
    $name = $_POST['name'];
    $ic = $_POST['ic'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Check if username already exists
    $check_username_sql = "SELECT COUNT(*) as count FROM administrator WHERE username=?";
    $check_username_stmt = $mysqli->prepare($check_username_sql);
    if ($check_username_stmt) {
        $check_username_stmt->bind_param("s", $username);
        $check_username_stmt->execute();
        $check_username_result = $check_username_stmt->get_result()->fetch_assoc();
        if ($check_username_result['count'] > 0) {
            echo "Username already exists. Please choose a different username.";
            exit(); // Stop further execution
        }
        $check_username_stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
        exit(); // Stop further execution
    }

    // Insert new admin information
    $insert_sql = "INSERT INTO administrator (Admin_name, Admin_IC, Admin_email, Admin_phoneNum, Admin_password, username) VALUES (?, ?, ?, ?, ?, ?)";
    $insert_stmt = $mysqli->prepare($insert_sql);
    if ($insert_stmt) {
        $insert_stmt->bind_param("ssssss", $name, $ic, $email, $phone, $password, $username);
        if ($insert_stmt->execute()) {
            echo "New admin added successfully!";
        } else {
            echo "Error: " . $insert_stmt->error;
        }
        $insert_stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Delete admin record
    $delete_sql = "DELETE FROM administrator WHERE Admin_id=?";
    $delete_stmt = $mysqli->prepare($delete_sql);
    if ($delete_stmt) {
        $delete_stmt->bind_param("i", $id);
        if ($delete_stmt->execute()) {
            echo "Profile deleted successfully!";
        } else {
            echo "Error: " . $delete_stmt->error;
        }
        $delete_stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}

// Handle edit request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $ic = $_POST['ic'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Update admin information
    $update_sql = "UPDATE administrator SET Admin_name=?, Admin_IC=?, Admin_email=?, Admin_phoneNum=?, username=? WHERE Admin_id=?";
    $update_stmt = $mysqli->prepare($update_sql);
    if ($update_stmt) {
        $update_stmt->bind_param("sssssi", $name, $ic, $email, $phone, $username, $id);
        if ($update_stmt->execute()) {
            echo "Admin profile updated successfully!";
        } else {
            echo "Error: " . $update_stmt->error;
        }
        $update_stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}

// Fetch all admin records
$sql = "SELECT * FROM administrator";
$result = $mysqli->query($sql);

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admin Profiles</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script defer src="../js/opensidebar.js"></script>
</head>
<body>
    <!-- Sidebar and top navigation -->
    <div class="sidebar">
        <table>
            <tr>
                <th>User Profile</th>
            </tr>
            <tr>
                <td><a href="manage_staff_profile.php">Manage Profile</a></td>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <th>Parking Area</th>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <td><a href="">Content</a></td>
            </tr>
            <tr>
                <th>Parking Booking</th>
            </tr>
            <tr>
                <td><a href="../manageBooking/booking.php">Booking</a></td>
            </tr>
            <tr>
                <td><a href="../manageBooking/view.php">View Booking</a></td>
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
                <th><a href="logout.php">Log Out</a></th>
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
        <!-- Main content -->
    <div class="content">
        <div id="manageprofile">
            <h1 class="mb-4">FKPark - Manage Admin Profiles</h1>
            <button class="btn btn-success float-end mb-4" data-bs-toggle="modal" data-bs-target="#addAdminModal">Add Admin</button>

            <!-- Display all admins -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>IC</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($admin = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $admin['Admin_id']; ?></td>
                        <td><?php echo $admin['username']; ?></td>
                        <td><?php echo $admin['Admin_name']; ?></td>
                        <td><?php echo $admin['Admin_IC']; ?></td>
                        <td><?php echo $admin['Admin_phoneNum']; ?></td>
                        <td><?php echo $admin['Admin_email']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editAdminModal" 
                                data-id="<?php echo $admin['Admin_id']; ?>" 
                                data-username="<?php echo $admin['username']; ?>" 
                                data-name="<?php echo $admin['Admin_name']; ?>"
                                data-ic="<?php echo $admin['Admin_IC']; ?>"
                                data-phone="<?php echo $admin['Admin_phoneNum']; ?>"
                                data-email="<?php echo $admin['Admin_email']; ?>">Edit</button>
                            <form action="manage_admin_profile.php" method="post" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $admin['Admin_id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Admin Modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-admin-form" action="manage_admin_profile.php" method="POST">
                        <div class="mb-3">
                            <label for="addAdminUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="addAdminUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAdminPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="addAdminPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAdminName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="addAdminName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAdminIC" class="form-label">IC</label>
                            <input type="text" class="form-control" id="addAdminIC" name="ic" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAdminPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="addAdminPhone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAdminEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="addAdminEmail" name="email" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add" class="btn btn-primary">Add Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Omitted for brevity -->

    <!-- Edit Admin Modal -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-admin-form" action="manage_admin_profile.php" method="POST">
                        <div class="mb-3">
                            <label for="addAdminUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="addAdminUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAdminPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="addAdminPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAdminName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="addAdminName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAdminIC" class="form-label">IC</label>
                            <input type="text" class="form-control" id="addAdminIC" name="ic" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAdminPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="addAdminPhone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="addAdminEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="addAdminEmail" name="email" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Omitted for brevity -->

    
</body>
</html>

