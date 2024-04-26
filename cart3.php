<?php
// Start the session
session_start();
// Set the session lifetime (if needed)
 ini_set('session.gc_maxlifetime', 3600); // 1 hour

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    return;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update quantities or remove items
    foreach ($_SESSION['cart'] as $key => $item) {
        if (isset($_POST['quantity'][$key]) && $_POST['quantity'][$key] > 0) {
            $_SESSION['cart'][$key]['quantity'] = $_POST['quantity'][$key];
        } else {
            unset($_SESSION['cart'][$key]);
        }
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

</head>

<body>


    <script>
    // Get all quantity input fields
    const quantityInputs = document.querySelectorAll('.qty');
    const subtotalElement = document.querySelector('.totals-table .price');
    const totalElement = document.querySelector('.totals-table .total-price');

    // Function to update the subtotal and total
    function updateTotals() {
        let total = 0;
        quantityInputs.forEach(function(input) {
            const itemPrice = parseFloat(input.dataset.price);
            const quantity = parseInt(input.value);
            const itemTotal = itemPrice * quantity;
            total += itemTotal;
        });

        // Update the subtotal and total elements
        subtotalElement.textContent = `$${total.toFixed(2)}`;
        totalElement.textContent = `$${total.toFixed(2)}`;
    }

    // Loop through each input field and add event listeners
    quantityInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            const itemPrice = parseFloat(this.dataset.price);
            const quantity = parseInt(this.value);
            const itemTotal = itemPrice * quantity;

            // Find the corresponding total element and update its value
            const itemTotalElement = this.closest('tr').querySelector('.product-subtotal .amount');
            itemTotalElement.textContent = `$${itemTotal.toFixed(2)}`;

            // Update the subtotal and total
            updateTotals();
        });
    });

    // Update the totals initially
    updateTotals();
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