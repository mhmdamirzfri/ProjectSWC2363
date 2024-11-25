<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM Admins WHERE username='$username' AND password='$password'");
    if ($result->num_rows > 0) {
        $_SESSION['admin_id'] = $result->fetch_assoc()['id'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews - Admin Login</title>
    <style>
        h1 {text-align: center;}
        body { font-family: Arial, sans-serif; }
        .form-container { width: 300px; margin: auto; padding: 20px; border: 1px solid #ddd; }
        input { width: 94%; padding: 10px; margin: 10px 0; }
        button { padding: 10px; background-color: #333; color: white; border: none; }
        footer{ text-align: center;}
    </style>
</head>
<body>
    <header>
        <h1>Admin Login</h1>
    </header>

    <div class="form-container">
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <?php if (isset($error)) echo "<p>$error</p>"; ?>
        </form>
    </div>
    <footer><div class="admin-link">
        <p>Not an admin? <a href="login.php">Login here</a></p>
    </div></footer>
    
</body>
</html>
