<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle subscription updates
if (isset($_POST['update_subscription'])) {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE Users SET subscription_status='$status' WHERE id='$user_id'");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews - Manage Subscriptions</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 1em; text-align: center; }
        nav a { color: white; margin: 0 1em; text-decoration: none; }
        main {
        max-width: 1500px;
        margin: 20px auto;
        padding: 15px; /* Reduced padding for the main content */

        font-size: 14px; /* Smaller font size for main content */
        }
        table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        select, button { padding: 10px; }
    </style>
</head>
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
<main>
<div>
        <h2>Manage User Subscriptions</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Subscription Status</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM Users");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['subscription_status'] . "</td>";
                    echo "<td>
                            <form method='POST'>
                                <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                                <select name='status'>
                                    <option value='active'>Active</option>
                                    <option value='inactive'>Inactive</option>
                                </select>
                                <button type='submit' name='update_subscription'>Update</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
