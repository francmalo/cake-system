<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include the database connection file
require_once 'config.php';

// Fetch order history for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT o.order_id, o.order_date, o.delivery_date, o.delivery_type, o.address, o.phone, o.order_status, i.invoice_status, i.total_amount
          FROM orders o
          LEFT JOIN invoice i ON o.order_id = i.order_id
          WHERE o.user_id = ?
          ORDER BY o.order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Order History</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
    body {
        padding: 20px;
    }
    </style>
</head>

<body>
    <h1>Order History</h1>

    <?php if ($result->num_rows > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Delivery Type</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Order Status</th>
                <th>Invoice Status</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td><?php echo $row['delivery_date']; ?></td>
                <td><?php echo ($row['delivery_type'] == 1) ? 'Standard Delivery' : 'Express Delivery'; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo getOrderStatusLabel($row['order_status']); ?></td>
                <td><?php echo getInvoiceStatusLabel($row['invoice_status']); ?></td>
                <td><?php echo $row['total_amount']; ?></td>
                <td>
                    <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-primary">View
                        Details</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No orders found.</p>
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