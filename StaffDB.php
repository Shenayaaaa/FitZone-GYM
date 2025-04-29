<?php
session_start();

// Check if the staff member is logged in
if (!isset($_SESSION['staff_logged_in']) || $_SESSION['staff_logged_in'] !== true) {
    header("Location: loginc.php");
    exit;
}
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

    <h1 style="text-align: center;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <section class="staffDashboard">
        <div class="staffCard">
            <h3>Manage Appointments</h3>
            <a href="appt_overview.php">View Appointments</a>| <a href="edit_appointment.php">Edit Appointment</a>| <a href="delete_appointment.php">Delete Appointment</a>
            
        </div>
        <div class="staffCard">
            <h3>Manage Queries</h3>
            <a href="query_mgmt.php">View Queries</a>
            </div>    
        <div class="staffCard">
            <h3>Class Schedule</h3>
            <a href="add_class.php">View /Add Schedule</a>|<a href="delete_sched.php">delete / Add Schedule</a> 
            </div>
        </div>
        <div class="staffCard">
            <h3>Blog Management</h3>
            <a href="blog_mgmt.php">Manage Blog</a> | <a href="add_blog.php">Add New Blog</a>| <a href="edit_blog.php">Edit Blog</a>| <a href="delete_blog.php">Delete Blog</a>
        </div>
        <div class="staffCard">
            <h3>Manage Customers</h3>
            <a href="customer_mgmt.php">View Customers profiles</a> 
        </div>
    </section>

</body>
</html>
