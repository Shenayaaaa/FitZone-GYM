<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /fitzone77/Index.php"); // Redirect if not logged in or not an admin
    exit();
}

// Delete staff
if (isset($_GET['id'])) {
    include 'DB_connect.php'; // Include your database connection

    $user_id = $_GET['id'];

    // Delete staff member from the database
    $stmt = $conn->prepare("DELETE FROM user_roles1 WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Staff member deleted successfully'); window.location.href='view_staff.php';</script>";
    } else {
        echo "<script>alert('Error deleting staff'); window.location.href='view_staff.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
