<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
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
    <title>Membership Management</title>
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
        <h2>Membership Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Plan Name</th>
                    <th>Price</th>
                    <th>Benefits</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM membership_plans"; // Query to fetch membership plan details
                $result = $conn->query($query); // Execute the query

                // Loop through each membership plan record and display it in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['price']) . "</td>
                        <td>" . htmlspecialchars($row['benefits']) . "</td>
                        <td>" . htmlspecialchars($row['duration']) . " days</td>
                        <td>
                            <a href='edit_membership.php?id={$row['membership_id']}'>Edit</a> | 
                            <a href='delete_membership.php?id={$row['membership_id']}'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>
