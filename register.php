<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $sql = "INSERT INTO Users (username, password, email) VALUES ('$username', '$password', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews - Register</title>
    <style>
        body { font-family: Arial, sans-serif; }
        form { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ddd; }
        input { width: 94%; padding: 10px; margin: 10px 0; }
        button { width: 100%; padding: 10px; background-color: #333; color: white; }
        footer {text-align: center;}
    </style>
</head>
<body>
    <h2 style="text-align: center;">Register for SmartNews</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
    <footer><div class="login">
        <p>Already Registered? <a href="login.php">Login here</a></p>
    </div>
    <div class="admin-link">
        <p>Are you an admin? <a href="admin_login.php">Login here</a></p>
    </div></footer>
    
    
</body>
</html>
