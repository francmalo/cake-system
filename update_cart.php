<?php
session_start();

// Add the product to the cart (assuming you have the necessary code for this)
// ...

// Prepare the response data
$total_items = 0;
$cart_items = '';

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['quantity'];
        $cart_items .= '<li class="cart-item">';
        $cart_items .= '<img src="' . $item['image_url'] . '" alt="#" class="thumb" />';
        $cart_items .= '<span class="item-name">' . $item['product_name'] . '</span>';
        $cart_items .= '<span class="item-quantity">' . $item['quantity'] . ' x <span class="item-amount">Ksh' . $item['price'] . '</span></span>';
        $cart_items .= '<a href="shop-single.html" class="product-detail"></a>';
        $cart_items .= '<button class="remove-item"><span class="fa fa-times"></span></button>';
        $cart_items .= '</li>';
    }
} else {
    $cart_items = '<li>Your cart is empty.</li>';
}

// Return the response as JSON
$response = array(
    'total_items' => $total_items,
    'cart_items' => $cart_items
);

echo json_encode($response);
exit;