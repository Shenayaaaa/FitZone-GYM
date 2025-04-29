<?php
// Start the session to retrieve the logged-in user's information
session_start();

// Include the database connection file
include 'db_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $trainer_id = $_POST['trainer'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Assuming the customer's ID is stored in the session
    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
    } else {
        // If no session is found, assume the user is not logged in
        echo "You must be logged in to book an appointment.";
        exit();
    }

    // Basic validation for form fields
    if (empty($trainer_id) || empty($date) || empty($time)) {
        echo "All fields are required.";
    } else {
        // Prepare the appointment date and time string
        $appointment_datetime = $date . ' ' . $time;

        // Check if the appointment already exists for the customer on the same date and time
        $check_query = "SELECT * FROM appointments5 WHERE customer_id = ? AND appointment_date = ? AND status = 'scheduled'";
        if ($stmt_check = $conn->prepare($check_query)) {
            $stmt_check->bind_param("is", $customer_id, $appointment_datetime);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                // If an appointment already exists, update it
                $update_query = "UPDATE appointments5 SET staff_id = ?, appointment_date = ?, status = 'scheduled' WHERE customer_id = ? AND appointment_date = ? AND status = 'scheduled'";

                if ($update_stmt = $conn->prepare($update_query)) {
                    $update_stmt->bind_param("issi", $trainer_id, $appointment_datetime, $customer_id, $appointment_datetime);

                    if ($update_stmt->execute()) {
                        echo "Your appointment has been updated successfully!";
                    } else {
                        echo "Error: " . $update_stmt->error;
                    }

                    // Close the update statement
                    $update_stmt->close();
                }
            } else {
                // If no existing appointment, insert a new one
                $insert_query = "INSERT INTO appointments5 (customer_id, staff_id, appointment_date, status) VALUES (?, ?, ?, 'scheduled')";

                if ($stmt_insert = $conn->prepare($insert_query)) {
                    $stmt_insert->bind_param("iis", $customer_id, $trainer_id, $appointment_datetime);

                    if ($stmt_insert->execute()) {
                        echo "Your appointment has been booked successfully!";
                    } else {
                        echo "Error: " . $stmt_insert->error;
                    }

                    // Close the insert statement
                    $stmt_insert->close();
                }
            }

            // Close the check statement
            $stmt_check->close();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <link rel="stylesheet" href="booking.css"> <!-- Add your CSS file if you have one -->
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php">FitZone Fitness</a> <!-- Your logo or home link -->
            </div>
            <ul>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Book an Appointment</h2>
        <form action="add_booking.php" method="POST">
            <label>Trainer:</label>
            <select name="trainer" required>
                <?php
                // Fetch trainers from the database
                $query = "SELECT * FROM staff_profiles WHERE position='Trainer'";
                $result = $conn->query($query);

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['staff_id']}'>{$row['name']} - {$row['expertise']}</option>";
                }
                ?>
            </select>

            <label>Date:</label>
            <input type="date" name="date" required>

            <label>Time:</label>
            <input type="time" name="time" required>

            <button type="submit">Book Appointment</button>
        </form>
    </section>
</body>
</html>
