<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Blogs - Customer Dashboard</title>
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
        <h2>Our Blogs</h2>
        <div class="blog-container">
            <?php
            // Include database connection
            include 'db_connect.php';

            // Query to fetch all blog posts with status = 'published' in descending order of posted_at
            $query = "SELECT * FROM blogs8 WHERE status = 'published' ORDER BY posted_at DESC";
            $result = $conn->query($query);

            // Check if any results were returned
            if ($result->num_rows > 0) {
                // Loop through each blog post and display the details
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='blog-card'>
                        <h3>" . htmlspecialchars($row['title']) . "</h3>
                        <p>By Author ID " . htmlspecialchars($row['author_id']) . " on " . htmlspecialchars($row['posted_at']) . "</p>
                        <p>" . htmlspecialchars(substr($row['content'], 0, 100)) . "...</p>
                        <a href='Blog.html?id=" . htmlspecialchars($row['blog_id']) . "'>Read More</a>
                    </div>";
                }
            } else {
                echo "<p>No blogs available at the moment. Please check back later!</p>";
            }

            // Free the result and close the database connection
            $result->free();
            $conn->close();
            ?>
        </div>
    </section>
</body>
</html>
