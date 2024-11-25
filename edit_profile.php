<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user data from the database to pre-populate the form
$result = $conn->query("SELECT * FROM Users WHERE id = '$user_id'");
$user = $result->fetch_assoc();

// Update profile when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture the form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cancel_subscription = isset($_POST['cancel_subscription']) ? true : false;

    // Validate inputs
    if (empty($username) || empty($email)) {
        echo "Username and Email are required.";
    } else {
        // Prepare query for updating the user's details
        if ($password) {
            // If password is provided, update the password field (hash it for security)
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE Users SET username = ?, email = ?, password = ? WHERE id = ?");
            $stmt->bind_param("sssi", $username, $email, $hashed_password, $user_id);
        } else {
            // If no password is provided, only update the username and email
            $stmt = $conn->prepare("UPDATE Users SET username = ?, email = ? WHERE id = ?");
            $stmt->bind_param("ssi", $username, $email, $user_id);
        }

        // Execute the query to update the user's details
        if ($stmt->execute()) {
            // If subscription cancellation is selected, update subscription status
            if ($cancel_subscription) {
                $stmt = $conn->prepare("UPDATE Users SET subscription_status = 'inactive' WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
            }

            echo "Profile updated successfully.";
            header("Location: profile.php");
            exit();
        } else {
            echo "Error updating profile: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 1em;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 1em;
            text-decoration: none;
        }
        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: white;
            text-align: center;
        }

        h2 {
            color: #333;
            text-align: center;
        }
        
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="checkbox"] {
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #555;
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
        <h2>Edit Profile</h2>

        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Leave empty if you don't want to change the password">

            <label for="cancel_subscription">Cancel Subscription:</label>
            <input type="checkbox" name="cancel_subscription" id="cancel_subscription">

            <button type="submit">Update Profile</button>
        </form>
    </main>
</body>
</html>
