<?php
session_start();

// Check if the staff member is logged in
if (!isset($_SESSION['staff_logged_in']) || $_SESSION['staff_logged_in'] !== true) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Ensure that the database connection is included
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management Dashboard</title>
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
        <h2>Staff Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Expertise</th>
                    <th>Contact Info</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM staff_profiles"; // Query to fetch staff details
                $result = $conn->query($query); // Execute the query

                while ($row = $result->fetch_assoc()) {
                    // Display each staff record
                    echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['position']) . "</td>
                        <td>" . htmlspecialchars($row['expertise']) . "</td>
                        <td>" . htmlspecialchars($row['contact_info']) . "</td>
                        <td>
                            <a href='edit_staff.php?id={$row['staff_id']}'>Edit</a> | 
                            <a href='delete_staff.php?id={$row['staff_id']}'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>
