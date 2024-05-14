<!DOCTYPE html>
<html>

<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    body {
        padding: 20px;
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-body {
        padding: 20px;
    }

    .table {
        margin-bottom: 0;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .progress {
        height: 25px;
        font-weight: bold;
        background-color: #f5f5f5;
    }

    .progress-bar {
        background-color: #007bff;
    }

    .fa-check-circle {
        color: #28a745;
    }

    .fa-times-circle {
        color: #dc3545;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Order Details</div>
            <div class="card-body">
                <?php if ($order): ?>
                <h4>Order Information</h4>
                <table class="table table-bordered">
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

                <h4 class="mt-4">Order Tracking</h4>
                <div class="progress">
                    <div class="progress-bar" role="progressbar"
                        aria-valuenow="<?php echo $order['order_status'] * 25; ?>" aria-valuemin="0" aria-valuemax="100"
                        style="width: <?php echo $order['order_status'] * 25; ?>%;">
                        <?php echo $order['order_status'] * 25; ?>%
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div>
                        <i
                            class="fas fa-<?php echo ($order['order_status'] >= 1) ? 'check-circle' : 'times-circle'; ?>"></i>
                        Pending
                    </div>
                    <div>
                        <i
                            class="fas fa-<?php echo ($order['order_status'] >= 2) ? 'check-circle' : 'times-circle'; ?>"></i>
                        Confirmed
                    </div>
                    <div>
                        <i
                            class="fas fa-<?php echo ($order['order_status'] >= 3) ? 'check-circle' : 'times-circle'; ?>"></i>
                        Dispatched
                    </div>
                    <div>
                        <i
                            class="fas fa-<?php echo ($order['order_status'] >= 4) ? 'check-circle' : 'times-circle'; ?>"></i>
                        Delivered
                    </div>
                </div>

                <h4 class="mt-4">Order Items</h4>
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
            </div>
        </div>
    </div>

    <?php
    // Helper functions to get order status and invoice status labels
    function getOrderStatusLabel($status)
    {<?php
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }

        .order-details,
        .order-items,
        .order-tracking {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .order-tracking .step {
            display: inline-block;
            text-align: center;
            width: 25%;
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
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: #fff;
        }

        .order-tracking .step.completed .icon {
            background: #28a745;
        }

        .order-tracking .step .text {
            margin-top: 10px;
        }
        </style>
    </head>

    <body>
        <h1>Order Details</h1>

        <?php if ($order): ?>
        <div class="order-details">
            <h3>Order Information</h3>
            <table class="table table-borderless">
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
        </div>

        <div class="order-items">
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
        </div>


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
    </body>

    </html>
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
</body>

</html>