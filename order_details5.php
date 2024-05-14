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
$query = "SELECT ol.orderline_id, ol.product_id, p.product_name, p.product_image, ol.pricelist_id, pl.weight, ol.price, ol.custom_desc, ol.quantity
          FROM orderline ol
          JOIN product p ON ol.product_id = p.product_id
          JOIN pricelist pl ON ol.pricelist_id = pl.pricelist_id AND ol.order_id = ?
          WHERE ol.order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $order_id, $order_id);
$stmt->execute();
$orderline_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    body {
        padding: 20px;
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #343a40;
        color: #fff;
        border-radius: 15px 15px 0 0;
        padding: 15px 20px;
    }

    .card-body {
        padding: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .order-tracking {
        padding: 20px 0;
    }

    .order-tracking .step {
        display: inline-block;
        text-align: center;
        width: 24%;
        position: relative;
    }

    .order-tracking .step .step-inner {
        display: inline-block;
        width: 100%;
        position: relative;
    }

    .order-tracking .step .step-inner::after {
        content: '';
        width: 100%;
        height: 2px;
        background: #e9ecef;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%);
        z-index: -1;
    }

    .order-tracking .step.completed .step-inner::after {
        background: #28a745;
    }

    .order-tracking .step:first-child .step-inner::after {
        width: 50%;
        left: 50%;
    }

    .order-tracking .step:last-child .step-inner::after {
        width: 50%;
        left: 0;
    }

    .order-tracking .step .icon {
        display: inline-block;
        width: 50px;
        height: 50px;
        line-height: 50px;
        border-radius: 50%;
        background: #e9ecef;
        color: #fff;
        margin-bottom: 10px;
    }

    .order-tracking .step.completed .icon {
        background: #28a745;
    }

    .order-tracking .step .text {
        margin-top: 10px;
        font-weight: 500;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #28a745;
        border-color: #28a745;
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Order Details</h1>

        <?php if ($order): ?>
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Order Information</h3>
            </div>
            <div class="card-body">
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
                        <td><?php echo ($order['delivery_type'] == 1) ? 'Standard Delivery' : 'Express Delivery'; ?>
                        </td>
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
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Order Items</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
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
                            <td><img src="<?php echo $orderline['product_image']; ?>"
                                    alt="<?php echo $orderline['product_name']; ?>" class="product-image"></td>
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
            </div>
        </div>

        <div class="order-tracking">
            <h3 class="text-center mb-4">Order Tracking</h3>
            <div class="steps d-flex justify-content-between">
                <div class="step <?php echo ($order['order_status'] >= 1) ? 'completed' : ''; ?>">
                    <div class="step-inner">
                        <div class="icon"><i class="fas fa-receipt"></i></div>
                        <div class="text">Pending</div>
                    </div>
                </div>
                <div class="step <?php echo ($order['order_status'] >= 2) ? 'completed' : ''; ?>">
                    <div class="step-inner">
                        <div class="icon"><i class="fas fa-check"></i></div>
                        <div class="text">Confirmed</div>
                    </div>
                </div>
                <div class="step <?php echo ($order['order_status'] >= 3) ? 'completed' : ''; ?>">
                    <div class="step-inner">
                        <div class="icon"><i class="fas fa-truck"></i></div>
                        <div class="text">Dispatched</div>
                    </div>
                </div>
                <div class="step <?php echo ($order['order_status'] >= 4) ? 'completed' : ''; ?>">
                    <div class="step-inner">
                        <div class="icon"><i class="fas fa-box"></i></div>
                        <div class="text">Delivered</div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-warning" role="alert">
            Order not found.
        </div>
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
        ?>
    </div>
</body>

</html>