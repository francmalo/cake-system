<?php
// Start the session
session_start();

// Set the session save path (if needed)
// session_save_path('/path/to/session/directory');

// Set the session lifetime (if needed)
 ini_set('session.gc_maxlifetime', 3600); // 1 hour
?>
<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Shopping Cart</h1>
        <?php
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
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $key => $item) {
                        $itemTotal = $item['price'] * $item['quantity'];
                        $total += $itemTotal;
                        ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><input type="number" name="quantity[<?php echo $key; ?>]"
                                value="<?php echo $item['quantity']; ?>" min="1" class="form-control"></td>
                        <td>$<?php echo number_format($itemTotal, 2); ?></td>
                        <td><a href="?action=remove&key=<?php echo $key; ?>" class="btn btn-danger">Remove</a></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total:</th>
                        <th>$<?php echo number_format($total, 2); ?></th>
                        <th><button type="submit" class="btn btn-primary">Update Cart</button></th>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</body>

</html>