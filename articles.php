<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';
session_start();

// Check if the user is logged in and has an active subscription
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT subscription_status FROM Users WHERE id = '$user_id'");
$user = $result->fetch_assoc();

// If the user is not subscribed, redirect to the subscription page
if ($user['subscription_status'] !== 'active') {
    header("Location: subscribe.php");
    exit();
}

// Handle search query
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $search_query = mysqli_real_escape_string($conn, $search_query);
    $sql = "SELECT * FROM Articles WHERE title LIKE '%$search_query%' OR content LIKE '%$search_query%' ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM Articles ORDER BY created_at DESC";
}

$articles = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews - All Articles</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        header { background-color: #333; color: white; padding: 1em; text-align: center; }
        nav a { color: white; margin: 0 1em; text-decoration: none; }
        .container { max-width: 1000px; margin: auto; padding: 20px; background-color: white; }
        .article { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .article h3 { margin: 0; }
        .article p { color: #555; line-height: 1.6; }
        .search-bar { margin: 20px 0; text-align: center; }
        .search-bar input { width: 80%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; }
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

    <div class="container">
        <!-- Search Bar -->
        <div class="search-bar">
            <form action="articles.php" method="GET">
                <input type="text" name="search" placeholder="Search articles..." value="<?php echo htmlspecialchars($search_query); ?>" required>
            </form>
        </div>

        <h2>All Articles</h2>

        <?php if ($articles->num_rows > 0): ?>
            <?php while ($article = $articles->fetch_assoc()): ?>
                <div class="article">
                    <h3><a href="article.php?id=<?php echo $article['id']; ?>"><?php echo htmlspecialchars($article['title']); ?></a></h3>
                    <p><?php echo nl2br(htmlspecialchars(substr($article['content'], 0, 150))) . '...'; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No articles found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
