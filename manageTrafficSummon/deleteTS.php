<?php
// deleteTS.php
session_start();

require "../database/conn_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the TSummon_id from the form submission
    $TSummon_id = $_POST['TSummon_id'];

    // Prepare the SQL DELETE query with a placeholder
    $sql = "DELETE FROM trafficsummon WHERE TSummon_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the TSummon_id parameter to the placeholder
        $stmt->bind_param("s", $TSummon_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Store the success message in the session
            $_SESSION['message'] = "Traffic Summon deleted successfully.";
            // Redirect back to the record traffic summon page after deletion
            header("Location: recordTS.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
