<?php
session_start();

// Check if the user is logged in as either admin or staff
if (!(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) && !(isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true)) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Ensure that the database connection is included

// Check if 'id' is passed via GET
if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // Fetch the appointment details based on the provided ID
    $query = "SELECT a.appointment_id, u.username AS customer_name, sp.name AS trainer_name, a.appointment_date, a.status, a.staff_id 
              FROM appointments5 a
              LEFT JOIN user_roles1 u ON a.customer_id = u.user_id
              LEFT JOIN staff_profiles3 sp ON a.staff_id = sp.staff_id
              WHERE a.appointment_id = ?";

    // Prepare and bind parameters for the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any results are returned
    if ($result->num_rows > 0) {
        $appointment = $result->fetch_assoc();
        
        // Extract time from the appointment_date
        $appointment_date = $appointment['appointment_date'];
        $time = date('H:i', strtotime($appointment_date)); // Extract time part from appointment_date
    } else {
        echo "No data found for the provided appointment ID.";
        exit;
    }

    // If form is submitted, update appointment data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $customer_name = $_POST['customer_name'];  // This will just capture the input
        $trainer_name = $_POST['trainer_name'];    // This will just capture the input
        $date = $_POST['date'];
        $time = $_POST['time'];
        $status = $_POST['status'];

        // Combine date and time for appointment update
        $appointment_datetime = $date . ' ' . $time;

        // Update query
        $update_query = "UPDATE appointments5 SET appointment_date = ?, status = ? WHERE appointment_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssi", $appointment_datetime, $status, $appointment_id);
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            echo "Appointment details updated successfully.";
        } else {
            echo "Error updating appointment details.";
        }
    }
} else {
    echo "No appointment ID provided.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
    <link rel="stylesheet" href="dash.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="FitZone.html"><span class="fitzone">FitZone</span> <span class="fitness">Fitness</span></a>
            </div>
            <ul class="navbar-links">
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Edit Appointment</h2>
        <form action="edit_appointment.php?id=<?php echo $appointment_id; ?>" method="POST">
            <label>Customer Name:</label>
            <input type="text" name="customer_name" value="<?php echo htmlspecialchars($appointment['customer_name']); ?>" required>
            <label>Trainer Name:</label>
            <input type="text" name="trainer_name" value="<?php echo htmlspecialchars($appointment['trainer_name']); ?>" required>
            <label>Date:</label>
            <input type="date" name="date" value="<?php echo date('Y-m-d', strtotime($appointment['appointment_date'])); ?>" required>
            <label>Time:</label>
            <input type="time" name="time" value="<?php echo $time; ?>" required>
            <label>Status:</label>
            <select name="status">
                <option value="pending" <?php if ($appointment['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                <option value="confirmed" <?php if ($appointment['status'] == 'confirmed') echo 'selected'; ?>>Confirmed</option>
                <option value="completed" <?php if ($appointment['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                <option value="cancelled" <?php if ($appointment['status'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>
            <button type="submit">Update Appointment</button>
        </form>
    </section>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
