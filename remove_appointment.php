<?php
session_start();

// Check if the user is logged in as either an admin or staff member
if (!(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) && !(isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true)) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Include your database connection

// Get the appointment ID from the query string
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // Check if the user is authorized to remove the appointment (admin or staff member assigned to the appointment)
    $query = "SELECT staff_id FROM appointments5 WHERE appointment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $staff_id = $row['staff_id'];

        // If the user is an admin or the staff member is the one assigned to the appointment
        if ($_SESSION['admin_logged_in'] === true || ($_SESSION['staff_logged_in'] === true && $_SESSION['staff_id'] == $staff_id)) {
            // Remove the appointment from the database
            $delete_query = "DELETE FROM appointments5 WHERE appointment_id = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("i", $appointment_id);
            if ($delete_stmt->execute()) {
                // Redirect to the appointments overview page with a success message
                header("Location: appt_overview.php?status=removed");
                exit;
            } else {
                // If deletion fails, display an error message
                echo "Error: Could not remove the appointment.";
            }
        } else {
            echo "You are not authorized to remove this appointment.";
        }
    } else {
        echo "Appointment not found.";
    }
} else {
    echo "Invalid appointment ID.";
}

$conn->close();
?>
