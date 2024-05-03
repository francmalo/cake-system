<?php
// Start the session
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : '';
    $product_desc = isset($_POST['product_desc']) ? $_POST['product_desc'] : '';
    $weight = $_POST['size'];
    $message = $_POST['message'];
    $quantity = $_POST['quantity'];

    // Print the received form data for debugging
    echo "Product ID: " . $product_id . "<br>";
    echo "Product Name: " . $product_name . "<br>";
    echo "Image URL: " . $image_url . "<br>";
    echo "Product Description: " . $product_desc . "<br>";
    echo "Weight: " . $weight . "<br>";
    echo "Message: " . $message . "<br>";
    echo "Quantity: " . $quantity . "<br>";



      // Store the form data in the session
    $_SESSION['cart'][] = array(
        'product_id' => $product_id,
        'product_name' => $product_name,
        'image_url' => $image_url,
        'product_desc' => $product_desc,
        'weight' => $weight,
        'message' => $message,
        'quantity' => $quantity
    );

   
    // Connect to the database
    require_once 'config.php';


    // Prepare the SQL statement to fetch the product details
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepare the SQL statement to fetch the price for the selected weight
    $stmt_price = null; // Initialize with null

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $stmt_price = $conn->prepare("SELECT price FROM pricelist WHERE product_id = ? AND weight = ?");
        if ($stmt_price) { // Check if preparation was successful
            $stmt_price->bind_param("is", $product_id, $weight);
            $stmt_price->execute();
            $result_price = $stmt_price->get_result();

            if ($result_price->num_rows > 0) {
                $row_price = $result_price->fetch_assoc();
                $price = $row_price['price'];

                // ... (Rest of the code remains the same) ...

            } else {
                echo "Price not found for the selected weight.";
            }
        } else {
            echo "Failed to prepare the statement to fetch price.";
        }
    } else {
        echo "Product not found.";
    }

    // Close the prepared statements
    $stmt->close();
    if ($stmt_price !== null) { // Check if $stmt_price is not null
        $stmt_price->close();
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();