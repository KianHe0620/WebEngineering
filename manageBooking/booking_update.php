<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
require "../database/conn_db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $parkingNumber = $_POST['parkingNumber'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $bookingDate = date('Y-m-d'); // Adjust this based on your needs

    $sql = "INSERT INTO booking (Parking_number, Booking_date, Start_time, End_time, bookingStatus) 
            VALUES ('$parkingNumber', '$bookingDate', '$startTime', '$endTime', 'confirmed')";

    if ($mysqli->query($sql) === TRUE) {
        $response = array('success' => true, 'message' => 'Booking confirmed!');
    } else {
        $response = array('success' => false, 'message' => 'Error: ' . $mysqli->error);
    }

    echo json_encode($response);
    $mysqli->close();
}
?>
