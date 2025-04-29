<?php
session_start();

// Check if the user is logged in as either admin or staff
if (!(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) && !(isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true)) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Database connection

if (isset($_GET['id'])) {
    $query_id = $_GET['id'];

    // Delete the query from the database (updated table name)
    $delete_query = "DELETE FROM queries7 WHERE query_id = ?";
    $stmt = $conn->prepare($delete_query);

    if ($stmt === false) {
        // Check if the query preparation fails
        die("Error preparing the query: " . $conn->error);
    }

    $stmt->bind_param("i", $query_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Successful deletion, show a pop-up and redirect
        echo "<script>
                alert('Query deleted successfully.');
                window.location.href = 'query_mgmt.php'; // Redirect to query management page
              </script>";
    } else {
        // Deletion failed, show a pop-up and redirect
        echo "<script>
                alert('Error deleting query. It might not exist.');
                window.location.href = 'query_mgmt.php'; // Redirect to query management page
              </script>";
    }

    $stmt->close();
} else {
    // Invalid query ID, show a pop-up and redirect
    echo "<script>
            alert('Invalid query ID.');
            window.location.href = 'query_mgmt.php'; // Redirect to query management page
          </script>";
}

$conn->close();
?>
