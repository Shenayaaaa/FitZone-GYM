<?php
session_start();

// Check if the user is logged in as either admin or staff
if (!(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) && !(isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true)) {
    header("Location: loginc.php");
    exit;
}

// Include the database connection file
include 'db_connect.php';

$message = ''; // Variable to store the message to be shown in pop-up
$redirect_url = ''; // Variable to hold the URL for redirection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required form fields are set before proceeding
    if (isset($_POST['class_name'], $_POST['date'], $_POST['time'], $_POST['instructor'], $_POST['location'])) {
        // Collect the data from the form
        $class_name = $_POST['class_name'];
        $date = $_POST['date']; // The date when the class is scheduled
        $time = $_POST['time']; // The time when the class is scheduled
        $instructor = $_POST['instructor']; 
        $location = $_POST['location']; 
        $status = 'upcoming'; // Default status as upcoming

        // Prepare the query to insert the data into the class_schedules6 table
        $query = "INSERT INTO class_schedules6 (class_name, date, time, instructor, location, status) 
                  VALUES (?, ?, ?, ?, ?, ?)";

        // Initialize a prepared statement
        $stmt = $conn->prepare($query);

        // Bind the parameters to the query
        $stmt->bind_param("ssssss", $class_name, $date, $time, $instructor, $location, $status);

        // Execute the query
        if ($stmt->execute()) {
            // Message for success
            $message = "Class added successfully!";
            $redirect_url = "staffDB.php"; // Set the redirect URL to staffDB.php
            // Redirect to the same page or any other page you prefer after successful submission
            header("Location: " . $redirect_url); 
            exit(); // Make sure the script stops executing after the redirect
        } else {
            $message = "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        $message = "Error: Missing required fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Class</title>
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
        <h2>Add Class</h2>
        <form action="add_class.php" method="POST">
            <label>Class Name:</label>
            <input type="text" name="class_name" required>

            <label>Date (YYYY-MM-DD):</label>
            <input type="date" name="date" required>

            <label>Time (HH:MM:SS):</label>
            <input type="time" name="time" required>

            <label>Instructor:</label>
            <select name="instructor" required>
                <?php
                // Query to fetch users with the role 'staff'
                $query = "SELECT user_id, username FROM user_roles1 WHERE role = 'staff'";
                $result = $conn->query($query);

                // Check if the query returns any results
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Display each staff member in the dropdown
                        echo "<option value='" . $row['user_id'] . "'>" . $row['username'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No instructors available</option>";
                }
                ?>
            </select>

            <label>Location:</label>
            <input type="text" name="location" required>

            <button type="submit">Add Class</button>
        </form>
    </section>

    <!-- Pop-up for success or error message -->
    <?php if ($message): ?>
    <script>
        alert('<?php echo $message; ?>'); // Show the message
        <?php if ($redirect_url): ?>
            window.location.href = '<?php echo $redirect_url; ?>'; // Redirect to staffDB.php
        <?php endif; ?>
    </script>
    <?php endif; ?>
</body>
</html>
