<?php
session_start();



// Include the database connection file
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle sign-up form submission
    $first_name = $_POST['first_name'];
     $second_name = $_POST['second_name'];
    $user_email = $_POST['user_email'];
    $user_pasword = $_POST['user_pasword'];

    // Validate user input (e.g., check if user_email is already registered, password requirements, etc.)
   
    $query = "SELECT * FROM users WHERE user_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = 'User_email already registered';
    } else {
        // Hash the password
       // ...
// Hash the password
$hashed_password = password_hash($user_pasword, PASSWORD_DEFAULT);

// Insert new user data into the database
$query = "INSERT INTO users (first_name, second_name, user_email, user_pasword) VALUES (?, ?, ?, ?)";
$stmt = $db->prepare($query);
$stmt->bind_param('ssss', $first_name, $second_name, $user_email, $hashed_password);
$stmt->execute();
// ...
        // Start a session and store the user's ID
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;

        // Redirect to the cart page or checkout page
        header('Location: checkout.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
</head>

<body>
    <h1>Sign Up</h1>
    <?php if (isset($error)) echo '<p>' . $error . '</p>'; ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>First Name:</label>
        <input type="text" name="first_name" required>
        <br>
        <label>Second Name:</label>
        <input type="text" name="second_name" required>
        <br>
        <label>User_email:</label>
        <input type="user_email" name="user_email" required>
        <br>
        <label>Password:</label>
        <input type="password" name="user_pasword" required>
        <br>
        <input type="submit" value="Sign Up">
    </form>
    <p>Already have an account? <a href="signin.php">Sign In</a></p>
</body>

</html>