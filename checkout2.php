<?php
session_start();

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
                                <td><strong class="amount">$<?php echo number_format($total_cost, 2); ?></strong> </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!--End Order Box-->

                <!--Payment Box-->
                <div class="payment-box">
                    <!-- Include your payment options and place order button here -->
                </div>
                <!--End Payment Box-->
            </div>
        </section>
        <!--End CheckOut Page-->

        <!-- Include your footer here -->
    </div><!-- End Page Wrapper -->

    <!-- Include your JavaScript files here -->
</body>

</html>