<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: loginc.php");
    exit;
}

// Include the database connection file
include 'db_connect.php';

// Check user role (admin or staff)
$user_role = $_SESSION['user_role']; // Assuming the role is stored in the session

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management</title>
    <link rel="stylesheet" href="dash.css"> <!-- Your stylesheets here -->
    <link rel="icon" type="image/x-icon" href="bingo.PNG"> <!-- Your favicon here -->
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
        <h2>Blog Management</h2>
        
        <!-- Optionally, show an Add Blog button based on the user's role -->
        <?php if ($user_role === 'admin') { ?>
            <a href="add_blog.php">Add New Blog</a>
        <?php } ?>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to get all blog posts from the database
                $query = "SELECT * FROM blog_posts";
                $result = $conn->query($query);

                // Loop through and display each blog post
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['title']) . "</td>
                        <td>" . htmlspecialchars($row['author']) . "</td>
                        <td>" . htmlspecialchars($row['published_date']) . "</td>
                        <td>";
                    
                    // Show actions based on the user's role (Admin and Staff can edit, Admin can delete)
                    echo "<a href='edit_blog.php?id={$row['post_id']}'>Edit</a> | ";
                    if ($user_role === 'admin') {
                        echo "<a href='delete_blog.php?id={$row['post_id']}'>Delete</a>";
                    }
                    echo "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>
