<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

// Include the database connection file
require_once 'config.php';

// Get the order ID from the query string
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

// Fetch order details
$user_id = $_SESSION['user_id'];
$query = "SELECT o.order_id, o.order_date, o.delivery_date, o.delivery_type, o.address, o.phone, o.order_status, i.invoice_status, i.total_amount
          FROM orders o
          LEFT JOIN invoice i ON o.order_id = i.order_id
          WHERE o.order_id = ? AND o.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

// Fetch orderline details
$query = "SELECT ol.orderline_id, ol.product_id, p.product_name, ol.pricelist_id, pl.weight, ol.price, ol.custom_desc, ol.quantity
          FROM orderline ol
          JOIN product p ON ol.product_id = p.product_id
          JOIN pricelist pl ON ol.pricelist_id = pl.pricelist_id
          WHERE ol.order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$orderline_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
    body {
        padding: 20px;
    }
    </style>
</head>

<body>
    <h1>Order Details</h1>

    <?php if ($order): ?>
    <h3>Order Information</h3>
    <table class="table">
        <tr>
            <th>Order ID</th>
            <td><?php echo $order['order_id']; ?></td>
        </tr>
        <tr>
            <th>Order Date</th>
            <td><?php echo $order['order_date']; ?></td>
        </tr>
        <tr>
            <th>Delivery Date</th>
            <td><?php echo $order['delivery_date']; ?></td>
        </tr>
        <tr>
            <th>Delivery Type</th>
            <td><?php echo ($order['delivery_type'] == 1) ? 'Standard Delivery' : 'Express Delivery'; ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?php echo $order['address']; ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?php echo $order['phone']; ?></td>
        </tr>
        <tr>
            <th>Order Status</th>
            <td><?php echo getOrderStatusLabel($order['order_status']); ?></td>
        </tr>
        <tr>
            <th>Invoice Status</th>
            <td><?php echo getInvoiceStatusLabel($order['invoice_status']); ?></td>
        </tr>
        <tr>
            <th>Total Amount</th>
            <td><?php echo $order['total_amount']; ?></td>
        </tr>
    </table>

    <h3>Order Items</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Weight</th>
                <th>Price</th>
                <th>Custom Description</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($orderline = $orderline_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $orderline['product_name']; ?></td>
                <td><?php echo $orderline['weight']; ?></td>
                <td><?php echo $orderline['price']; ?></td>
                <td><?php echo $orderline['custom_desc']; ?></td>
                <td><?php echo $orderline['quantity']; ?></td>
                <td><?php echo $orderline['price'] * $orderline['quantity']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>Order not found.</p>
    <?php endif; ?>

    <?php
    // Helper functions to get order status and invoice status labels
    function getOrderStatusLabel($status)
    {
        switch ($status) {
            case 1:
                return 'Pending';
            case 2:
                return 'Confirmed';
            case 3:
                return 'Dispatched';
            case 4:
                return 'Delivered';
            default:
                return 'Unknown';
        }
    }

    // ... (code above)

function getInvoiceStatusLabel($status)
{
    switch ($status) {
        case 1:
            return 'Pending';
        case 2:
            return 'Paid';
        default:
            return 'Unknown';
    }
}

// ... (code below)
    ?>
</body>

</html>