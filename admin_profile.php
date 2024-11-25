<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = $conn->query("SELECT * FROM Admins WHERE id=$admin_id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews - Admin Profile</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 1em; text-align: center; }
        nav a { color: white; margin: 0 1em; text-decoration: none; }

        .profile-container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .profile-container h2 {
            text-align: center;
            color: #333;
        }
        .profile-details {
            margin: 20px 0;
        }
        .profile-details p {
            font-size: 16px;
            margin: 10px 0;
        }
        .profile-details a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }
        .profile-details a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>SmartNews - Admin</h1>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_manage_articles.php">Manage Articles</a>
            <a href="admin_manage_users.php">Manage Users</a>
            <a href="admin_manage_subscriptions.php">Manage Subscriptions</a>
            <a href="admin_profile.php">Profile</a>
            <a href="admin_logout.php">Logout</a>
        </nav>
    </header>

    <div class="profile-container">
        <h2>Admin Profile</h2>
        <div class="profile-details">
            <p><strong>ID:</strong> <?php echo $admin['id']; ?></p> <!-- Display admin ID -->
            <p><strong>Username:</strong> <?php echo $admin['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $admin['email']; ?></p>
        </div>

    </div>
</body>
</html>
