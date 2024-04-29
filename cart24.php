<?php
// Start the session
session_start();

// Set the session lifetime (if needed)
ini_set('session.gc_maxlifetime', 3600); // 1 hour

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle remove action
if (isset($_GET['action']) && $_GET['action'] === 'remove') {
    if (isset($_GET['key']) && isset($_SESSION['cart'][$_GET['key']])) {
        unset($_SESSION['cart'][$_GET['key']]);
        header('Location: shopping-cart.php'); // Redirect to shopping-cart.php after removing the item
        exit(); // Exit the script after redirecting
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'update_cart':
            foreach ($_SESSION['cart'] as $key => $item) {
                if (isset($_POST['quantity'][$key]) && $_POST['quantity'][$key] > 0) {
                    $_SESSION['cart'][$key]['quantity'] = $_POST['quantity'][$key];
                } else {
                    unset($_SESSION['cart'][$key]);
                }
            }
            break;
        // Add other cases for different actions, if needed
    }
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
</head>

<body>

    <div class="page-wrapper">




        <!--Page Title-->
        <section class="page-title" style="background-image:url(https://via.placeholder.com/1920x400)">
            <div class="auto-container">
                <h1>Cart</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">home</a></li>
                    <li>Cart</li>
                </ul>
            </div>
        </section>
        <!--End Page Title-->


        <!--Cart Section-->
        <section class="cart-section">
            <div class="auto-container">
                <!--Cart Outer-->
                <div class="cart-outer">
                    <form method="post" action="">
                        <input type="hidden" name="action" value="update_cart">
                        <div class="table-outer">
                            <table class="cart-table">
                                <thead class="cart-header">
                                    <tr>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-remove">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            $total = 0;
                            foreach ($_SESSION['cart'] as $key => $item) {
                                $itemTotal = $item['price'] * $item['quantity'];
                                $total += $itemTotal;
                            ?>
                                    <tr class="cart-item">

                                        <td class="product-thumbnail"><a
                                                href="shop-single.php?id=<?php echo $item['id']; ?>"><img
                                                    src="<?php echo htmlspecialchars_decode($item['image_url']); ?>"
                                                    alt=""></a></td>
                                        <td class="product-name"><a
                                                href="shop-single.php?id=<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a>
                                        </td>
                                        <td class="product-price">$<?php echo number_format($item['price'], 2); ?></td>
                                        <td class="product-quantity">
                                            <div class="quantity">
                                                <label>Quantity</label>
                                                <input type="number" class="qty" name="quantity[<?php echo $key; ?>]"
                                                    id="qty_<?php echo $key; ?>"
                                                    value="<?php echo $item['quantity']; ?>" min="1"
                                                    data-price="<?php echo $item['price']; ?>">
                                            </div>
                                        </td>
                                        <td class="product-subtotal"><span
                                                class="amount">$<?php echo number_format($itemTotal, 2); ?></span></td>
                                        <td class="product-remove">
                                            <a href="#" class="remove"
                                                onclick="confirmRemove(event, '<?php echo $key; ?>')"><span
                                                    class="fa fa-times"></span></a>
                                        </td>
                                    </tr>
                                    <?php
                            }
                            ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="cart-options clearfix">
                            <div class="pull-left">
                                <div class="apply-coupon clearfix">
                                    <div class="form-group clearfix">
                                        <input type="text" name="coupon-code" value="" placeholder="Coupon Code">
                                    </div>
                                    <div class="form-group clearfix">
                                        <button type="button" class="theme-btn coupon-btn">Apply Coupon</button>
                                    </div>
                                </div>
                            </div>

                            <div class="pull-right">
                                <button type="submit" class="theme-btn cart-btn">Update Cart</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row justify-content-between">
                    <div class="column col-lg-4 offset-lg-8 col-md-6 col-sm-12">
                        <!--Totals Table-->
                        <ul class="totals-table">
                            <li>
                                <h3>Cart Totals</h3>
                            </li>
                            <li class="clearfix"><span class="col">Subtotal</span><span
                                    class="col price">$<?php echo number_format($total, 2); ?></span></li>
                            <li class="clearfix"><span class="col">Total</span><span
                                    class="col total-price">$<?php echo number_format($total, 2); ?></span></li>
                            <li class="text-right"><button type="submit" class="theme-btn proceed-btn">Proceed to
                                    Checkout</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--End Cart Section-->


    </div><!-- End Page Wrapper -->



    <script>
    const updateCartButton = document.querySelector('.cart-btn');

    updateCartButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the form from submitting immediately
        const form = this.closest('form');
        form.submit(); // Submit the form when the button is clicked
    });




    function confirmRemove(event, key) {
        event.preventDefault(); // Prevent the default link behavior

        // Display a confirmation dialog
        if (confirm("Are you sure you want to remove this item from the cart?")) {
            // If the user clicks "OK", redirect to shopping-cart.php with the remove action and key
            window.location.href = "shopping-cart.php?action=remove&key=" + key;
        }
    }
    </script>




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