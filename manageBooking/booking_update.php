<?php
require "../database/conn_db.php";

session_start();

$studentId = "S001";

try {
    // Check if user is logged in
    // if (!isset($_SESSION['student_id'])) {
    //     echo json_encode(['success' => false, 'message' => 'Student is not logged in.']);
    //     exit;
    // }

    // Retrieve session data
    //$studentId = $_SESSION['student_id'];

    // Retrieve POST data and validate
    $parkingNumber = isset($_POST['parkingNumber']) ? $_POST['parkingNumber'] : null;
    $startTime = isset($_POST['startTime']) ? $_POST['startTime'] : null;
    $endTime = isset($_POST['endTime']) ? $_POST['endTime'] : null;
    $bookingDate = isset($_POST['bookingDate']) ? $_POST['bookingDate'] : null;

    // Validate POST data
    if (!$parkingNumber || !$startTime || !$endTime || !$bookingDate) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }

    // Check if start time is in the past
    $currentDate = date('Y-m-d');
    $currentTime = date('H:00:00');
    if (strtotime("$bookingDate $startTime") < strtotime("$currentDate $currentTime")) {
        echo json_encode(['success' => false, 'message' => 'Start time cannot be in the past.']);
        exit;
    }

    // Check if end time is before start time
    if (strtotime("$bookingDate $endTime") <= strtotime("$bookingDate $startTime")) {
        echo json_encode(['success' => false, 'message' => 'End time must be greater than start time.']);
        exit;
    }

    // Check if the selected time slot is already booked
    $sql = "SELECT * FROM booking 
    WHERE Parking_number = :parkingNumber 
    AND Booking_date = :bookingDate 
    AND (:startTime BETWEEN Start_time AND End_time OR 
         (:endTime <= End_time AND :endTime > Start_time))";

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
    $lastBookingIdQuery = "SELECT MAX(Booking_id) AS max_booking_id FROM booking";
    $lastBookingIdResult = $conn->query($lastBookingIdQuery);
    $lastBookingIdRow = $lastBookingIdResult->fetch(PDO::FETCH_ASSOC);
    $newBookingId = $lastBookingIdRow['max_booking_id'] + 1;

    // Insert the new booking if all checks pass
    $insertSql = "INSERT INTO booking (Booking_id, Student_id, Parking_number, Booking_date, Start_time, End_time) 
            VALUES (:newBookingId, :studentId, :parkingNumber, :bookingDate, :startTime, :endTime)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bindParam(':newBookingId', $newBookingId);
    $stmt->bindParam(':studentId', $studentId);
    $stmt->bindParam(':parkingNumber', $parkingNumber);
    $stmt->bindParam(':bookingDate', $bookingDate);
    $stmt->bindParam(':startTime', $startTime);
    $stmt->bindParam(':endTime', $endTime);

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
