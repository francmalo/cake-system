<?php include('config.php');

function get_pricelist_dropdown($conn, $product_id){
    $sql2 = "SELECT pl.pricelist_id, pl.weight, pl.price
                 FROM pricelist pl
                 WHERE pl.product_id = ?
                 ORDER BY pl.weight ASC";

        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $product_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

    

        // Fetch all sizes (weights) and prices for the product
        $output='';
        while ($row = $result2->fetch_assoc()) {
            $output .='
            <option value="'.$row["pricelist_id"].'">'.$row["weight"].' Kg</option>
            ';
        }
}