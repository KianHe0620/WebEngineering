<?php
require "../database/conn_db.php";

$parkingNumber = $_POST['parkingNumber'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$bookingDate = $_POST['bookingDate'];
$currentDate = date('Y-m-d');
$currentTime = date('g a');

// Validate start time and end time
if (strtotime($bookingDate . ' ' . $startTime) < strtotime($currentDate . ' ' . $currentTime)) {
    echo json_encode(['success' => false, 'message' => 'Start time cannot be in the past.']);
    exit;
}

if (strtotime($bookingDate . ' ' . $endTime) <= strtotime($bookingDate . ' ' . $startTime)) {
    echo json_encode(['success' => false, 'message' => 'End time must be greater than start time.']);
    exit;
}

$sql = "INSERT INTO booking (Parking_number, Booking_date, Start_time, End_time) 
        VALUES ('$parkingNumber', '$bookingDate', '$startTime', '$endTime')";

if ($mysqli->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Parking spot booked successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $mysqli->error]);
}

$mysqli->close();
?>
