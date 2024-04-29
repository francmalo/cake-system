<?php
session_start();



// Include the database connection file
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle sign-in form submission
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

   
    $query = "SELECT * FROM users WHERE user_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($user_password, $user['user_pasword'])) {
        // Sign-in successful
        $_SESSION['user_id'] = $user['user_id'];
        header('Location: checkout.php');
        exit;
    } else {
        // Invalid credentials
        $error = 'Invalid email or password';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign In</title>
</head>

<body>
    <h1>Sign In</h1>
    <?php if (isset($error)) echo '<p>' . $error . '</p>'; ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Email:</label>
        <input type="email" name="user_email" required>
        <br>
        <label>Password:</label>
        <input type="password" name="user_password" required>
        <br>
        <input type="submit" value="Sign In">
    </form>
    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
</body>

</html>