<?php
// Database connection
include 'db_connect.php';

// Query to fetch class schedule
$query = "SELECT class_name, date, time, instructor, location, status FROM class_schedules6";
$result = $conn->query($query);

// Check if the query was successful
if ($result === false) {
    // Output the SQL error for debugging purposes
    die("SQL Error: " . $conn->error);
}

// Fetch and display class schedule records
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Schedule - Customer Dashboard</title>
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
        <h2>Class Schedule</h2>
        <table>
            <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Instructor</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Loop through and display each class schedule record
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['class_name']) . "</td>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                            <td>" . htmlspecialchars($row['time']) . "</td>
                            <td>" . htmlspecialchars($row['instructor']) . "</td>
                            <td>" . htmlspecialchars($row['location']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No class schedules found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>
