<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php 
        include("../conn_db.php");
        session_start();

        if (isset($_POST['submit'])) {
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
            $role = mysqli_real_escape_string($con, $_POST['role']);
            
            $result = mysqli_query($con, "SELECT * FROM $role WHERE email='$email' AND password='$password'");
            if ($result && mysqli_num_rows($result) > 0) {
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
                
                // Redirect based on role
                switch ($role) {
                    case 'admin':
                        header("Location: admin_dashboard.php");
                        break;
                    case 'unit_keselamatan':
                        header("Location: unit_keselamatan_dashboard.php");
                        break;
                    case 'student':
                        header("Location: student_dashboard.php");
                        break;
                }
                exit();
            } else {
                echo "Invalid email or password.";
            }
        }
    ?>

    <div id="Title">
        <h1 class="Title">FKPark</h1>
        <h2 class="Title">Welcome</h2>
        <h4 class="Title">Log in to FKPark</h4>
    </div>
    <form action="login.php" method="post">
        <input type="hidden" id="role" name="role">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <label for="role">Select Role:</label>
        <select id="role" name="role">
            <option value="admin">Administrator</option>
            <option value="unit_keselamatan">Unit Keselamatan</option>
            <option value="student">Student</option>
        </select>
        <br><br>
        <button type="button">Login</button>
        <p class="signup-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
    </form>
    <script>
        function selectRole(role) {
            document.getElementById("role").value = role;
            document.getElementById("login-form").submit();
        }
    </script>
</body>
</html>
