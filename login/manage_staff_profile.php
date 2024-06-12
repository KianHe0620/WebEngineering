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
    $password = md5($_POST['password']);
    $name = $_POST['name'];
    $ic = $_POST['ic'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Check if username already exists
    $check_username_sql = "SELECT COUNT(*) as count FROM unitkeselamatanstaff WHERE username=?";
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

    // Insert new staff information
    $insert_sql = "INSERT INTO unitkeselamatanstaff (username, UKStaff_password, UKStaff_name, UKStaff_IC, UKStaff_phoneNum, UKStaff_email) VALUES (?, ?, ?, ?, ?, ?)";
    $insert_stmt = $mysqli->prepare($insert_sql);
    if ($insert_stmt) {
        $insert_stmt->bind_param("ssssss", $username, $password, $name, $ic, $phone, $email);
        if ($insert_stmt->execute()) {
            echo "New staff added successfully!";
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

    // Delete staff record
    $delete_sql = "DELETE FROM unitkeselamatanstaff WHERE UKStaff_id=?";
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

    // Update staff information
    $update_sql = "UPDATE unitkeselamatanstaff SET username=?, UKStaff_name=?, UKStaff_IC=?, UKStaff_phoneNum=?, UKStaff_email=? WHERE UKStaff_id=?";
    $update_stmt = $mysqli->prepare($update_sql);
    if ($update_stmt) {
        $update_stmt->bind_param("sssssi", $username, $name, $ic, $phone, $email, $id);
        if ($update_stmt->execute()) {
            echo "Staff profile updated successfully!";
        } else {
            echo "Error: " . $update_stmt->error;
        }
        $update_stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}

// Fetch all staff records
$sql = "SELECT * FROM unitkeselamatanstaff";
$result = $mysqli->query($sql);

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff Profiles</title>
    <link rel="stylesheet" href="../node_modules/bootstrap-5.3.3-dist/css/bootstrap.min.css">
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

    <div class="content">
        <div id="manageprofile">
            <h1 class="mb-4">FKPark - Manage Staff Profiles</h1>
            <button class="btn btn-success float-end mb-4" data-bs-toggle="modal" data-bs-target="#addModal">Add Staff</button>

            <!-- Display all staff -->
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
                    <?php while ($staff = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $staff['UKStaff_id']; ?></td>
                        <td><?php echo $staff['username']; ?></td>
                        <td><?php echo $staff['UKStaff_name']; ?></td>
                        <td><?php echo $staff['UKStaff_IC']; ?></td>
                        <td><?php echo $staff['UKStaff_phoneNum']; ?></td>
                        <td><?php echo $staff['UKStaff_email']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
                                data-id="<?php echo $staff['UKStaff_id']; ?>" 
                                data-username="<?php echo $staff['username']; ?>" 
                                data-name="<?php echo $staff['UKStaff_name']; ?>"
                                data-ic="<?php echo $staff['UKStaff_IC']; ?>"
                                data-phone="<?php echo $staff['UKStaff_phoneNum']; ?>"
                                data-email="<?php echo $staff['UKStaff_email']; ?>">Edit</button>
                            <form action="manage_staff_profile.php" method="post" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $staff['UKStaff_id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="manage_staff_profile.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="ic" class="form-label">IC</label>
                            <input type="text" class="form-control" id="ic" name="ic" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add" class="btn btn-primary">Add Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Staff Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" action="manage_staff_profile.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="mb-3">
                            <label for="edit-username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="edit-username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-ic" class="form-label">IC</label>
                            <input type="text" class="form-control" id="edit-ic" name="ic" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="edit-phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var username = button.getAttribute('data-username');
                var name = button.getAttribute('data-name');
                var ic = button.getAttribute('data-ic');
                var citizenship = button.getAttribute('data-citizenship');
                var phone = button.getAttribute('data-phone');
                var email = button.getAttribute('data-email');
                var address = button.getAttribute('data-address');

                var modalTitle = editModal.querySelector('.modal-title');
                var editId = editModal.querySelector('#edit-id');
                var editUsername = editModal.querySelector('#edit-username');
                var editName = editModal.querySelector('#edit-name');
                var editIc = editModal.querySelector('#edit-ic');
                var editCitizenship = editModal.querySelector('#edit-citizenship');
                var editPhone = editModal.querySelector('#edit-phone');
                var editEmail = editModal.querySelector('#edit-email');
                var editAddress = editModal.querySelector('#edit-address');

                modalTitle.textContent = 'Edit Student Profile';
                editId.value = id;
                editUsername.value = username;
                editName.value = name;
                editIc.value = ic;
                editCitizenship.value = citizenship;
                editPhone.value = phone;
                editEmail.value = email;
                editAddress.value = address;
            });
        });
    </script>
</body>
</html>
