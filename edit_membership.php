<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Include database connection

// Check if the membership ID is provided
if (!isset($_GET['id'])) {
    echo "Invalid membership ID.";
    exit;
}

$membership_id = intval($_GET['id']);

// Handle the form submission to update membership details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $benefits = $_POST['benefits'];
    $duration = $_POST['duration'];

    $query = "UPDATE membership_plans 
              SET name = ?, price = ?, benefits = ?, duration = ? 
              WHERE membership_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sisii", $name, $price, $benefits, $duration, $membership_id);

    if ($stmt->execute()) {
        echo "Membership plan updated successfully!";
        header("Location: membership_mgmt.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch the current details of the membership plan
$query = "SELECT * FROM membership_plans WHERE membership_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $membership_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Membership plan not found.";
    exit;
}

$membership = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Membership</title>
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
    <section>
        <h2>Edit Membership Plan</h2>
        <form action="edit_membership.php?id=<?php echo $membership_id; ?>" method="POST">
            <label for="name">Plan Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($membership['name']); ?>" required>
            
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($membership['price']); ?>" required>
            
            <label for="benefits">Benefits:</label>
            <textarea id="benefits" name="benefits" required><?php echo htmlspecialchars($membership['benefits']); ?></textarea>
            
            <label for="duration">Duration (in days):</label>
            <input type="number" id="duration" name="duration" value="<?php echo htmlspecialchars($membership['duration']); ?>" required>
            
            <button type="submit">Update Membership</button>
        </form>
    </section>
</body>
</html>
