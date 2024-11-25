<?php
include 'db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews - Home</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        header { background-color: #333; color: white; padding: 1em; text-align: center; }
        nav a { color: white; margin: 0 1em; text-decoration: none; }
        main { padding: 20px; }
        
        .article-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        
        .article {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            width: 30%; /* 3 articles per row */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .article:hover {
            transform: translateY(-5px); /* Hover effect */
        }
        
        .article img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        
        .article h3 {
            font-size: 1.5em;
            margin-top: 10px;
        }
        
        .article-preview {
            font-size: 16px;
            margin: 10px 0;
        }

        .article a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #007BFF;
        }

        .article a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>SmartNews</h1>
        <nav>
            <a href="index.php">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php">Profile</a>
                <a href="articles.php">Articles</a>
                <a href="subscribe.php">Subscribe</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <h2>Latest Articles</h2>
        <?php
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

        // Fetch the 3 latest articles
        $articles_result = $conn->query("SELECT * FROM Articles ORDER BY created_at DESC LIMIT 3");

        echo "<div class='article-container'>";
        while ($article = $articles_result->fetch_assoc()) {
            echo "<div class='article'>";

            // Display article image if available
            if (!empty($article['image_path'])) {
                echo "<img src='uploads/" . htmlspecialchars($article['image_path']) . "' alt='" . htmlspecialchars($article['title']) . "'>";
            }

            echo "<h3>" . htmlspecialchars($article['title']) . "</h3>";

            // Display a preview of the article content (first 200 characters)
            $content_preview = substr($article['content'], 0, 200) . '...';
            echo "<p class='article-preview'>" . htmlspecialchars($content_preview) . "</p>";

            // Show a 'Read More' link only if the user is subscribed
            if ($user['subscription_status'] === 'active') {
                echo "<a href='article.php?id=" . $article['id'] . "'>Read More</a>";
            } else {
                echo "<p>You need to subscribe to read the full article. <a href='subscribe.php'>Subscribe Now</a></p>";
            }

            echo "</div>";
        }
        echo "</div>";
        ?>
    </main>
</body>
</html>
