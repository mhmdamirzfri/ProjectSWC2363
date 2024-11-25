<?php
include 'db.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user ID from session
$user_id = $_SESSION['user_id'];

// Check the user's subscription status
$result = $conn->query("SELECT subscription_status FROM Users WHERE id = '$user_id'");
$user = $result->fetch_assoc();

// If the user is not subscribed, redirect to the subscription page
if ($user['subscription_status'] !== 'active') {
    header("Location: subscribe.php");
    exit();
}

// Get article details from the database
$article_id = $_GET['id']; // Assuming the article ID is passed in the URL
$article_result = $conn->query("SELECT * FROM Articles WHERE id = '$article_id'");
$article = $article_result->fetch_assoc();

// If article doesn't exist, show a 404 page or redirect
if (!$article) {
    echo "Article not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?> - SmartNews</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 1em; text-align: center; }
        nav a { color: white; margin: 0 1em; text-decoration: none; }
        header nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }
        article { max-width: 800px; margin: auto; padding: 20px; background-color: white; border: 1px solid #ddd; }
        h2 { color: #333; }
        p { color: #555; line-height: 1.6; }
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

    <article>
        <h2><?php echo htmlspecialchars($article['title']); ?></h2>
        <p><strong>By <?php echo htmlspecialchars($article['username']); ?></strong></p>
        <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
    </article>
</body>
</html>
