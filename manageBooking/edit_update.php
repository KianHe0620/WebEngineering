<?php
require "../database/conn_db.php";

$studentId = "S001"; // This should ideally come from the session
try{
// Check if user is logged in
// if (!isset($_SESSION['student_id'])) {
//     echo json_encode(['success' => false, 'message' => 'Student is not logged in.']);
//     exit;
// }

// Retrieve session data
// $studentId = $_SESSION['student_id'];

$booking_id = $_POST['booking_id'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$booking_date = $_POST['booking_date'];
$parking_number = $_POST['parking_number'];

$current_date = date('Y-m-d');
$current_time = date('H:00:00');

// Check if start time is in the past
if (strtotime("$booking_date $start_time") < strtotime("$current_date $current_time")) {
    echo json_encode(['success' => false, 'message' => 'Start time cannot be in the past.']);
    exit;
}

// Check if end time is before start time
if (strtotime("$booking_date $end_time") <= strtotime("$booking_date $start_time")) {
    echo json_encode(['success' => false, 'message' => 'End time must be greater than start time.']);
    exit;
}

// Check if the selected time slot is already booked (excluding the current booking)
$sql = "SELECT * FROM booking 
        WHERE Parking_number = :parking_number 
        AND Booking_date = :booking_date 
        AND Booking_id != :booking_id
        AND (:start_time BETWEEN Start_time AND End_time OR 
         (:end_time <= End_time AND :end_time > Start_time))";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':parking_number', $parking_number);
$stmt->bindParam(':booking_date', $booking_date);
$stmt->bindParam(':booking_id', $booking_id);
$stmt->bindParam(':start_time', $start_time);
$stmt->bindParam(':end_time', $end_time);
$stmt->execute();
$result = $stmt->fetch();

if ($result) {
    echo json_encode(['success' => false, 'message' => 'The selected time slot is already booked.']);
    exit;
}

// No clash, update the booking (including Student_id)
$sql = "UPDATE booking 
        SET Start_time = :start_time, End_time = :end_time 
        WHERE Booking_id = :booking_id
        AND Student_id = :student_id"; // Ensure only the student's booking is updated

$stmt = $conn->prepare($sql);
$stmt->execute([
    'start_time' => $start_time,
    'end_time' => $end_time,
    'booking_id' => $booking_id,
    'student_id' => $studentId // Include the Student_id in the update
]);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Parking spot booked successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: Unable to book parking spot.']);
}
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn = null;
?>

