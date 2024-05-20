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
$query = "SELECT ol.orderline_id, ol.product_id, p.product_name, p.image_url, ol.pricelist_id, pl.weight, ol.price, ol.custom_desc, ol.quantity
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
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Bellaria - a Delicious Cakes and Bakery HTML Template | Shop Single</title>

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


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    body {
        padding: 20px;
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

    .container {
        max-width: 1200px;
        margin: auto;
    }

    @media (max-width: 767.98px) {
        .table-responsive-sm {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }
    }
    </style>
</head>

<!-- Preloader -->
<div class="preloader">
    <div class="loader_overlay"></div>
    <div class="loader_cogs">
        <div class="loader_cogs__top">
            <div class="top_part"></div>
            <div class="top_part"></div>
            <div class="top_part"></div>
            <div class="top_hole"></div>
        </div>
        <div class="loader_cogs__left">
            <div class="left_part"></div>
            <div class="left_part"></div>
            <div class="left_part"></div>
            <div class="left_hole"></div>
        </div>
        <div class="loader_cogs__bottom">
            <div class="bottom_part"></div>
            <div class="bottom_part"></div>
            <div class="bottom_part"></div>
            <div class="bottom_hole"></div>
        </div>
    </div>
</div>

<!-- Main Header-->
<header class="main-header">
    <!-- Menu Wave -->
    <div class="menu_wave"></div>

    <!-- Main box -->
    <div class="main-box">
        <div class="menu-box">
            <div class="logo"><a href="index.html"><img src="images/logo-22.png" alt="" title=""></a></div>


            <!--Nav Box-->
            <div class="nav-outer clearfix">
                <!-- Main Menu -->
                <nav class="main-menu navbar-expand-md navbar-light">
                    <div class="collapse navbar-collapse clearfix" id="navbarSupportedContent">
                        <ul class="navigation menu-left clearfix">
                            <li class="dropdown"><a href="index.php">Home</a>

                            </li>
                            <li class="dropdown"><a href="#">Categories</a>
                                <ul>
                                    <li><a href="#">Wedding</a></li>
                                    <li><a href="#">Birthday</a></li>
                                    <li><a href="#">Annivesery</a></li>
                                    <li><a href="#">Graduation</a></li>
                                    <li><a href="#">Other</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a href="#">Links</a>
                                <ul>
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Our Services</a></li>
                                    <li><a href="#">FAQs</a></li>
                                </ul>
                            </li>
                        </ul>

                        <ul class="navigation menu-right clearfix">
                            <li class=""><a href="#">Booking</a></li>
                            <li class="dropdown current"><a href="shop.php">Shop</a>
                                <ul>
                                    <li class="current"><a href="shop.html">Shop</a></li>
                                    <li><a href="shopping-cart.php">Cart</a></li>
                                    <li><a href="checkout.php">Checkout</a></li>
                                    <li><a href="signin.php">My account</a></li>
                                </ul>
                            </li>
                            <li><a href="#contact.html">Contacts</a></li>
                        </ul>
                    </div>
                </nav>
                <!-- Main Menu End-->

                <div class="outer-box clearfix">
                    <!-- Shopping Cart -->
                    <div class="cart-btn">
                        <a href="shopping-cart.php"><i class="icon flaticon-commerce"></i> <span class="count">
                                <?php
            // Get the total number of items in the cart
            $total_items = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $total_items += $item['quantity'];
                }
            }
            echo $total_items;
            ?>
                            </span></a>

                        <div class="shopping-cart">
                            <ul class="shopping-cart-items">
                                <?php
                // Display the items in the cart
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        echo '<li class="cart-item">';
                        echo '<img src="' . $item['image_url'] . '" alt="#" class="thumb" />';
                        echo '<span class="item-name">' . $item['product_name'] . '</span>';
                        echo '<span class="item-quantity">' . $item['quantity'] . ' x <span class="item-amount">Ksh' . $item['price'] . '</span></span>';
                        echo '<a href="shop-single.html" class="product-detail"></a>';
                        echo '<button class="remove-item"><span class="fa fa-times"></span></button>';
                        echo '</li>';
                    }
                } else {
                    echo '<li>Your cart is empty.</li>';
                }
                ?>
                            </ul>

                            <div class="cart-footer">
                                <div class="shopping-cart-total"><strong>Subtotal:</strong>
                                    <?php
                    // Calculate the total amount
                    $total_amount = 0;
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $total_amount += $item['price'] * $item['quantity'];
                        }
                    }
                    echo 'Ksh' . $total_amount;
                    ?>
                                </div>
                                <a href="shopping-cart.php" class="theme-btn">View Cart</a>
                                <!-- <a href="checkout.html" class="theme-btn">Checkout</a> -->
                            </div>
                        </div>
                        <!--end shopping-cart -->
                    </div>

                    <!-- Search Btn -->
                    <div class="search-box">
                        <button class="search-btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Header  -->
    <div class="sticky-header">
        <div class="auto-container clearfix">
            <!--Logo-->
            <div class="logo">
                <a href="#" title="Sticky Logo"><img src="images/logo-small.png" alt="Sticky Logo"></a>
            </div>

            <!--Right Col-->
            <div class="nav-outer">
                <!--Mobile Navigation Toggler-->
                <div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>

                <!-- Main Menu -->
                <nav class="main-menu">
                    <!--Keep This Empty / Menu will come through Javascript-->
                </nav><!-- Main Menu End-->
            </div>
        </div>
    </div><!-- End Sticky Menu -->

    <!-- Sticky Header  -->
    <div class="sticky-header">
        <div class="auto-container clearfix">
            <!--Logo-->
            <div class="logo">
                <a href="#" title="Sticky Logo"><img src="images/logo-small.png" alt="Sticky Logo"></a>
            </div>

            <!--Right Col-->
            <div class="nav-outer">
                <!--Mobile Navigation Toggler-->
                <div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>

                <!-- Main Menu -->
                <nav class="main-menu">
                    <!--Keep This Empty / Menu will come through Javascript-->
                </nav><!-- Main Menu End-->
            </div>
        </div>
    </div><!-- End Sticky Menu -->

    <!-- Mobile Header -->
    <div class="mobile-header">
        <div class="logo"><a href="index.html"><img src="images/logo-small.png" alt="" title=""></a></div>

        <!--Nav Box-->
        <div class="nav-outer clearfix">
            <!--Keep This Empty / Menu will come through Javascript-->
        </div>
    </div>

    <!-- Mobile Menu  -->
    <div class="mobile-menu">
        <nav class="menu-box">
            <div class="nav-logo"><a href="index.html"><img src="images/logo-small.png" alt="" title=""></a>
            </div>
            <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
        </nav>
    </div><!-- End Mobile Menu -->

    <!-- Header Search -->
    <div class="search-popup">
        <span class="search-back-drop"></span>

        <div class="search-inner">
            <button class="close-search"><span class="fa fa-times"></span></button>
            <form method="post" action="blog-showcase.html">
                <div class="form-group">
                    <input type="search" name="search-field" value="" placeholder="Search..." required="">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Header Search -->
</header>
<!--End Main Header -->

<!--Page Title-->
<section class="page-title" style="background-image:url(images/bg/bnr2.jpg)">
    <div class="auto-container">
        <h1>Order Details</h1>
        <ul class="page-breadcrumb">
            <ul class="page-breadcrumb">
                <li><a href="index.php">home</a></li>
                <li><a href="shop.php">Products</a></li>

            </ul>

        </ul>
    </div>
</section>


<body>
    <div class="container">
        <h1 class="text-center mb-4">Order Details</h1>

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
        <?php if ($order): ?>
        <div class="order-items">
            <h3>Order Items</h3>
            <div class="table-responsive-sm">
                <table class="table ">
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
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $orderline['image_url']; ?>"
                                        alt="<?php echo $orderline['product_name']; ?>" class="product-image me-3">
                                    <div><?php echo $orderline['product_name']; ?></div>
                                </div>
                            </td>
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
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.fancybox.js"></script>
    <script src="js/owl.js"></script>
    <script src="js/wow.js"></script>
    <script src="js/appear.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/sticky_sidebar.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>