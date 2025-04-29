<?php
session_start();

// Check if the user is logged in as either admin or staff
if (!(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) && !(isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true)) {
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
    <title>Query Management - Admin/Staff Dashboard</title>
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
        <h2>Query Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Query</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Updated query to fetch customer queries from the correct table
                $query = "SELECT q.query_id, u.username AS customer_name, q.subject AS query, q.status 
                          FROM queries7 q 
                          LEFT JOIN user_roles1 u ON q.customer_id = u.user_id"; 

                $result = $conn->query($query); // Execute the query

                if ($result === false) {
                    // Output error message if query fails
                    echo "Error executing query: " . $conn->error;
                } else {
                    // Loop through each query record and display it in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['customer_name']) . "</td>
                            <td>" . htmlspecialchars($row['query']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                            <td>
                                <a href='resolve_query.php?id={$row['query_id']}'>Resolve</a> | 
                                <a href='delete_query.php?id={$row['query_id']}'>Delete</a>
                            </td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>
