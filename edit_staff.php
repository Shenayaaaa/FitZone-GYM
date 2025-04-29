<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /fitzone77/Index.php"); // Redirect if not logged in or not an admin
    exit();
}

// Fetch and update staff details
if (isset($_GET['id'])) {
    include 'DB_connect.php'; // Include your database connection

    $user_id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Get form input and update in the database
        $username = trim($_POST['username']);
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

        $stmt = $conn->prepare("UPDATE user_roles1 SET username = ?, email = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $username, $email, $user_id);

        if ($stmt->execute()) {
            echo "<script>alert('Staff details updated successfully'); window.location.href='view_staff.php';</script>";
        } else {
            echo "<script>alert('Error updating staff'); window.location.href='edit_staff.php?id=$user_id';</script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        // Fetch current details of staff member
        $stmt = $conn->prepare("SELECT username, email FROM user_roles1 WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $email = $row['email'];
        } else {
            echo "<script>alert('Staff not found.'); window.location.href='view_staff.php';</script>";
            exit();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff - Admin Dashboard</title>
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
        <h1>Edit Staff</h1>

        <!-- Edit Staff Form -->
        <form action="edit_staff.php?id=<?php echo $user_id; ?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

            <button type="submit">Update Staff</button>
        </form>
    </section>
</body>
</html>
