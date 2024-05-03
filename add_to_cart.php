<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : '';
    $product_desc = isset($_POST['product_desc']) ? $_POST['product_desc'] : '';
    $weight = $_POST['size'];
    $message = $_POST['message'];
    $quantity = $_POST['quantity'];

    // Connect to the database
    require_once 'config.php';

    // Fetch the price for the selected weight
    $stmt = $conn->prepare("SELECT price FROM pricelist WHERE product_id = ? AND weight = ?");
    $stmt->bind_param("is", $product_id, $weight);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price = $row['price'];

        // Check if the cart already exists in the session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Check if the product already exists in the cart
        $product_exists = false;
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] == $product_id && $item['weight'] == $weight) {
                // Product exists, increase quantity
                $_SESSION['cart'][$key]['quantity'] += $quantity;
                $product_exists = true;
                break;
            }
        }

        // If product doesn't exist, add it to the cart
        if (!$product_exists) {
            // Add the product to the cart
            $item = array(
                'product_id' => $product_id,
                'product_name' => $product_name,
                'image_url' => $image_url,
                'product_desc' => $product_desc,
                'weight' => $weight,
                'message' => $message,
                'quantity' => $quantity,
                'price' => $price
            );

            // Add the item to the cart
            $_SESSION['cart'][] = $item;

            // Set a session variable to store the notification message
            $_SESSION['notification'] = "Product added to the cart successfully.";
        } else {
            // Set a session variable to store the notification message
            $_SESSION['notification'] = "Product already exists in the cart. Quantity increased.";
        }

        // Redirect to the cart page
         // Redirect back to the previous page or display a success message
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Price not found for the selected weight.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}

?>