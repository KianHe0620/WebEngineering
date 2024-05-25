<?php
require "../database/conn_db.php";

// Check if student is logged in and retrieve student ID from session
session_start();
// if (!isset($_SESSION['student_id'])) {
//     echo json_encode(['success' => false, 'message' => 'Student is not logged in.']);
//     exit;
// }

$studentId = $_SESSION['student_id'];

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

// Check if the end time falls within existing bookings
$sql = "SELECT * FROM booking 
        WHERE Parking_number = :parkingNumber 
        AND Booking_date = :bookingDate 
        AND (:startTime BETWEEN Start_time AND End_time OR :endTime BETWEEN Start_time AND End_time)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':parkingNumber', $parkingNumber);
$stmt->bindParam(':bookingDate', $bookingDate);
$stmt->bindParam(':startTime', $startTime);
$stmt->bindParam(':endTime', $endTime);
$stmt->execute();
$result = $stmt->fetch();

if ($result) {
    echo json_encode(['success' => false, 'message' => 'The selected time slot is already booked.']);
    exit;
}

// Get the last booking_id from the database and increment by 1
$lastBookingIdQuery = "SELECT MAX(booking_id) AS max_booking_id FROM booking";
$lastBookingIdResult = $conn->query($lastBookingIdQuery);
$lastBookingIdRow = $lastBookingIdResult->fetch(PDO::FETCH_ASSOC);
$newBookingId = $lastBookingIdRow['max_booking_id'] + 1;

// Insert the new booking if all checks pass
$sql = "INSERT INTO booking (booking_id, student_id, Parking_number, Booking_date, Start_time, End_time) 
        VALUES (:newBookingId, :studentId, :parkingNumber, :bookingDate, :startTime, :endTime)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':newBookingId', $newBookingId);
$stmt->bindParam(':studentId', $studentId);
$stmt->bindParam(':parkingNumber', $parkingNumber);
$stmt->bindParam(':bookingDate', $bookingDate);
$stmt->bindParam(':startTime', $startTime);
$stmt->bindParam(':endTime', $endTime);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Parking spot booked successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]]);
}

$conn = null; // Close connection
?>
