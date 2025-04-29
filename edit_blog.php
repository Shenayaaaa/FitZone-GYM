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

// Fetch the blog post data if the ID is set
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $query = "SELECT * FROM blog_posts WHERE post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No post found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated values from the form
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];

    // Update the blog post in the database
    $update_query = "UPDATE blog_posts SET title = ?, author = ?, content = ? WHERE post_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $title, $author, $content, $post_id);

    if ($stmt->execute()) {
        header("Location: blog_management.php");
        exit;
    } else {
        echo "Error updating post: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post</title>
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
        <h2>Edit Blog Post</h2>
        <form action="edit_blog.php?id=<?php echo $post_id; ?>" method="POST">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>

            <label>Author:</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($row['author']); ?>" required>

            <label>Content:</label>
            <textarea name="content" required><?php echo htmlspecialchars($row['content']); ?></textarea>

            <button type="submit">Update Post</button>
        </form>
    </section>
</body>
</html>
