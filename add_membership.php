<?php
session_start();

// Check if the staff member is logged in
if (!isset($_SESSION['staff_logged_in']) || $_SESSION['staff_logged_in'] !== true) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Ensure that the database connection is included

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect form data
    $name = $conn->real_escape_string($_POST['name']);
    $price = $conn->real_escape_string($_POST['price']);
    $benefits = $conn->real_escape_string($_POST['benefits']);
    $duration = $conn->real_escape_string($_POST['duration']);

    // Prepare SQL query to insert the new membership plan into the database
    $query = "INSERT INTO membership_plans (name, price, benefits, duration) 
              VALUES ('$name', '$price', '$benefits', '$duration')";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('New membership plan added successfully!');</script>";
        echo "<script>window.location.href = 'membership_management.php';</script>";  // Redirect to membership management page
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Membership Plan</title>
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
        <h2>Add Membership Plan</h2>
        <form action="add_membership.php" method="POST">
            <label>Plan Name:</label>
            <input type="text" name="name" required>
            
            <label>Price:</label>
            <input type="number" step="0.01" name="price" required>
            
            <label>Benefits:</label>
            <textarea name="benefits" required></textarea>
            
            <label>Duration (in days):</label>
            <input type="number" name="duration" required>
            
            <button type="submit">Add Plan</button>
        </form>
    </section>
</body>
</html>
