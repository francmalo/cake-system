<?php
require_once 'config.php';

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Query to fetch product details
    $sql = "SELECT p.*, c.category_name FROM product p JOIN category c ON p.category_id = c.category_id WHERE p.product_id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // Display product details
        echo '<h1>' . $product['product_name'] . '</h1>';
        echo '<p>Category: ' . $product['category_name'] . '</p>';
        echo '<p>Price: $' . $product['current_price'] . '</p>';
        echo '<p>Description: ' . $product['product_description'] . '</p>';
        echo '<img src="' . $product['image_url'] . '" alt="' . $product['product_name'] . '">';
        // Add more product details as needed
    } else {
        echo 'Product not found.';
    }
} else {
    echo 'Invalid product ID.';
}
?>