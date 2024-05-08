<?php
// Start the session
session_start();

// Check if a notification message exists
if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    unset($_SESSION['notification']); // Clear the notification message
} else {
    $notification = '';
}

require_once 'config.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $sql = "SELECT p.product_name, p.image_url, c.category_name, p.product_desc, MIN(pl.weight) AS min_weight, MIN(pl.price) AS min_price
            FROM product p
            LEFT JOIN category c ON p.category_id = c.category_id
            LEFT JOIN pricelist pl ON p.product_id = pl.product_id
            WHERE p.product_id = ?
            GROUP BY p.product_name, p.image_url, c.category_name, p.product_desc";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Prepare and execute the SQL query to fetch the price for the selected weight
        $weight = isset($_POST['size']) ? $_POST['size'] : null;
        $stmt_price = $conn->prepare("SELECT pricelist_id, price FROM pricelist WHERE product_id = ? AND (? IS NULL OR weight = ?)");
        $stmt_price->bind_param("isi", $productId, $weight, $weight);
        $stmt_price->execute();
        $result_price = $stmt_price->get_result();

        if ($result_price->num_rows > 0) {
            $row_price = $result_price->fetch_assoc();
            $price = $row_price['price'];
            $pricelistid = $row_price['pricelist_id']; // Fetch the pricelist_id

            // Fetch all sizes (weights) and prices for the product
            $sql2 = "SELECT pricelist_id, weight, price FROM pricelist WHERE product_id = ? ORDER BY weight";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $productId);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            $sizes = array();

            while ($row = $result2->fetch_assoc()) {
                $sizes[$row['weight']] = $row['price'];
            }

            // Sort the sizes in natural order (e.g., "1kg", "2kg", "10kg")
            if (!empty($sizes)) {
                natsort($sizes);
            }

            $stmt2->close();
        } else {
            echo "Price not found for the selected weight.";
        }

        $stmt_price->close();
    } else {
        echo "Product not found.";
    }

    $stmt->close();
} else {
    echo "Invalid product ID.";
}

// Close the database connection
$conn->close();
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


    <style>
    .size-options {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .size-options label {
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .size-options select {
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }

    .cake-message {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .cake-message label {
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .cake-message input {
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }

    #notification-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }

    .notification {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        border-radius: 4px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        opacity: 0;
        animation: fadeIn 0.3s ease-in-out forwards, fadeOut 3s 3s ease-in-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
    </style>
</head>

<body>

    <div class="page-wrapper">

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
                                    <li class="dropdown"><a href="index.html">Home</a>

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
                                    <li class="dropdown current"><a href="shop.html">Shop</a>
                                        <ul>
                                            <li class="current"><a href="shop.html">Shop</a></li>
                                            <li><a href="shopping-cart.html">Cart</a></li>
                                            <li><a href="checkout.html">Checkout</a></li>
                                            <li><a href="login.html">My account</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#contact.html">Contacts</a></li>
                                </ul>
                            </div>
                        </nav>
                        <!-- Main Menu End-->

                        <div class="outer-box clearfix">
                            <!-- Shoppping Car -->
                            <div class="cart-btn">
                                <a href="shopping-cart.html"><i class="icon flaticon-commerce"></i> <span
                                        class="count">2</span></a>

                                <div class="shopping-cart">
                                    <ul class="shopping-cart-items">
                                        <li class="cart-item">
                                            <img src="https://via.placeholder.com/300x300" alt="#" class="thumb" />
                                            <span class="item-name">Birthday Cake</span>
                                            <span class="item-quantity">1 x <span
                                                    class="item-amount">$84.00</span></span>
                                            <a href="shop-single.html" class="product-detail"></a>
                                            <button class="remove-item"><span class="fa fa-times"></span></button>
                                        </li>

                                        <li class="cart-item">
                                            <img src="https://via.placeholder.com/300x300" alt="#" class="thumb" />
                                            <span class="item-name">French Macaroon</span>
                                            <span class="item-quantity">1 x <span
                                                    class="item-amount">$13.00</span></span>
                                            <a href="shop-single.html" class="product-detail"></a>
                                            <button class="remove-item"><span class="fa fa-times"></span></button>
                                        </li>
                                    </ul>

                                    <div class="cart-footer">
                                        <div class="shopping-cart-total"><strong>Subtotal:</strong> $97.00</div>
                                        <a href="cart.html" class="theme-btn">View Cart</a>
                                        <a href="checkout.html" class="theme-btn">Checkout</a>
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
                <h1>Birthday Cake</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.html">home</a></li>
                    <li><a href="shop.html">Products</a></li>
                    <li>Birthday Cake</li>
                </ul>
            </div>
        </section>
        <!--End Page Title-->
        <!-- Notification container -->
        <div id="notification-container">
            <?php if (!empty($notification)) : ?>
            <div class="notification"><?php echo $notification; ?></div>
            <?php endif; ?>
        </div>


        <!--Sidebar Page Container-->
        <div class="sidebar-page-container">
            <div class="auto-container">
                <div class="row clearfix">



                    <!--Content Side-->
                    <div class="content-side col-lg-9 col-md-12 col-sm-12">
                        <div class="shop-single">
                            <!-- Product Detail -->
                            <div class="product-details">
                                <!--Basic Details-->
                                <div class="basic-details">
                                    <div class="row clearfix">
                                        <div class="image-column col-md-6 col-sm-12">
                                            <!-- <figure class="image"><a href="https://via.placeholder.com/1000x1000"
                                                    class="lightbox-image" title="Image Caption Here"><img
                                                        src="images/products/pic8.jpg" alt=""><span
                                                        class="icon fa fa-search"></span></a></figure> -->
                                            <form method="post" action="add_to_cart.php">
                                                <!-- hidden values -->

                                                <input type="hidden" name="product_id"
                                                    value="<?php echo $productId; ?>">
                                                <input type="hidden" name="product_name"
                                                    value="<?php echo $product['product_name']; ?>">
                                                <input type="hidden" name="image_url"
                                                    value="<?php echo $product['image_url']; ?>">
                                                <input type="hidden" name="product_desc"
                                                    value="<?php echo $product['product_desc']; ?>">


                                                <!-- end hidden values -->
                                                <figure class="image">
                                                    <a href="<?php echo $product['image_url']; ?>"
                                                        class="lightbox-image"
                                                        title="<?php echo $product['product_name']; ?>">
                                                        <img src="<?php echo $product['image_url']; ?>" alt="">
                                                        <span class="icon fa fa-search"></span>
                                                    </a>
                                                </figure>



                                        </div>
                                        <div class="info-column col-md-6 col-sm-12">
                                            <div class="details-header">
                                                <h4><?php echo $product['product_name']; ?></h4>

                                                <div class="item-price">Price: Ksh<?php echo $product['min_price']; ?>
                                                    (<?php echo $product['min_weight']; ?>kg)</div>
                                                <div class="text"><?php echo $product['product_desc']; ?></div>
                                            </div>




                                            <div class="size-options">
                                                <label for="size">Select Size (Weight):</label>
                                                <select id="size" name="size" class="form-select">
                                                    <?php
            if (!empty($sizes)) {
                foreach ($sizes as $weight => $price) {
                    echo '<option value="' . $weight . '">' . $weight . ' kg - Ksh' . $price . '</option>';
                }
            } else {
                echo '<option value="">No sizes available</option>';
            }
            ?>
                                                </select>
                                                <!-- Include the hidden input field for pricelist_id here -->
                                                <input type="hidden" name="pricelistid"
                                                    value="<?php echo $pricelistid; ?>">

                                            </div>
                                            <div class="cake-message">
                                                <label for="message">Add a Cake Message:</label>
                                                <input type="text" id="message" name="message"
                                                    placeholder="e.g. Happy Birthday My Dear" />
                                                <small>We don't charge extra for this</small>
                                            </div>


                                            <div class="other-options clearfix">
                                                <div class="item-quantity">Quantity <input class="qty" type="number"
                                                        value="1" name="quantity"></div>
                                                <button type="submit" class="theme-btn add-to-cart">
                                                    <span class="btn-title">Add To Cart</span>
                                                </button>

                                                <ul class="product-meta">

                                                    <li class="posted_in">Category: <a
                                                            href="#"><?php echo $product['category_name']; ?></a></li>
                                                    <!-- <li class="tagged_as">Tag: <a href="#">Nuts</a></li> -->
                                                </ul>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--Basic Details-->

                                <!--Product Info Tabs-->
                                <div class="product-info-tabs">
                                    <!--Product Tabs-->
                                    <div class="prod-tabs tabs-box">

                                        <!--Tab Btns-->
                                        <ul class="tab-btns tab-buttons clearfix">
                                            <li data-tab="#prod-Info" class="tab-btn active-btn">Additional
                                                Information
                                            </li>
                                        </ul>

                                        <!--Tabs Container-->
                                        <div class="tabs-content">

                                            <!--Tab-->

                                            <div class="tab active-tab" id="prod-info">
                                                <h2 class="title">Additional Information</h2>
                                                <div class="content">
                                                    <p>Accumsan lectus, consectetuer et sagittis et commodo, massa et,
                                                        sed facilisi mi, sit diam. Ultrices facilisi convallis nullam
                                                        duis. Aliquam lacinia orci convallis erat ac, vitae neque in
                                                        class. Suscipit vel, rhoncus est quis nibh netus, aenean
                                                        eleifend et viverra, neque accumsan maecenas nec in. Morbi
                                                        bibendum non ullamcorper aliquam natoque, tortor dui, vestibulum
                                                        vulputate pulvinar iaculis magna lectus ut, facilisis id mollis
                                                        risus lorem. Massa nulla cum nunc litora ac amet, accumsan
                                                        faucibus integer, vestibulum turpis cras, ante imperdiet
                                                        tincidunt accumsan, vivamus lacinia bibendum augue maiores
                                                        mauris.</p>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <!--End Product Info Tabs-->

                                <!-- Related Products -->
                                <div class="related-products">
                                    <div class="sec-title">
                                        <h2>Related products</h2>
                                    </div>

                                    <div class="row clearfix">
                                        <!-- Shop Item -->
                                        <div class="shop-item col-lg-4 col-md-6 col-sm-12">
                                            <div class="inner-box">
                                                <div class="image-box">
                                                    <div class="sale-tag">sale!</div>
                                                    <figure class="image"><a href="shop-single.html"><img
                                                                src="images/products/pic1.jpg" alt=""></a></figure>
                                                    <div class="btn-box"><a href="shopping-cart.html">Add to cart</a>
                                                    </div>
                                                </div>
                                                <div class="lower-content">
                                                    <h4 class="name"><a href="shop-single.html">Lemon Cake</a></h4>
                                                    <div class="rating"><span class="fa fa-star"></span><span
                                                            class="fa fa-star"></span><span
                                                            class="fa fa-star"></span><span
                                                            class="fa fa-star"></span><span
                                                            class="fa fa-star light"></span>
                                                    </div>
                                                    <div class="price">$17.00</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Shop Item -->
                                        <div class="shop-item col-lg-4 col-md-6 col-sm-12">
                                            <div class="inner-box">
                                                <div class="image-box">
                                                    <figure class="image"><a href="shop-single.html"><img
                                                                src="images/products/pic2.jpg" alt=""></a></figure>
                                                    <div class="btn-box"><a href="shopping-cart.html">Add to cart</a>
                                                    </div>
                                                </div>
                                                <div class="lower-content">
                                                    <h4 class="name"><a href="shop-single.html">Coffee Cake</a></h4>
                                                    <div class="rating"><span class="fa fa-star"></span><span
                                                            class="fa fa-star"></span><span
                                                            class="fa fa-star"></span><span
                                                            class="fa fa-star"></span><span
                                                            class="fa fa-star light"></span>
                                                    </div>
                                                    <div class="price">$35.00</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Shop Item -->
                                        <div class="shop-item col-lg-4 col-md-6 col-sm-12">
                                            <div class="inner-box">
                                                <div class="image-box">
                                                    <figure class="image"><a href="shop-single.html"><img
                                                                src="images/products/pic6.jpg" alt=""></a></figure>
                                                    <div class="btn-box"><a href="shopping-cart.html">Add to cart</a>
                                                    </div>
                                                </div>
                                                <div class="lower-content">
                                                    <h4 class="name"><a href="shop-single.html">Candy Cake</a></h4>
                                                    <div class="rating"><span class="fa fa-star"></span><span
                                                            class="fa fa-star"></span><span
                                                            class="fa fa-star"></span><span
                                                            class="fa fa-star"></span><span
                                                            class="fa fa-star light"></span>
                                                    </div>
                                                    <div class="price">$17.00</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End Related Products -->
                            </div><!-- Product Detail -->
                        </div><!-- End Shop Single -->
                    </div>






                    <!-- Main Footer -->
                    <footer class="main-footer style-seven">
                        <div class="shape_wrapper wave_up">
                            <div class="shape_inner"
                                style="background-image: url(https://via.placeholder.com/1920x600);">
                                <div class="overlay"></div>
                            </div>
                        </div>

                        <!--Widgets Section-->
                        <div class="widgets-section">
                            <div class="auto-container">
                                <div class="row">
                                    <!--Footer Column-->
                                    <div class="footer-column col-lg-4 col-md-12 col-sm-12">
                                        <div class="footer-widget social-widget">
                                            <div class="widget-title">
                                                <h3>Our Contacts</h3>
                                                <svg viewBox="0 0 850.4 410.3">
                                                    <path
                                                        d="M351.6,300.8c45.5,20.8,90.4,42.8,136.4,62.5c23,9.8,43.7,15,68.7,16.8c24.2,1.7,26.9-11.4,47.7-17.2 c36.4-10.2,50.6,30.7,12.4,39.4c-47,10.7-90.1,11.7-135.8-5.3c-43.6-16.2-84-40.4-125.5-61.1c-19.3-9.6-41-21.4-63.2-19.4 c-25.3,2.3-48.4,14.1-74.3,15.3c-33.4,1.5-101.6-4.4-107.8-47.3c-8-55.4,62.8-44,94.4-37.5c27.8,5.7,54.3,16.5,81.9,22 c27.9,5.7,49.2-4.2,74.5-15.3c49.2-21.6,108.5-37,152.6-67.4c-73-44.3-144.1-91.2-222.1-126.4c-68.4-30.9-157.2-64-226-12.7 c-11.1,8.3-20.3,19.6-26,32.2c-6.4,14-2.7,29.4-7.8,42.9C27.4,133.4,16,141,4.9,129.5c-10.1-10.4-2-33.4,2.1-44.6 C28.2,27.4,86.9,0.5,145,0c78.1-0.7,153.1,31.3,222.4,64.4c35.5,16.9,70.1,35.7,103.2,56.8c30.6,19.5,61.9,54.4,100.8,39.3 c68.6-26.4,131.4-75.9,210-57.7c57.6,13.4,99.3,84.7,40.5,125.7c-32.5,22.7-74.6,30.1-113.6,30c-42.6-0.1-77.9-19.1-117-32.7 c-41.5-14.4-84.9,10.2-124.1,24.2C448.9,256.6,351.9,281.1,351.6,300.8z M604.7,191.1c24.8,28.8,71.1,34.9,107.4,34.4 c31.8-0.4,94.3-7.9,110.4-41.2c23.9-49.5-49.1-56-77.9-51.8C695.1,139.9,649,169.4,604.7,191.1z M131.1,283.8 c25.5,27.4,91,30.7,122.6,7.1C212.6,263.8,153.1,259.8,131.1,283.8z">
                                                    </path>
                                                </svg>
                                            </div>

                                            <div class="text-box">
                                                <p>250 Biscayne Blvd. (North) 11st Floor <br>New World Tower Miami,
                                                    Florida
                                                    33148
                                                </p>
                                                <p><a href="tel:305-333-5522">(305) 333-5522</a></p>
                                                <p><a href="mailto:info@your-site.com">info@your-site.com</a></p>
                                            </div>

                                            <div class="social-box">
                                                <ul class="social-icon-two">
                                                    <li><a href="#"><span class="fab fa-facebook-f"></span></a></li>
                                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a>
                                                    </li>
                                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                                    <li><a href="#"><span class="fab fa-dribbble"></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Footer Column-->
                                    <div class="footer-column col-lg-4 col-md-12 col-sm-12">
                                        <div class="footer-widget gallery-widget">
                                            <div class="widget-title">
                                                <h3>Made For You</h3>
                                                <svg viewBox="0 0 850.4 410.3">
                                                    <path
                                                        d="M351.6,300.8c45.5,20.8,90.4,42.8,136.4,62.5c23,9.8,43.7,15,68.7,16.8c24.2,1.7,26.9-11.4,47.7-17.2 c36.4-10.2,50.6,30.7,12.4,39.4c-47,10.7-90.1,11.7-135.8-5.3c-43.6-16.2-84-40.4-125.5-61.1c-19.3-9.6-41-21.4-63.2-19.4 c-25.3,2.3-48.4,14.1-74.3,15.3c-33.4,1.5-101.6-4.4-107.8-47.3c-8-55.4,62.8-44,94.4-37.5c27.8,5.7,54.3,16.5,81.9,22 c27.9,5.7,49.2-4.2,74.5-15.3c49.2-21.6,108.5-37,152.6-67.4c-73-44.3-144.1-91.2-222.1-126.4c-68.4-30.9-157.2-64-226-12.7 c-11.1,8.3-20.3,19.6-26,32.2c-6.4,14-2.7,29.4-7.8,42.9C27.4,133.4,16,141,4.9,129.5c-10.1-10.4-2-33.4,2.1-44.6 C28.2,27.4,86.9,0.5,145,0c78.1-0.7,153.1,31.3,222.4,64.4c35.5,16.9,70.1,35.7,103.2,56.8c30.6,19.5,61.9,54.4,100.8,39.3 c68.6-26.4,131.4-75.9,210-57.7c57.6,13.4,99.3,84.7,40.5,125.7c-32.5,22.7-74.6,30.1-113.6,30c-42.6-0.1-77.9-19.1-117-32.7 c-41.5-14.4-84.9,10.2-124.1,24.2C448.9,256.6,351.9,281.1,351.6,300.8z M604.7,191.1c24.8,28.8,71.1,34.9,107.4,34.4 c31.8-0.4,94.3-7.9,110.4-41.2c23.9-49.5-49.1-56-77.9-51.8C695.1,139.9,649,169.4,604.7,191.1z M131.1,283.8 c25.5,27.4,91,30.7,122.6,7.1C212.6,263.8,153.1,259.8,131.1,283.8z">
                                                    </path>
                                                </svg>
                                            </div>

                                            <div class="instagram-gallery">
                                                <div class="outer-box clearfix">
                                                    <figure class="image"><a href="https://via.placeholder.com/150x150"
                                                            class="lightbox-image" data-fancybox='instagram'><img
                                                                src="https://via.placeholder.com/150x150" alt=""></a>
                                                    </figure>

                                                    <figure class="image"><a href="https://via.placeholder.com/150x150"
                                                            class="lightbox-image" data-fancybox='instagram'><img
                                                                src="https://via.placeholder.com/150x150" alt=""></a>
                                                    </figure>

                                                    <figure class="image"><a href="https://via.placeholder.com/150x150"
                                                            class="lightbox-image" data-fancybox='instagram'><img
                                                                src="https://via.placeholder.com/150x150" alt=""></a>
                                                    </figure>

                                                    <figure class="image"><a href="https://via.placeholder.com/150x150"
                                                            class="lightbox-image" data-fancybox='instagram'><img
                                                                src="https://via.placeholder.com/150x150" alt=""></a>
                                                    </figure>

                                                    <figure class="image"><a href="https://via.placeholder.com/150x150"
                                                            class="lightbox-image" data-fancybox='instagram'><img
                                                                src="https://via.placeholder.com/150x150" alt=""></a>
                                                    </figure>

                                                    <figure class="image"><a href="https://via.placeholder.com/150x150"
                                                            class="lightbox-image" data-fancybox='instagram'><img
                                                                src="https://via.placeholder.com/150x150" alt=""></a>
                                                    </figure>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Footer Column-->
                                    <div class="footer-column col-lg-4 col-md-12 col-sm-12">
                                        <div class="footer-widget contact-widget">
                                            <div class="widget-title">
                                                <h3>Order Your Sweet</h3>
                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                    viewBox="0 0 850.4 410.3">
                                                    <path
                                                        d="M351.6,300.8c45.5,20.8,90.4,42.8,136.4,62.5c23,9.8,43.7,15,68.7,16.8c24.2,1.7,26.9-11.4,47.7-17.2 c36.4-10.2,50.6,30.7,12.4,39.4c-47,10.7-90.1,11.7-135.8-5.3c-43.6-16.2-84-40.4-125.5-61.1c-19.3-9.6-41-21.4-63.2-19.4 c-25.3,2.3-48.4,14.1-74.3,15.3c-33.4,1.5-101.6-4.4-107.8-47.3c-8-55.4,62.8-44,94.4-37.5c27.8,5.7,54.3,16.5,81.9,22 c27.9,5.7,49.2-4.2,74.5-15.3c49.2-21.6,108.5-37,152.6-67.4c-73-44.3-144.1-91.2-222.1-126.4c-68.4-30.9-157.2-64-226-12.7 c-11.1,8.3-20.3,19.6-26,32.2c-6.4,14-2.7,29.4-7.8,42.9C27.4,133.4,16,141,4.9,129.5c-10.1-10.4-2-33.4,2.1-44.6 C28.2,27.4,86.9,0.5,145,0c78.1-0.7,153.1,31.3,222.4,64.4c35.5,16.9,70.1,35.7,103.2,56.8c30.6,19.5,61.9,54.4,100.8,39.3 c68.6-26.4,131.4-75.9,210-57.7c57.6,13.4,99.3,84.7,40.5,125.7c-32.5,22.7-74.6,30.1-113.6,30c-42.6-0.1-77.9-19.1-117-32.7 c-41.5-14.4-84.9,10.2-124.1,24.2C448.9,256.6,351.9,281.1,351.6,300.8z M604.7,191.1c24.8,28.8,71.1,34.9,107.4,34.4 c31.8-0.4,94.3-7.9,110.4-41.2c23.9-49.5-49.1-56-77.9-51.8C695.1,139.9,649,169.4,604.7,191.1z M131.1,283.8 c25.5,27.4,91,30.7,122.6,7.1C212.6,263.8,153.1,259.8,131.1,283.8z">
                                                    </path>
                                                </svg>
                                            </div>

                                            <div class="footer-form">
                                                <form action="#" method="post" id="email-form">
                                                    <div class="form-group">
                                                        <div class="response"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="text" name="username" class="username"
                                                            placeholder="Your Name *">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="email" name="email" class="email"
                                                            placeholder="Your Email *">
                                                    </div>

                                                    <div class="form-group">
                                                        <textarea name="contact_message"
                                                            placeholder="Text Message"></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <button class="theme-btn" type="button" id="submit"
                                                            name="submit-form">Send</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Footer Bottom-->
                        <div class="footer-bottom">
                            <div class="auto-container">
                                <div class="copyright-text">
                                    <p>The Cake Kitchen</p>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- End Footer -->

                </div><!-- End Page Wrapper -->

                <!-- Scroll To Top -->
                <div class="scroll-to-top scroll-to-target" data-target="html">
                    <svg viewBox="0 0 500 500">
                        <path
                            d="M488.5,274.5L488.5,274.5l1.8-0.5l-2,0.5c-2.4-8.7-4.5-16.9-4.5-24.5c0-8,2.3-16.5,4.7-25.5
        c3.5-13,7.1-26.5,3.7-39.5c-3.6-13.2-13.5-23.1-23.1-32.7c-6.5-6.5-12.6-12.6-16.6-19.4c-3.9-6.8-6.1-15.2-8.5-24.1
        c-3.5-13.1-7.1-26.7-16.7-36.3c-9.5-9.5-22.9-13.1-35.9-16.6c-9-2.4-17.5-4.6-24.4-8.7c-6.5-3.8-12.5-9.8-18.9-16.2
        c-9.7-9.8-19.6-19.8-33.2-23.4c-13.5-3.7-27.3,0.1-40.4,3.7c-8.7,2.4-16.9,4.6-24.5,4.6c-8,0-16.5-2.3-25.5-4.7
        c-9.3-2.5-18.8-5-28.1-5c-3.8,0-7.6,0.4-11.3,1.4C172,11.1,162,21.1,152.4,30.7c-6.5,6.5-12.6,12.6-19.4,16.6
        c-6.8,3.9-15.2,6.1-24.1,8.5c-13.1,3.5-26.7,7.1-36.3,16.7c-9.5,9.5-13.1,23-16.6,36c-2.4,9-4.6,17.5-8.7,24.4
        c-3.8,6.5-9.8,12.5-16.2,18.9c-9.8,9.7-19.7,19.6-23.4,33.2c-3.7,13.5,0.1,27.3,3.7,40.5c2.4,8.7,4.6,16.9,4.6,24.5
        c0,8-2.3,16.5-4.6,25.5c-3.5,13-7.1,26.6-3.7,39.5c3.6,13.2,13.5,23.1,23.1,32.7c6.5,6.5,12.6,12.6,16.6,19.4
        c3.9,6.8,6.1,15.1,8.5,24c3.5,13.1,7.1,26.8,16.7,36.4c9.5,9.5,23,13.1,35.9,16.6c9,2.4,17.5,4.6,24.4,8.7
        c6.5,3.8,12.5,9.8,18.9,16.2c9.7,9.8,19.6,19.8,33.2,23.5c3.8,1,7.6,1.5,11.8,1.5c9.6,0,19.3-2.7,28.5-5.1c8.8-2.4,17-4.6,24.5-4.6 c8,0,16.5,2.3,25.5,4.6c13,3.6,26.6,7.1,39.5,3.7c13.2-3.6,23.1-13.5,32.7-23.1c6.5-6.5,12.6-12.6,19.4-16.6 c6.7-3.9,15.1-6.1,24-8.5c13.1-3.5,26.8-7.1,36.4-16.8c9.5-9.5,13.1-23,16.6-36c2.4-9,4.6-17.5,8.7-24.4c3.8-6.5,9.8-12.5,16.2-18.9 c9.8-9.7,19.9-19.7,23.6-33.3C495.7,301.4,494.4,287.7,488.5,274.5z">
                        </path>
                    </svg>
                    <span class="fa fa-angle-up"></span>
                </div>


                <script>
                $(document).ready(function() {
                    var sizes = <?php echo !empty($sizes) ? json_encode($sizes) : 'null'; ?>;
                    var defaultPrice = <?php echo !empty($sizes) ? reset($sizes) : 0; ?>;

                    $('#size').on('change', function() {
                        var selectedWeight = $(this).val();
                        var price = (sizes && sizes[selectedWeight]) || 0;
                        $('#selected-price').text('Price: $' + price);
                    });

                    // Set the default price
                    $('#selected-price').text('Price: $' + defaultPrice);
                });




                // Wait for the DOM to load
                document.addEventListener('DOMContentLoaded', function() {
                    var notificationContainer = document.getElementById('notification-container');
                    var notifications = notificationContainer.getElementsByClassName('notification');

                    // Loop through each notification and add a click event listener
                    for (var i = 0; i < notifications.length; i++) {
                        var notification = notifications[i];
                        notification.addEventListener('click', function() {
                            this.style.display = 'none'; // Hide the notification on click
                        });
                    }
                });
                </script>
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