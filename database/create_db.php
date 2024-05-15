<?php
$link = mysqli_connect("localhost", "root", "");

if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}

$sql = "CREATE DATABASE fk_parking_system";

if (mysqli_query($link, $sql)) {
    echo "Database created successfully\n";
} else {
    echo 'Error creating database: ' . mysqli_connect_error() . "\n";
}

mysqli_close($link);
?>
