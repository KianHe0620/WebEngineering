<?php
$user = 'root';
$password = '';
$database = 'fk_parking_system';
$servername='localhost';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Uncomment the line below if you want to check if the connection is successful
    // echo "Connected successfully"; 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>