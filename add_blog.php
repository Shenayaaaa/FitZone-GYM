<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php';

// Check user role (admin or staff)
$user_role = $_SESSION['user_role'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the new blog post values from the form
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];
    $published_date = date('Y-m-d'); // Automatically set the current date

    // Insert the new blog post into the database
    $insert_query = "INSERT INTO blog_posts (title, author, content, published_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssss", $title, $author, $content, $published_date);

    if ($stmt->execute()) {
        header("Location: blog_management.php");
        exit;
    } else {
        echo "Error adding post: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Blog</title>
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
        <h2>Add New Blog Post</h2>
        <form action="add_blog.php" method="POST">
            <label>Title:</label>
            <input type="text" name="title" required>

            <label>Author:</label>
            <input type="text" name="author" required>

            <label>Content:</label>
            <textarea name="content" required></textarea>

            <button type="submit">Add Blog Post</button>
        </form>
    </section>
</body>
</html>
