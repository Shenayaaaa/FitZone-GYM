<?php
session_start();

// Check if the user is logged in as either staff or admin
if (!(isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true) && !(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true)) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $membership_id = $_POST['membership_id'];
    $contact_info = $_POST['contact_info'];

    // Insert data into the database
    $query = "INSERT INTO customers (name, age, gender, membership_id, contact_info) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sisis', $name, $age, $gender, $membership_id, $contact_info);

    if ($stmt->execute()) {
        // Redirect to customer management page after successful insertion
        header("Location: customer_management.php");
        exit;
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
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
        <h2>Add Customer</h2>
        <form action="add_customer.php" method="POST">
            <label>Name:</label>
            <input type="text" name="name" required>
            
            <label>Age:</label>
            <input type="number" name="age" required>
            
            <label>Gender:</label>
            <select name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            
            <label>Membership ID:</label>
            <input type="number" name="membership_id" required>
            
            <label>Contact Info:</label>
            <input type="text" name="contact_info" required>
            
            <button type="submit">Add Customer</button>
        </form>
    </section>
</body>
</html>
