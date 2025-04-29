<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Include database connection

// Check if the membership ID is provided
if (!isset($_GET['id'])) {
    echo "Invalid membership ID.";
    exit;
}

$membership_id = intval($_GET['id']);

// Delete the membership plan
$query = "DELETE FROM membership_plans WHERE membership_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $membership_id);

if ($stmt->execute()) {
    echo "Membership plan deleted successfully!";
    header("Location: membership_mgmt.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?>
