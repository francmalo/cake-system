<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}

// Include the database connection file
require_once 'config.php';

// Fetch order history for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT o.order_id, o.order_date, o.delivery_date, o.delivery_type, o.address, o.phone, o.order_status, i.invoice_status, i.total_amount FROM orders o LEFT JOIN invoice i ON o.order_id = i.order_id WHERE o.user_id = ? ORDER BY o.order_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
} else {
    // Handle query execution error
    echo "Error executing the query: " . $stmt->error;
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
    body {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    h1 {
        margin-bottom: 30px;
        text-align: center;
    }

    .table {
        margin-top: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .btn-primary {
        padding: 5px 10px;
        font-size: 14px;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .btn-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
    }
    </style>
</head>

<body>
    <h1>Order History</h1>

    <?php if ($result->num_rows > 0): ?>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
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
                <td>$<?php echo number_format($row['total_amount'], 2); ?></td>
                <td>
                    <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-primary">View
                        Details</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p class="text-center">No orders found.</p>
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