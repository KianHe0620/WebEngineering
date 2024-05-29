<?php
// cancel_booking.php
session_start();

require "../database/conn_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the booking ID from the form submission
    $booking_id = $_POST['booking_id'];

    // Prepare and execute the SQL DELETE query
    $sql = "DELETE FROM booking WHERE Booking_id = :booking_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['booking_id' => $booking_id]);

    // You can send a response back if needed
    echo "Booking canceled successfully.";
    exit();
}
?>
