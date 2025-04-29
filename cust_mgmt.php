<?php
session_start();

// Check if the user is logged in as staff or admin
if (
    !(isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true) && 
    !(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true)
) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Include database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management Dashboard</title>
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
        <h2>Customer Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to fetch users with the 'customer' role
                $query = "SELECT user_id, username, email FROM user_roles1 WHERE role = 'customer'"; 
                $result = $conn->query($query); // Execute the query

                // Check if the query was successful
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        // Display each customer record
                        echo "<tr>
                            <td>" . htmlspecialchars($row['username']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>
                                <a href='edit_customer.php?id={$row['user_id']}'>Edit</a> | 
                                <a href='delete_customer.php?id={$row['user_id']}'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    // If query failed, show an error message
                    echo "<tr><td colspan='3'>Error: " . $conn->error . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>
