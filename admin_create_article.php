<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle article creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['admin_id']; // Assuming the admin is the author
    $date_posted = date("Y-m-d H:i:s");
    $image_path = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image'];
    $image_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array(strtolower($image_extension), $allowed_extensions)) {
        // Ensure the uploads directory exists
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true); // Create the uploads directory
        }

        // Generate a unique file name and save the image
        $image_path = 'uploads/' . uniqid('article_', true) . '.' . $image_extension;
        if (!move_uploaded_file($image['tmp_name'], $image_path)) {
            die("Error moving uploaded file. Check directory permissions.");
        }
    } else {
        die("Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.");
    }
} else {
    die("Image upload error: " . $_FILES['image']['error']);
}


    // Insert the new article into the database
    $stmt = $conn->prepare("INSERT INTO Articles (title, content, author_id, date_posted, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $title, $content, $author_id, $date_posted, $image_path);

    if ($stmt->execute()) {
        echo "<p>Article created successfully!</p>";
    } else {
        echo "<p>Error creating article: " . $conn->error . "</p>";
    }
    $stmt->close();

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true); // Create the uploads directory with permissions
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews - Create Article</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 1em; text-align: center; }
        nav a { color: white; margin: 0 1em; text-decoration: none; }
        .form-container { width: 80%; max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; }
        button { padding: 10px 15px; background-color: #333; color: white; border: none; }
        h1 { color: white; }
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

    <div class="form-container">
        <h2>Article Details</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="title">Article Title</label>
            <input type="text" name="title" id="title" required>

            <label for="content">Article Content</label>
            <textarea name="content" id="content" rows="10" required></textarea>

            <label for="image">Article Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <button type="submit">Create Article</button>
        </form>
    </div>
</body>
</html>
