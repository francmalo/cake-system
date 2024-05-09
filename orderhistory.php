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
    <meta charset="utf-8">
    <title>Bellaria - a Delicious Cakes and Bakery HTML Template | Shopping Cart</title>

    <!-- Stylesheets -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">

    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
    <style>
    body {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    h1 {
        margin-bottom: 30px;
        text-align: center;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .cart-table th,
    .cart-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .cart-table th {
        background-color: #f2f2f2;
    }

    .product-thumbnail img {
        max-width: 80px;
    }

    .product-quantity .quantity {
        display: inline-block;
    }

    .product-quantity .qty {
        width: 60px;
        text-align: center;
    }

    .cart-options {
        margin-bottom: 20px;
    }

    .apply-coupon {
        display: flex;
        align-items: center;
    }

    .apply-coupon .form-group {
        margin-right: 10px;
    }

    .totals-table {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .totals-table li {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
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

    <!--Cart Section-->
    <section class="cart-section">
        <div class="auto-container">
            <!--Cart Outer-->
            <div class="cart-outer">
                <div class="table-outer">
                    <table class="cart-table">
                        <thead class="cart-header">
                            <tr>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Order ID</th>
                                <th class="product-message">Order Date</th>
                                <th class="product-price">Delivery Date</th>
                                <th class="product-quantity">Delivery Type</th>
                                <th class="product-subtotal">Address</th>
                                <th class="product-remove">Phone</th>
                                <th class="product-remove">Order Status</th>
                                <th class="product-remove">Invoice Status</th>
                                <th class="product-remove">Total Amount</th>
                                <th class="product-remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="cart-item">
                                <td class="product-thumbnail">&nbsp;</td>
                                <td class="product-name"><?php echo $row['order_id']; ?></td>
                                <td class="product-message"><?php echo $row['order_date']; ?></td>
                                <td class="product-price"><?php echo $row['delivery_date']; ?></td>
                                <td class="product-quantity">
                                    <?php echo ($row['delivery_type'] == 1) ? 'Standard Delivery' : 'Express Delivery'; ?>
                                </td>
                                <td class="product-subtotal"><?php echo $row['address']; ?></td>
                                <td class="product-remove"><?php echo $row['phone']; ?></td>
                                <td class="product-remove"><?php echo getOrderStatusLabel($row['order_status']); ?></td>
                                <td class="product-remove"><?php echo getInvoiceStatusLabel($row['invoice_status']); ?>
                                </td>
                                <td class="product-remove">$<?php echo number_format($row['total_amount'], 2); ?></td>
                                <td class="product-remove">
                                    <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>"
                                        class="btn btn-primary">View
                                        Details</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center">No orders found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

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

    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.fancybox.js"></script>
    <script src="js/owl.js"></script>
    <script src="js/wow.js"></script>
    <script src="js/appear.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/sticky_sidebar.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>