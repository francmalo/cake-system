<?php
require_once 'config.php';
// Query to fetch products and categories
$sql = "SELECT p.*, c.category_name
        FROM products p
        JOIN categories c ON p.category_id = c.category_id";

$result = $conn->query($sql);

$products = array();
$categories = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $product = array(
            'name' => $row['product_name'],
            'imageSrc' => $row['image_url'],
             'oldPrice' => '$' . $row['prev_price'],
            'newPrice' => '$' . $row['current_price'],
            'category' => $row['category_name']
        );
        $products[] = $product;
        $categories[$row['category_name']] = true;
    }
}

$conn->close();

// Convert categories to an array
$categories = array_keys($categories);

// Return the products and categories as JSON
echo json_encode(array('products' => $products, 'categories' => $categories));
?>