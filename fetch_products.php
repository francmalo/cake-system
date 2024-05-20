<?php
require_once 'config.php';

// Query to fetch product and category
$sql = "SELECT
    p.product_id,
    p.product_name,
    MAX(p.image_url) AS image_url,
    c.category_name,
    MIN(pl.weight) AS min_weight,
    MIN(pl.price) AS min_price
FROM
    product p
    JOIN category c ON p.category_id = c.category_id
    LEFT JOIN pricelist pl ON p.product_id = pl.product_id
GROUP BY
    p.product_id,
    p.product_name,
    c.category_name
ORDER BY
    min_weight";

$result = $conn->query($sql);

$products = [];
$categories = [];

// Populate $products and $categories arrays
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'id' => $row['product_id'],
            'name' => $row['product_name'],
            'imageSrc' => $row['image_url'],
            'newPrice' => 'Ksh' . $row['min_price'],
            'category' => $row['category_name']
        ];
        $categories[$row['category_name']] = $row['category_name'];
    }
}

$categories = array_values($categories);

// Return the product and category as JSON
echo json_encode([
    'product' => $products,
    'category' => $categories
]);

$conn->close();
?>