<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: loginc.php");
    exit;
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

    <h1 style="text-align: center;">Welcome to the Admin Dashboard</h1>
   
    <section class="dashboardA">
        <div class="card">
            <h3>Manage Staff</h3>
            <a href="view_staff.php">View Staff</a> | <a href="add_staff.php">Add Staff</a>  | <a href="edit_staff.php">Edit Staff</a> | <a href="delete_staff.php">Delete Staff</a>
        </div>
        <div class="card">
            <h3>Manage Customers</h3>
            <a href="cust_mgmt.php">View Customers</a> | <a href="add_customer.php">Add Customer</a>| <a href="edit_customer.php">Edit Customer</a>| <a href="delete_customer.php">Delete Customer</a>
        </div>
        <div class="card">
            <h3>Manage Membership Plans</h3>
            <a href="membership_mgmt.php">View Membership Plans</a> | <a href="add_membership.php">Add Plan</a>| <a href="delete_membership.php">Delete Plan</a>| <a href="edit_membership.php">Edit Plan</a>
            
        </div>
        <div class="card">
            <h3>Appointments Overview</h3>
            <a href="appt_overview.php">View Appointments</a>| <a href="edit_appointment.php">Edit Appointment</a>| <a href="delete_appointment.php">Delete Appointment</a>
            
        </div>
        <div class="card">
            <h3>Class Schedule</h3>
            <a href="sched_mgmt.php">View / Add Schedule</a> |<a href="delete_sched.php">delete / Add Schedule</a> 
        </div>
        <div class="card">
            <h3>Blog Management</h3>
            <a href="blog_mgmt.php">Manage Blog</a> | <a href="add_blog.php">Add New Blog</a>| <a href="edit_blog.php">Edit Blog</a>| <a href="delete_blog.php">Delete Blog</a>
        </div>
        <div class="card">
            <h3>query Management</h3>
            <a href="query_mgmt.php">View Queries</a>|  <a href="resolve_.php">Resolve Queries</a>| <a href="delete_query.php">Delete Queries</a>
        </div>
    </section>
</body>
</html>
