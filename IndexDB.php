<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['customer_logged_in']) || $_SESSION['customer_logged_in'] !== true) {
    header("Location: Index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
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

    <h1 style="text-align: center;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    
    <section class="dashboardB">
        <div class="card4">
            <h3>Membership Plans</h3>
            <a href="mem_plans.php">View Membership Plans</a>
        </div>
        <div class="card4">
            <h3>Book an Appointment</h3>
            <a href="booking.php">Schedule an Appointment</a>
        </div>
        <div class="card4">
            <h3>Class Schedule</h3>
            <a href="class_sched.php">View Class Schedule</a>
        </div>
       
        <div class="card4">
            <h3>Blog</h3>
            <a href="blogcus.php">Read Our Blogs</a>| <a href="add_blog.php">Add New Blog| <a href="edit_blog.php">Edit Blog</a>
        </div>
        <div class="card4">
            <h3>Submit a Query</h3>
            <a href="query_sub.php">Submit Your Query</a>
        </div>
    </section>
</body>
</html>
