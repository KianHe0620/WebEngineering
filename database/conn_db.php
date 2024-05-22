<?php
$user = 'root';
$password = '';
 
// Database name is geeksforgeeks
$database = 'fk_parking_system';
 
// Server is localhost with
// port number 3306
$servername='localhost';
$mysqli = new mysqli($servername, $user, $password, $database);
    
// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}
?>