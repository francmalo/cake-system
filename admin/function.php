<?php
include 'dbconn.php';
function fill_category_list($connect, $id){
  $query = "
  SELECT * FROM category
  WHERE active = 1
  ORDER BY category_name ASC
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  foreach($result as $row)
  {
   if($row[0]==$id){
     $output .= '<option value="'.$row["category_id"].'" selected>'.$row["category_name"].'</option>';
   }
   else{
     $output .= '<option value="'.$row["category_id"].'">'.$row["category_name"].'</option>';
   }
  }
  return $output;
}

function fill_product_list($connect, $id){
  $query = "
  SELECT * FROM product
  WHERE status = 1
  ORDER BY product_name ASC
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  foreach($result as $row)
  {
   if($row[0]==$id){
     $output .= '<option value="'.$row["product_id"].'" selected>'.$row["product_name"].'</option>';
   }
   else{
     $output .= '<option value="'.$row["product_id"].'">'.$row["product_name"].'</option>';
   }
  }
  return $output;
}
function get_neworder_total($connect){
  $statement=$connect->prepare("SELECT * FROM orders WHERE order_status=:order_status");
  $statement->execute(array(":order_status"=>0));
  return $statement->rowCount();
}
function get_confirmedorder_total($connect){
  $statement=$connect->prepare("SELECT * FROM orders WHERE order_status=:order_status");
  $statement->execute(array(":order_status"=>1));
  return $statement->rowCount();
}
function get_delivereddorder_total($connect){
  $statement=$connect->prepare("SELECT * FROM orders WHERE order_status=:order_status");
  $statement->execute(array(":order_status"=>3));
  return $statement->rowCount();
}
function get_alldorder_total($connect){
  $statement=$connect->prepare("SELECT * FROM orders WHERE order_status=0 OR order_status=1 OR order_status=2 OR order_status=3 ");
  $statement->execute();
  return $statement->rowCount();
}

function get_order_status($connect, $id){
  $query = "
  SELECT order_status FROM orders
  WHERE order_id = :order_id
  ";
  $statement = $connect->prepare($query);
  $statement->execute(array(":order_id"=> $id));
  $result = $statement->fetchColumn();

  return $result;
}

function get_invoice_status($connect, $id){
  $query = "
  SELECT invoice_status FROM orders
  WHERE order_id = :order_id
  ";
  $statement = $connect->prepare($query);
  $statement->execute(array(":order_id"=> $id));
  $result = $statement->fetchColumn();
  $output='';
  if($result==1){
    $output='<a
      href="view-invoice.php?id='.$id.'"
      class="btn btn-info btn-sm text-white"
    >
    <span class="fas fa-list"></span>
      Invoice Generated
    </a>';
  }
  else {
    $output='<button id="generate_invoice" order_id="'.$id.'"
      type="button"
      class="btn btn-dark btn-sm text-white"
    >
    <span class="fas fa-list"></span>
      Generate Invoice
    </button>';
  }

  return $output;
}
function get_order_total($connect, $order_id){
  $statement=$connect->prepare("SELECT SUM(quantity*price) as total FROM orderline WHERE order_id=:order_id");
  $statement->execute(array(":order_id"=>$order_id));
  return $statement->fetchColumn();
}
function get_deposit($connect, $order_id){
  $statement=$connect->prepare("SELECT Amount as total FROM payment WHERE order_id=:order_id and name=:name");
  $statement->execute(array(
    ":order_id"=>$order_id,
    ":name"=> "Deposit"
  ));
  return $statement->fetchColumn();
}
function get_invoice_date($connect, $order_id){
  $statement=$connect->prepare("SELECT date_created as mydate FROM invoice WHERE order_id=:order_id");
  $statement->execute(array(":order_id"=>$order_id));
  return $statement->fetchColumn();
}
function get_customer_header($connect, $order_id){
  $statement=$connect->prepare("SELECT *  FROM orders o INNER JOIN customers c ON o.user_id=c.user_id WHERE o.order_id=:order_id");
  $statement->execute(array(":order_id"=>$order_id));
  foreach($statement->fetchAll() as $row){
    echo '
    <address>
      <h3>To,</h3>
      <h4 class="font-bold">'.$row["first_name"].' '.$row["second_name"].',</h4>
      <p class="text-muted ms-4">
        '.$row["address"].', <br />
        '.$row["phone"].' <br />


      </p>
      <p class="mt-4">
        <b>Invoice Date :</b>
        <i class="mdi mdi-calendar"></i> '.date("d M Y", strtotime(get_invoice_date($connect, $row["order_id"]))).'
      </p>
      <p class="mt-4">
        <b>Order Date :</b>
        <i class="mdi mdi-calendar"></i> '.date("d M Y", strtotime($row["order_date"])).'
      </p>
      <p>
        <b>Delivery Date :</b>
        <i class="mdi mdi-calendar"></i> '.date("d M Y", strtotime($row["delivery_date"])).'
      </p>
    </address>
    ';
  }
}
function get_customer_header_order($connect, $order_id){
  $statement=$connect->prepare("SELECT *  FROM orders o INNER JOIN customers c ON o.user_id=c.user_id WHERE o.order_id=:order_id");
  $statement->execute(array(":order_id"=>$order_id));
  foreach($statement->fetchAll() as $row){
    echo '
    <address>
      <h3>To,</h3>
      <h4 class="font-bold">'.$row["first_name"].' '.$row["second_name"].',</h4>
      <p class="text-muted ms-4">
        '.$row["address"].', <br />
        '.$row["phone"].' <br />


      </p>
      
      <p class="mt-4">
        <b>Order Date :</b>
        <i class="mdi mdi-calendar"></i> '.date("d M Y", strtotime($row["order_date"])).'
      </p>
      <p>
        <b>Delivery Date :</b>
        <i class="mdi mdi-calendar"></i> '.date("d M Y", strtotime($row["delivery_date"])).'
      </p>
    </address>
    ';
  }
}
function get_total_paid($connect, $order_id){
  $statement=$connect->prepare("SELECT SUM(Amount) as total FROM payment WHERE order_id=:order_id");
  $statement->execute(array(":order_id"=>$order_id));
  return $statement->fetchColumn();
}

function order_tracking($connect, $order_id){
  $statement=$connect->prepare("SELECT * FROM orders WHERE order_id=:order_id");
  $statement->execute(array(":order_id"=>$order_id));

  foreach($statement->fetchAll() as $row){
    $status=$row["order_status"];
  if($status== 0){
    echo '<div class="">
    <div class="row">
              <div class="col-12 col-md-10 hh-grayBox pt45 pb20">
                <div class="row justify-content-between">
                  <div class="order-tracking completed">
                    <span class="is-complete"></span>
                    <p>Ordered<br><span>'.date("D, d M Y", strtotime($row["order_date"])).'</span></p>
                  </div>
                  <div class="order-tracking ">
                    <span class="is-complete"></span>
                    <p>Shipped<br><span>Waiting</span></p>
                  </div>
                  <div class="order-tracking">
                    <span class="is-complete"></span>
                    <p>Delivered<br><span>Waiting</span></p>
                  </div>
                </div>
              </div>
            </div>
  </div>';
  }
  if($status== 1){
    echo '<div class="container">
    <div class="row">
              <div class="col-12 col-md-10 hh-grayBox pt45 pb20">
                <div class="row justify-content-between">
                  <div class="order-tracking completed">
                    <span class="is-complete"></span>
                    <p>Ordered<br><span>'.date("D, d M Y", strtotime($row["order_date"])).'</span></p>
                  </div>
                  <div class="order-tracking ">
                    <span class="is-complete"></span>
                    <p>Shipped<br><span>Waiting</span></p>
                  </div>
                  <div class="order-tracking">
                    <span class="is-complete"></span>
                    <p>Delivered<br><span>Waiting</span></p>
                  </div>
                </div>
              </div>
            </div>
  </div>';
  }
  if($status== 2){
    echo '<div class="container">
    <div class="row">
              <div class="col-12 col-md-10 hh-grayBox pt45 pb20">
                <div class="row justify-content-between">
                  <div class="order-tracking completed">
                    <span class="is-complete"></span>
                    <p>Ordered<br><span>'.date("D, d M Y", strtotime($row["order_date"])).'</span></p>
                  </div>
                  <div class="order-tracking completed">
                    <span class="is-complete"></span>
                    <p>Shipped<br><span>'.date("D, d M Y", strtotime($row["date_dispatched"])).'</span></p>
                  </div>
                  <div class="order-tracking">
                    <span class="is-complete"></span>
                    <p>Delivered<br><span> Waiting</span></p>
                  </div>
                </div>
              </div>
            </div>
  </div>';
  }
  if($status== 3){
    echo '<div class="col-md-12">
    <div class="row">
              <div class="col-12 col-md-10 hh-grayBox pt45 pb20">
                <div class="row justify-content-between">
                  <div class="order-tracking completed">
                    <span class="is-complete"></span>
                    <p>Ordered<br><span>'.date("D, d M Y", strtotime($row["order_date"])).'</span></p>
                  </div>

                  <div class="order-tracking completed">
                    <span class="is-complete"></span>
                    <p>Shipped<br><span>'.date("D, d M Y", strtotime($row["date_dispatched"])).'</span></p>
                  </div>
                  <div class="order-tracking completed">
                    <span class="is-complete"></span>
                    <p>Delivered<br><span> '.date("D, d M Y", strtotime($row["date_delivered"])).'</span></p>
                  </div>
                </div>
              </div>
            </div>
  </div>';
  }
}
}

function get_total_sales($connect){
  $query = "
  SELECT SUM(ol.quantity*ol.price) as value FROM orderline ol INNER JOIN orders o ON o.order_id=ol.order_id WHERE o.order_status=3 AND ol.orderline_status=1
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchColumn();

  return $result;
}
function get_total_sales_count($connect){
  $query = "
  SELECT * FROM orders
  WHERE order_status=3
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->rowCount();

  return $result;
}
function get_total_orders($connect){
  $query = "
  SELECT
  SUM(ol.quantity*ol.price) as myvalue FROM orderline ol INNER JOIN orders o ON o.order_id=ol.order_id WHERE (o.order_status=1 OR o.order_status=2 OR o.order_status=3) AND ol.orderline_status=1
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchColumn();

  return $result;
}
function get_total_orders_count($connect){
  $query = "
  SELECT * FROM orders o
  WHERE (o.order_status=1 OR o.order_status=2 OR o.order_status=3)
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->rowCount();

  return $result;
}
function get_weight($connect, $id){
  $query = "
  SELECT weight FROM pricelist p
  WHERE p.pricelist_id=:pricelist_id
  ";
  $statement = $connect->prepare($query);
  $statement->execute(array(':pricelist_id' => $id));
  $result = $statement->fetchColumn();

  return $result;
}



if(isset($_POST["btn_action"])){
  if($_POST["btn_action"]=='add-product'){
    $qry="INSERT INTO product (product_name, product_desc, category_id, current_price, prev_price) VALUES (:product_name, :product_desc, :category_id, :current_price, :prev_price)";
    $statement=$connect->prepare($qry);
    $statement->execute(array(
      ':product_name' => $_POST["product_name"],
      ':product_desc' => $_POST["product_desc"],
      ':category_id' => $_POST["category"],
      ':current_price' => $_POST["cprice"],
      ':prev_price' => $_POST["pprice"]
    ));


  }

  if($_POST["btn_action"]=='edit-product'){
    $qry="UPDATE product SET
    product_name =:product_name,
     product_desc =:product_desc,
    category_id =:category_id,
    current_price =:current_price,
    prev_price =:prev_price
    WHERE product_id=:product_id";
    $statement=$connect->prepare($qry);
    $statement->execute(array(
      ':product_name' => $_POST["product_name"],
      ':product_desc' => $_POST["product_desc"],
      ':category_id' => $_POST["category"],
      ':current_price' => $_POST["cprice"],
      ':prev_price' => $_POST["pprice"],
      ':product_id' => $_POST["product_id"]
    ));


  }

  if($_POST["btn_action"]=='get-product-detail'){
    $statement=$connect->prepare("SELECT * FROM product WHERE product_id=:product_id");
    $statement->execute(array(
      ':product_id' => $_POST["product_id"]
    ));
    $output='';
    foreach($statement->fetchAll() as $row){
      $output .='
      <div class="form-group">
        <label for="">Select Category</label>
        <select class="form-control form-contrl-sm" name="category">
          <option value="">--select--</option>
          '.fill_category_list($connect, $row["category_id"]).'
        </select>
      </div>
      <div class="form-group">
        <label for="">Product Name</label>
        <input class="form-control form-contrl-sm" type="product_name" name="product_name" value="'.$row["product_name"].'">
      </div>
      <div class="form-group">
        <label for="">Product Description</label>
        <textarea name="product_desc" class="form-control form-contrl-sm" rows="4" cols="80">'.$row["product_desc"].'</textarea>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Current Price</label>
            <input class="form-control form-contrl-sm" type="number" name="cprice" value="'.$row["current_price"].'">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Previous Price</label>
            <input class="form-control form-contrl-sm" type="number" name="pprice" value="'.$row["prev_price"].'">
          </div>
        </div>
      </div>
      ';
    }
    echo $output;
  }
  if($_POST['btn_action'] == 'delete_product')
  {
   $status = 1;
   if($_POST['status'] == 1)
   {
    $status = 0;
   }
   $query = "
   UPDATE product
   SET status = :status
   WHERE product_id = :product_id
   ";
   $statement = $connect->prepare($query);
   $statement->execute(
    array(
     ':status' => $status,
     ':product_id'  => $_POST["product_id"]
    )
   );
   $result = $statement->fetchAll();
   if(isset($result))
   {
    echo 'product status change to ' . $status;
   }
  }
}
 ?>
