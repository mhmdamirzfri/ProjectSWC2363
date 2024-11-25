<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM Users WHERE id=$user_id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews</title>
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
        <h1>SmartNews</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="profile.php">Profile</a>            
            <a href="articles.php">Articles</a>
            <a href="subscribe.php">Subscribe</a>
            <a href="logout.php">Logout</a>

        </nav>
    </header>

    <div class="profile-container">
        <h2>Your Profile</h2>
        <div class="profile-details">
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Subscription Status:</strong> <?php echo $user['subscription_status']; ?></p>
        </div>
        <div class="profile-actions">
            <a href="edit_profile.php">Edit Profile</a>
        </div>
    </div>
</body>
</html>
