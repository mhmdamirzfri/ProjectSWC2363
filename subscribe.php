<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = $_SESSION['user_id'];
    $subscription_type = $_POST['subscription_type'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $billing_address = $_POST['billing_address'];
    
    // Calculate subscription dates
    $start_date = date("Y-m-d");
    $end_date = ($subscription_type == "monthly") ? date("Y-m-d", strtotime("+1 month")) : date("Y-m-d", strtotime("+1 year"));

    // Simulate payment (add actual payment processing here with payment gateway API)
    // Insert subscription into the database
    $conn->query("INSERT INTO Subscriptions (user_id, status, start_date, end_date, subscription_type) VALUES ('$user_id', 'active', '$start_date', '$end_date', '$subscription_type')");
    $conn->query("UPDATE Users SET subscription_status='active' WHERE id='$user_id'");

    $_SESSION['subscription_status'] = 'active';
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNews - Subscribe</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #333; color: white; padding: 1em; text-align: center; }
        nav a { color: white; margin: 0 1em; text-decoration: none; }
        form { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; background-color: white; }
        label { display: block; margin: 10px 0; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; background-color: #333; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #444; }
    </style>
</head>
<body>
    <header>
        <h1>SmartNews</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="profile.php">Profile</a>
            <a href="articles.php">Articles</a>
            <a href="Subscribe.php">Subscribe</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <form method="POST">
        <h2>Personal Information</h2>
        <label for="full_name">Full Name</label>
        <input type="text" name="full_name" id="full_name" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" required>

        <label for="phone">Phone Number (Optional)</label>
        <input type="text" name="phone" id="phone">

        <label for="address">Billing Address</label>
        <input type="text" name="address" id="address" required>

        <h2>Subscription Details</h2>
        <label for="subscription_type">Subscription Type</label>
        <select name="subscription_type" id="subscription_type" required>
            <option value="monthly">Monthly - $5</option>
            <option value="yearly">Yearly - $50</option>
        </select>

        <h2>Payment Information</h2>
        <label for="payment_method">Payment Method</label>
        <select name="payment_method" id="payment_method" required>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
        </select>

        <div id="credit_card_fields">
            <label for="card_number">Card Number</label>
            <input type="text" name="card_number" id="card_number" required>

            <label for="expiry_date">Expiration Date (MM/YY)</label>
            <input type="text" name="expiry_date" id="expiry_date" required>

            <label for="cvv">CVV</label>
            <input type="text" name="cvv" id="cvv" required>
        </div>

        <label for="billing_address">Billing Address</label>
        <input type="text" name="billing_address" id="billing_address" required>

        <h2>Terms and Conditions</h2>
        <label>
            <input type="checkbox" name="agree_terms" required> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
        </label>

        <button type="submit">Subscribe</button>
    </form>

    <script>
        // Show/hide credit card fields based on payment method
        document.getElementById('payment_method').addEventListener('change', function() {
            if (this.value === 'credit_card') {
                document.getElementById('credit_card_fields').style.display = 'block';
            } else {
                document.getElementById('credit_card_fields').style.display = 'none';
            }
        });
    </script>
</body>
</html>
