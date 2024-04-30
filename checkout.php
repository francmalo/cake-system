<?php
session_start();



// Include the database connection file
require_once 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

// Calculate the total cost
$total_cost = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_cost += $item['price'] * $item['quantity'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $delivery_type = $_POST['delivery_type'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];


   // Insert into the orders table
$order_date = date('Y-m-d H:i:s');
$delivery_date = date('Y-m-d'); // Assuming you want to set the delivery date to the current date
$order_status = 1; // Set a default order status (e.g., 1 for pending)
$invoice_status = 1; // Set a default invoice status (e.g., 1 for pending)
$query = "INSERT INTO orders (user_id, order_date, delivery_date, delivery_type, address, phone, order_status, invoice_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param('issssiii', $_SESSION['user_id'], $order_date, $delivery_date, $delivery_type, $address, $phone, $order_status, $invoice_status);
$stmt->execute();
$order_id = $stmt->insert_id;

    // Insert into the orderline table
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['id'];
        $price = $item['price'];
        $quantity = $item['quantity'];
        $orderline_status = 1; // Set a default orderline status (e.g., 1 for pending)
        $query = "INSERT INTO orderline (order_id, product_id, price, quantity, orderline_status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iidii', $order_id, $product_id, $price, $quantity, $orderline_status);
        $stmt->execute();
    }

    // Clear the cart session
    unset($_SESSION['cart']);

    // Redirect to a success page or display a success message
    header("Location: order_success.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Bellaria - Checkout</title>
    <!-- Include your CSS and other head elements here -->
</head>

<body>
    <div class="page-wrapper">
        <!-- Include your header and navigation here -->

        <!--Page Title-->
        <section class="page-title" style="background-image:url(https://via.placeholder.com/1920x400)">
            <div class="auto-container">
                <h1>Checkout</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li>Checkout</li>
                </ul>
            </div>
        </section>
        <!--End Page Title-->

        <!--CheckOut Page-->
        <section class="checkout-page">
            <div class="auto-container">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <!--Order Box-->
                    <div class="order-box">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-name">Product</th>
                                    <th class="product-total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['cart'] as $item): ?>
                                <tr class="cart-item">
                                    <td class="product-name"><?php echo $item['name']; ?>&nbsp;
                                        <strong class="product-quantity">× <?php echo $item['quantity']; ?></strong>
                                    </td>
                                    <td class="product-total">
                                        <span class="woocommerce-Price-amount amount"><span
                                                class="woocommerce-Price-currencySymbol">$</span><?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td><span class="amount">$<?php echo number_format($total_cost, 2); ?></span></td>
                                </tr>
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td><strong class="amount">$<?php echo number_format($total_cost, 2); ?></strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!--End Order Box-->

                    <!--Delivery Details-->
                    <div class="delivery-details">
                        <h3>Delivery Details</h3>
                        <div class="form-group">
                            <label for="delivery_type">Delivery Type:</label>
                            <select name="delivery_type" id="delivery_type" required>
                                <option value="">Select Delivery Type</option>
                                <option value="1">Standard Delivery</option>
                                <option value="2">Express Delivery</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea name="address" id="address" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone" required>
                        </div>
                    </div>
                    <!--End Delivery Details-->

                    <!--Payment Box-->
                    <div class="payment-box">
                        <!-- Include your payment options and place order button here -->
                        <button type="submit" class="theme-btn">Place Order</button>
                    </div>
                    <!--End Payment Box-->
                </form>
            </div>
        </section>
        <!--End CheckOut Page-->

        <!-- Include your footer here -->
    </div><!-- End Page Wrapper -->

    <!-- Include your JavaScript files here -->
</body>

</html>