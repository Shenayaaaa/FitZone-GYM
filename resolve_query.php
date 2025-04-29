<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Database connection

if (isset($_GET['id'])) {
    $query_id = $_GET['id'];

    // Update the status of the query to 'Resolved'
    $update_query = "UPDATE customer_queries SET status = 'Resolved' WHERE query_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $query_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Query resolved successfully.";
    } else {
        echo "Error resolving query.";
    }

    $stmt->close();
} else {
    echo "Invalid query ID.";
}

$conn->close();
?>
