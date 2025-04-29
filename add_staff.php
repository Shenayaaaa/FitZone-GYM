<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /fitzone77/Index.php"); // Redirect if not logged in or not an admin
    exit();
}

// Handle adding a new staff member
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include 'DB_connect.php'; // Include your database connection

    $username = trim($_POST['username']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Hash password
    $created_at = date("Y-m-d H:i:s");

    // Insert the new staff into the database
    $stmt = $conn->prepare("INSERT INTO user_roles1 (username, email, password, role, created_at) VALUES (?, ?, ?, 'staff', ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $created_at);

    if ($stmt->execute()) {
        echo "<script>alert('Staff added successfully'); window.location.href='view_staff.php';</script>";
    } else {
        echo "<script>alert('Error adding staff'); window.location.href='add_staff.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff - Admin Dashboard</title>
    <link rel="stylesheet" href="FitZone.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="AdminDB.php"><span class="fitzone">FitZone</span> <span class="fitness">Fitness</span></a>
            </div>
            <ul class="navbar-links">
                <li><a href="AdminDB.php">Dashboard</a></li>
                <li><a href="view_staff.php">View Staff</a></li>
            </ul>
        </nav>
    </header>

    <section class="admin-dashboard">
        <h1>Add New Staff</h1>

        <!-- Add Staff Form -->
        <form action="add_staff.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Add Staff</button>
        </form>
    </section>
</body>
</html>
