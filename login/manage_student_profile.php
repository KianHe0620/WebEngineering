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
    $citizenship = $_POST['citizenship'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Check if username already exists
    $check_username_sql = "SELECT COUNT(*) as count FROM student WHERE username=?";
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

    // Insert new student information
    $insert_sql = "INSERT INTO student (username, Student_password, Student_name, Student_IC, Student_citizenship, Student_phoneNum, Student_email, Student_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $mysqli->prepare($insert_sql);
    if ($insert_stmt) {
        $insert_stmt->bind_param("ssssssss", $username, $password, $name, $ic, $citizenship, $phone, $email, $address);
        if ($insert_stmt->execute()) {
            echo "New student added successfully!";
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

    // Delete student record
    $delete_sql = "DELETE FROM student WHERE Student_id=?";
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
    $citizenship = $_POST['citizenship'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Update student information
    $update_sql = "UPDATE student SET username=?, Student_name=?, Student_IC=?, Student_citizenship=?, Student_phoneNum=?, Student_email=?, Student_address=? WHERE Student_id=?";
    $update_stmt = $mysqli->prepare($update_sql);
    if ($update_stmt) {
        $update_stmt->bind_param("sssssssi", $username, $name, $ic, $citizenship, $phone, $email, $address, $id);
        if ($update_stmt->execute()) {
            echo "Student profile updated successfully!";
        } else {
            echo "Error: " . $update_stmt->error;
        }
        $update_stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}

// Fetch all student records
$sql = "SELECT * FROM student";
$result = $mysqli->query($sql);

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student Profiles</title>
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
                <td><a href="manage_student_profile.php">Manage Profile</a></td>
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
            <h1 class="mb-4">FKPark - Manage Student Profiles</h1>
            <button class="btn btn-success float-end mb-4" data-bs-toggle="modal" data-bs-target="#addModal">Add Student</button>

            <!-- Display all students -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>IC</th>
                        <th>Citizenship</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $student['Student_id']; ?></td>
                        <td><?php echo $student['username']; ?></td>
                        <td><?php echo $student['Student_name']; ?></td>
                        <td><?php echo $student['Student_IC']; ?></td>
                        <td><?php echo $student['Student_citizenship']; ?></td>
                        <td><?php echo $student['Student_phoneNum']; ?></td>
                        <td><?php echo $student['Student_email']; ?></td>
                        <td><?php echo $student['Student_address']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
                                data-id="<?php echo $student['Student_id']; ?>" 
                                data-username="<?php echo $student['username']; ?>" 
                                data-name="<?php echo $student['Student_name']; ?>"
                                data-ic="<?php echo $student['Student_IC']; ?>"
                                data-citizenship="<?php echo $student['Student_citizenship']; ?>"
                                data-phone="<?php echo $student['Student_phoneNum']; ?>"
                                data-email="<?php echo $student['Student_email']; ?>"
                                data-address="<?php echo $student['Student_address']; ?>">Edit</button>
                            <form action="manage_student_profile.php" method="post" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $student['Student_id']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-form" action="manage_student_profile.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Student Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
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
                            <label for="edit-citizenship" class="form-label">Citizenship</label>
                            <input type="text" class="form-control" id="edit-citizenship" name="citizenship" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="edit-phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="edit-address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="edit-password" name="password" required>
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

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="add-form" action="manage_student_profile.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Student Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="add-username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="add-username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="add-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="add-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="add-ic" class="form-label">IC</label>
                            <input type="text" class="form-control" id="add-ic" name="ic" required>
                        </div>
                        <div class="mb-3">
                            <label for="add-citizenship" class="form-label">Citizenship</label>
                            <input type="text" class="form-control" id="add-citizenship" name="citizenship" required>
                        </div>
                        <div class="mb-3">
                            <label for="add-phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="add-phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="add-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="add-email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="add-address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="add-address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="add-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="add-password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add" class="btn btn-success">Add Student</button>
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
