<?php 
ob_start();
session_start();
include 'config.php';
unset($_SESSION['user_id']);
// Redirect to the login page or the homepage
header("Location: signin.php"); // Replace with your login page or homepage URL
?>
<table class="cart-table">
    <thead class="cart-header">
        <tr>
            <th class="product-thumbnail">&nbsp;</th>
            <th class="product-name">Order ID</th>
            <th class="product-message">Order Date</th>

            <th class="product-remove">Order Status</th>
            <th class="product-remove">Invoice Status</th>
            <th class="product-remove">Total Amount</th>
            <th class="product-status">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr class="cart-item">
            <td class="product-thumbnail">&nbsp;</td>
            <td class="product-name"><?php echo $row['order_id']; ?></td>
            <td class="product-message"><?php echo $row['order_date']; ?></td>
            <td class="product-remove">
                <?php
        $orderStatusLabel = getOrderStatusLabel($row['order_status']);
        $orderStatusClass = getOrderStatusClass($row['order_status']);
        echo '<span class="badge rounded-pill ' . $orderStatusClass . '">' . $orderStatusLabel . '</span>';
        ?>
            </td>
            <td class="product-remove">
                <?php
        $invoiceStatusLabel = getInvoiceStatusLabel($row['invoice_status']);
        $invoiceStatusClass = getInvoiceStatusClass($row['invoice_status']);
        echo '<span class="badge rounded-pill ' . $invoiceStatusClass . '">' . $invoiceStatusLabel . '</span>';
        ?>
            </td>
            <td class="product-remove">$<?php echo number_format($row['total_amount'], 2); ?></td>
            <td class="product-status">
                <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>" class="btn custom-btn">View</a>
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