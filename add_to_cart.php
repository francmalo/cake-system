<?php
// Start the session
session_start();

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Connect to the database
    require_once 'config.php';

    // Fetch the product details from the database
    $sql = "SELECT * FROM product WHERE product_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Initialize the cart array if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Check if the product already exists in the cart
        $product_exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity']++;
                $product_exists = true;
                break;
            }
        }

        // If the product doesn't exist, add it to the cart
        if (!$product_exists) {
            $_SESSION['cart'][] = array(
                'id' => $row['product_id'],
                'name' => $row['product_name'],
                'price' => $row['current_price'],
                'quantity' => 1 // You can modify the initial quantity if needed
            );
        }

        // Regenerate the session ID (if needed)
        // session_regenerate_id(true);

        // Set a session variable to store the notification message
        if ($product_exists) {
            $_SESSION['notification'] = "Product already exists in the cart. Quantity increased.";
        } else {
            $_SESSION['notification'] = "Product added to the cart successfully.";
        }

        // Redirect back to the previous page or display a success message
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid request.";
}
?>