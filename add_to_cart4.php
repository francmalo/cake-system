<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $weight = $_POST['size'];
    $message = $_POST['message'];
    $quantity = $_POST['quantity'];

    // Connect to the database
    require_once 'config.php';

    // Check if the database connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to fetch the product details
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Prepare the SQL statement to fetch the price for the selected weight
        $stmt_price = $conn->prepare("SELECT price FROM pricelist WHERE product_id = ? AND weight = ?");
        if (!$stmt_price) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            $stmt->close(); // Close the first prepared statement
            exit;
        }

        $stmt_price->bind_param("is", $product_id, $weight);
        $stmt_price->execute();
        $result_price = $stmt_price->get_result();

        if ($result_price->num_rows > 0) {
            $row_price = $result_price->fetch_assoc();
            $price = $row_price['price'];

            // ... (rest of the code)
        } else {
            echo "Price not found for the selected weight.";
        }

        // Close the prepared statements
        $stmt->close();
        $stmt_price->close();
    } else {
        echo "Product not found. Product ID: $product_id";
        $stmt->close(); // Close the first prepared statement
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>