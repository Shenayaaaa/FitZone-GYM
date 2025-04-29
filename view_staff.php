<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /fitzone77/Index.php"); // Redirect if not logged in or not an admin
    exit();
}

// Include the database connection
include 'DB_connect.php';

// Fetch staff members from the database
$query = "SELECT user_id, username, email, created_at FROM user_roles1 WHERE role = 'staff'";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff - Admin Dashboard</title>
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
                <li><a href="add_staff.php">Add Staff</a></li>
            </ul>
        </nav>
    </header>

    <section class="admin-dashboard">
        <h1>Staff Management</h1>
        <h2>View All Staff</h2>

        <!-- Staff Table -->
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <a href="edit_staff.php?id=<?php echo $row['user_id']; ?>">Edit</a> | 
                            <a href="delete_staff.php?id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this staff member?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
