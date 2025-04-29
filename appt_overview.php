<?php
session_start();

// Check if the user is logged in as either an admin or staff member
if (!(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) && !(isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true)) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Ensure that the database connection is included

// Query to fetch appointment details, including customer and trainer names, from the correct tables
$query = "
    SELECT a.appointment_id, u.username AS customer_name, sp.name AS trainer_name, a.appointment_date, a.status, sp.staff_id 
    FROM appointments5 a
    LEFT JOIN user_roles1 u ON a.customer_id = u.user_id
    LEFT JOIN staff_profiles3 sp ON a.staff_id = sp.staff_id
";
$result = $conn->query($query);

// Check for query errors
if (!$result) {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Overview</title>
    <link rel="stylesheet" href="dash.css">
    <link rel="icon" type="image/x-icon" href="bingo.PNG">
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
        <h2>Appointments Overview</h2>
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Trainer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each appointment record and display it in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['customer_name']) . "</td>
                        <td>" . htmlspecialchars($row['trainer_name']) . "</td>
                        <td>" . htmlspecialchars($row['appointment_date']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>";

                    // Check if the logged-in user is an admin
                    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
                        // Admin can edit and delete appointments
                        echo "<a href='edit_appointment.php?id={$row['appointment_id']}'>Edit</a> | 
                              <a href='delete_appointment.php?id={$row['appointment_id']}'>Delete</a>";
                    } elseif (isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true) {
                        // Staff can only edit and delete their own appointments
                        // The staff member must match the staff_id from staff_profiles3
                        if ($row['staff_id'] == $_SESSION['staff_id']) {
                            echo "<a href='edit_appointment.php?id={$row['appointment_id']}'>Edit</a> | 
                                  <a href='delete_appointment.php?id={$row['appointment_id']}'>Delete</a>";
                        } else {
                            echo "No Actions Available";
                        }
                    }
                    echo "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
