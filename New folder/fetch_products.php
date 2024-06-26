<?php
require_once 'config.php';

// Query to fetch product and category
$sql = "SELECT p.*, c.category_name FROM product p JOIN category c ON p.category_id = c.category_id";
$result = $conn->query($sql);
$product = array();
$category = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productData = array(
            'id' => $row['product_id'],
            'name' => $row['product_name'],
            'imageSrc' => $row['image_url'],
            'oldPrice' => '$' . $row['prev_price'],
            'newPrice' => '$' . $row['current_price'],
            'category' => $row['category_name']
        );
        $product[] = $productData;
        $category[$row['category_name']] = true;
    }
}

$conn->close();

// Convert category to an array
$category = array_keys($category);

// Return the product and category as JSON
echo json_encode(array('product' => $product, 'category' => $category));
?>