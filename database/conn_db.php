<?php
$user = 'root';
$password = '';
$database = 'fk_parking_system';
$servername='localhost';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>