<?php
// Start the session
session_start();

// Include the database connection file
require_once 'config.php';

// Check if the cart is not empty
if (!empty($_SESSION['cart'])) {
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
    .cart-table {
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Shopping Cart</h1>
        <table class="table table-striped cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Weight</th>
                    <th>Message</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $item) {
                        $product_id = $item['product_id'];
                        $product_name = $item['product_name'];
                        $image_url = $item['image_url'];
                        $product_desc = $item['product_desc'];
                        $weight = $item['weight'];
                        $message = $item['message'];
                        $quantity = $item['quantity'];

                        // Fetch the price for the selected weight
                        $stmt = $conn->prepare("SELECT price FROM pricelist WHERE product_id = ? AND weight = ?");
                        $stmt->bind_param("is", $product_id, $weight);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $price = $row['price'];
                            $total_item = $price * $quantity;
                            $total += $total_item;
                            ?>
                <tr>
                    <td><img src="<?php echo $image_url; ?>" alt="<?php echo $product_name; ?>" width="100"></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $product_desc; ?></td>
                    <td><?php echo $weight; ?> kg</td>
                    <td><?php echo $message; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td>Ksh <?php echo $price; ?></td>
                    <td>Ksh <?php echo $total_item; ?></td>
                </tr>
                <?php
                        } else {
                            echo "Price not found for the selected weight.";
                        }
                        $stmt->close();
                    }
                    ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="text-right font-weight-bold">Total:</td>
                    <td class="font-weight-bold">Ksh <?php echo $total; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
<?php
} else {
    echo "Your cart is empty.";
}

// Close the database connection
$conn->close();
?>