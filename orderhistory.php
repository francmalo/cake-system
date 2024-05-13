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

    .cart-section .table {
        border-left: 0;
        border-right: 0;
    }

    .cart-section .table th,
    .cart-section .table td {
        border-left: 0;
        border-right: 0;
    }

    .cart-section .custom-btn {
        background-color: #7C6BFF;
        color: white !important;
        font-weight: bold;
    }

    .cart-header th {
        background-color: white !important;
        color: black !important;
        font-weight: bold !important;
    }

    .cart-section .custom-btn {
        background-color: #7C6BFF;
        color: white !important;
        font-weight: bold;
    }

    .custom-btn {
        padding: 5px 10px;
        font-size: 14px;
    }


    .custom-btn {
        background-color: #7C6BFF;
        color: white !important;
        font-weight: bold;
    }

    .cart-table .cart-header th {
        background-color: white !important;
        color: black !important;
        font-weight: bold !important;
    }

    /* table two */
    .table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table th,
    .table td {
        padding: 8px;
        line-height: 1.5;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        border-left: 0;
        border-right: 0;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody+tbody {
        border-top: 2px solid #dee2e6;
    }

    .cart-section .custom-btn {
        background-color: #7C6BFF;
        color: white !important;
        font-weight: bold;
    }

    .cart-header th {
        background-color: white !important;
        color: black !important;
        font-weight: bold !important;
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
                    <table class="table">
                        <thead>
                            <tr class="cart-header">
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Invoice Status</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <th scope="row">&nbsp;</th>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><?php echo $row['order_date']; ?></td>
                                <td>
                                    <?php
                $orderStatusLabel = getOrderStatusLabel($row['order_status']);
                $orderStatusClass = getOrderStatusClass($row['order_status']);
                echo '<span class="badge rounded-pill ' . $orderStatusClass . '">' . $orderStatusLabel . '</span>';
                ?>
                                </td>
                                <td>
                                    <?php
                $invoiceStatusLabel = getInvoiceStatusLabel($row['invoice_status']);
                $invoiceStatusClass = getInvoiceStatusClass($row['invoice_status']);
                echo '<span class="badge rounded-pill ' . $invoiceStatusClass . '">' . $invoiceStatusLabel . '</span>';
                ?>
                                </td>
                                <td>Ksh<?php echo number_format($row['total_amount'], 2); ?></td>
                                <td>
                                    <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>"
                                        class="btn custom-btn">View</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No orders found.</td>
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
function getOrderStatusClass($status)
{
    switch ($status) {
        case 1:
            return 'bg-warning text-dark';
        case 2:
            return 'bg-info text-dark';
        case 3:
            return 'bg-primary';
        case 4:
            return 'bg-success';
        default:
            return 'bg-secondary';
    }
}

function getInvoiceStatusClass($status)
{
    switch ($status) {
        case 1:
            return 'bg-warning text-dark';
        case 2:
            return 'bg-success';
        default:
            return 'bg-secondary';
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