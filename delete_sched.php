<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in as Admin or Staff
if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['staff_logged_in'])) {
    header("Location: loginc.php");
    exit;
}

// Handle class deletion
if (isset($_GET['delete_id'])) {
    $class_id = intval($_GET['delete_id']); // Sanitize the ID

    $delete_query = "DELETE FROM class_schedule WHERE class_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $class_id);

    if ($stmt->execute()) {
        header("Location: class_schedule.php?msg=Class deleted successfully");
        exit;
    } else {
        $error_msg = "Failed to delete the class.";
    }
}

// Handle adding a new class
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_name = $_POST['class_name'];
    $instructor = $_POST['instructor'];
    $day = $_POST['day'];
    $time = $_POST['time'];

    $insert_query = "INSERT INTO class_schedule (class_name, instructor, day, time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssss", $class_name, $instructor, $day, $time);

    if ($stmt->execute()) {
        header("Location: class_schedule.php?msg=Class added successfully");
        exit;
    } else {
        $error_msg = "Failed to add the class.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Schedule</title>
    <link rel="stylesheet" href="dash.css">
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

    <main>
        <section>
            <h2>Class Schedule</h2>
            <?php
            // Display success or error messages
            if (isset($_GET['msg'])) {
                echo "<p style='color: green;'>{$_GET['msg']}</p>";
            }
            if (isset($error_msg)) {
                echo "<p style='color: red;'>$error_msg</p>";
            }
            ?>

            <table>
                <thead>
                    <tr>
                        <th>Class Name</th>
                        <th>Instructor</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM class_schedule";
                    $result = $conn->query($query);

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['class_name']}</td>
                            <td>{$row['instructor']}</td>
                            <td>{$row['day']}</td>
                            <td>{$row['time']}</td>
                            <td>
                                <a href='edit_class.php?id={$row['class_id']}'>Edit</a> | 
                                <a href='class_schedule.php?delete_id={$row['class_id']}' onclick='return confirm(\"Are you sure you want to delete this class?\");'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Add New Class</h2>
            <form action="class_schedule.php" method="POST">
                <label>Class Name:</label>
                <input type="text" name="class_name" required>

                <label>Instructor:</label>
                <input type="text" name="instructor" required>

                <label>Day:</label>
                <input type="text" name="day" required>

                <label>Time:</label>
                <input type="text" name="time" required>

                <button type="submit">Add Class</button>
            </form>
        </section>
    </main>
</body>
</html>
