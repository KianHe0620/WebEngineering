<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="Title1">
        <h1 class="Title1">FKPark</h1>
        <h2 class="Title1">Join Us</h2>
        <h4 class="Title1">Create an account</h4>
    </div>
    <form action="signup_handler.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">Sign Up</button>
        <p class="signup-link">Already have an account? <a href="login.php">Login</a></p>
    </form>
</body>
</html>
