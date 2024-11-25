<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews - Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 1em; text-align: center; }
        nav a { color: white; margin: 0 1em; text-decoration: none; }
        .dashboard { padding: 20px; text-align: center; }
        .dashboard a { display: block; margin: 10px 0; }
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

    <div class="dashboard">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>Here you can manage articles, users, subscriptions, and more.</p>
    </div>
</body>
</html>
