<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

if ($usertype == 'admin') {
    header("Location: admin_dashboard.php");
} elseif ($usertype == 'staff') {
    header("Location: unit_keselamatan_dashboard.php");
} elseif ($usertype == 'student') {
    header("Location: student_dashboard.php");
} else {
    echo "Invalid user type.";
    session_destroy();
    header("Location: login.php");
}
?>
