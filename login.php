<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM Users WHERE username='$username'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['subscription_status'] = $user['subscription_status'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews - Login</title>
    <style>
        body { font-family: Arial, sans-serif; }
        form { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ddd; }
        input { width: 94%; padding: 10px; margin: 10px 0; }
        button { width: 100%; padding: 10px; background-color: #333; color: white; }
        .error { color: red; }
        footer {text-align: center;}
    </style>
</head>
<body>
    <h2 style="text-align: center;">Login to SmartNews</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>
    <footer>
    <div class="register">
        <p>Not registered yet? <a href="register.php">Register here</a></p>
    </div>
    <div class="admin-link">
        <p>Are you an admin? <a href="admin_login.php">Login here</a></p>
    </div>
    </footer>
</body>
</html>
