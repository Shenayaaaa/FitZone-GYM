<?php
session_start();

// Check if the user is logged in as either admin or staff
if (!(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) && !(isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true)) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Ensure that the database connection is included

// Check if 'id' is passed via GET and validate it
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // Prepare delete query
    $delete_query = "DELETE FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($delete_query);

    // Check if the prepared statement is successful
    if ($stmt) {
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Appointment deleted successfully.";
        } else {
            echo "Error: Appointment not found or could not be deleted.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the query.";
    }

} else {
    echo "Invalid appointment ID provided.";
}

$conn->close();
?>

<!-- Redirect back to the appointments overview page after deletion -->
<meta http-equiv="refresh" content="2;url=appointments_overview.php">
