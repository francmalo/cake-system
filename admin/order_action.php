<?php
include 'function.php';
if(isset($_POST["btn_action"])){
  if($_POST["btn_action"]=="confirm_order"){
    $query = "
    UPDATE orders
    SET order_status = :order_status,
    confirmed_by = :confirmed_by,
    date_confirmed = :date_confirmed
    WHERE order_id = :order_id
    ";
    $statement = $connect->prepare($query);
    $statement->execute(
     array(
      ':order_status' => 1,
      ':confirmed_by' => 1,
      ':date_confirmed' => date('Y-m-d'),
      ':order_id'  => $_POST["order_id"]
    )
    );
  }

  if($_POST["btn_action"]=="dispatch_order"){
    $query = "
    UPDATE orders
    SET order_status = :order_status,
    dispatched_by = :dispatched_by,
    date_dispatched = :date_dispatched
    WHERE order_id = :order_id
    ";
    $statement = $connect->prepare($query);
    $statement->execute(
     array(
       ':order_status' => 2,
       ':dispatched_by' => 1,
       ':date_dispatched' => date('Y-m-d'),
       ':order_id'  => $_POST["order_id"]
     )
    );
  }

  if($_POST["btn_action"]=="deliver_order"){
    $query = "
    UPDATE orders
    SET order_status = :order_status,
    delivered_by = :delivered_by,
    date_delivered = :date_delivered
    WHERE order_id = :order_id
    ";
    $statement = $connect->prepare($query);
    $statement->execute(
     array(
       ':order_status' => 3,
       ':delivered_by' => 1,
       ':date_delivered' => date('Y-m-d'),
       ':order_id'  => $_POST["order_id"]
     )
    );
  }

  if($_POST["btn_action"]=="generate_invoice"){
    $statement_check=$connect->prepare("SELECT *  FROM invoice WHERE order_id=:order_id");
    $statement_check->execute(array(":order_id"=>$_POST["order_id"]));
    if($statement_check->rowCount()> 0){
      echo"Exists";
    }
    else{
      $query = "INSERT INTO invoice(order_id, customer_id, total_amount, invoice_status) VALUES(:order_id, :customer_id, :total_amount, :status)
        ";
    $statement = $connect->prepare($query);
    $statement->execute(
     array(
       ':order_id' => $_POST["order_id"],
       ':customer_id' => 1,
       ':total_amount' => get_order_total($connect, $_POST["order_id"]),
       ':status'  => 1
     )
    );

    $query_update = "UPDATE orders SET invoice_status=:invoice_status WHERE order_id=:order_id
        ";
    $statement_update = $connect->prepare($query_update);
    $statement_update->execute(
     array(
      ':invoice_status' => 1,
       ':order_id' => $_POST["order_id"]
     )
    );
    }
    
  }
}
 ?>
