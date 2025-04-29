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
    // Collect the data from the form
    $class_name = $_POST['class_name'];
    $instructor = $_POST['instructor'];
    $day = $_POST['day'];
    $time = $_POST['time'];

    // Prepare the query to insert the data into the class_schedule table
    $query = "INSERT INTO class_schedule (class_name, instructor, day, time) VALUES (?, ?, ?, ?)";

    // Initialize a prepared statement
    $stmt = $conn->prepare($query);

    // Bind the parameters to the query
    $stmt->bind_param("ssss", $class_name, $instructor, $day, $time);

    // Execute the query
    if ($stmt->execute()) {
        $message = "Class added successfully!";
        $redirect_url = "staffDB.php"; // Set the redirect URL
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
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
            <label>Instructor:</label>
            <input type="text" name="instructor" required>
            <label>Day:</label>
            <input type="text" name="day" required>
            <label>Time:</label>
            <input type="text" name="time" required>
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
