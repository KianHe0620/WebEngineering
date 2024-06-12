
<?php
session_start();
require '../database/conn_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // MD5 hash of the password
    $usertype = $_POST['usertype'];

    $table = '';
    $password_column = '';
    if ($usertype == 'admin') {
        $table = 'administrator';
        $password_column = 'Admin_password';
    } elseif ($usertype == 'staff') {
        $table = 'unitkeselamatanstaff';
        $password_column = 'UKStaff_password';
    } elseif ($usertype == 'student') {
        $table = 'student';
        $password_column = 'Student_password';
    }

    if ($table != '' && $password_column != '') {
        $sql = "SELECT * FROM $table WHERE username=? AND $password_column=?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['username'] = $username;
                $_SESSION['usertype'] = $usertype;
                header("Location: welcome.php");
            } else {
                echo "Invalid username or password.";
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
    } else {
        echo "Invalid user type.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="login-container">
        
            <h1 class="Title">FKPark</h1>
            <h2 class="Title">Welcome</h2>
            <h4 class="Title">Log in to FKPark</h4>

        <form id="login-form" action="login.php" method="post">
            <input type="hidden" id="usertype" name="usertype">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <label for="Utype">Select User type:</label>
            <select id="Utype" name="usertype">
                <option value="admin">Administrator</option>
                <option value="staff">Unit Keselamatan</option>
                <option value="student">Student</option>
            </select>
            <br><br>
            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', function() {
            var usertype = document.getElementById('Utype').value;
            document.getElementById('usertype').value = usertype;
        });
    </script>
</body>
</html>
