<?php

//category_action.php

include('function.php');
//echo (isset($_POST["on_offer"])) ? ($_POST['on_offer']=="on") ? 1:0 : 0;
if(isset($_POST['btn_action']))
{
 if($_POST['btn_action'] == 'add-pricelist')
 {
    $query_check = "SELECT * FROM pricelist p WHERE p.product_id = :product_id AND p.weight=:weight";
  $statement_check = $connect->prepare($query_check);
  $statement_check->execute(
   array(
    ':product_id' => $_POST["product_id"],
    ':weight' => $_POST["weight"]
   )
  );
  if($statement_check->rowCount() == 0){
    $query = "
  INSERT INTO pricelist (product_id, weight, price, offer_price, start_date, end_date, on_offer)
  VALUES (:product_id, :weight, :price, :offer_price, :start_date, :end_date, :on_offer)
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    ':product_id' => $_POST["product_id"],
    ':weight' => $_POST["weight"],
    ':price' => $_POST["price"],
    ':offer_price' => ((isset($_POST["on_offer"])) ? $_POST["offer_price"] : null),
    ':start_date' => ((isset($_POST["on_offer"])) ? $_POST["start_date"] : null),
    ':end_date' => ((isset($_POST["on_offer"])) ?  : null),
    ':on_offer' =>(isset($_POST["on_offer"])) ? ($_POST['on_offer']=="on") ? 1:0 : 0
   )
  );
  $result = $statement->fetchAll();
  if(isset($result))
  {
   echo 'price Name Added';
  }
  }
  else{
    echo '1';
  }
  
 }

 if($_POST['btn_action'] == 'fetch_single')
 {
  $query = "SELECT * FROM pricelist WHERE pricelist_id = :pricelist_id";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    ':pricelist_id' => $_POST["pricelist_id"]
   )
  );
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   echo '<div class="form-group">
   <div class="input-group mb-3">
             <span style="width:100px" class="input-group-text" id="basic-addon1">Product </span>
             <select class="form-control form-contrl-sm" name="product_id" required>
             <option value="">--select--</option>
             '.fill_product_list($connect, $row["product_id"]).'
           </select>
             </div>
  
 </div>
 <div class="row">
     <div class="col-md-6">
     <div class="form-group">
     <div class="input-group mb-3">
             <span style="width:100px" class="input-group-text" id="basic-addon1">Weight (Kg)</span>
             <input type="number"  name="weight" class="form-control" placeholder="weight" value="'.$row["weight"].'"  aria-label="" aria-describedby="basic-addon1" required>
             </div>
     </div>
     </div>
     <div class="col-md-6">
     <div class="form-group">
     <div class="input-group mb-3">
             <span style="width:100px" class="input-group-text" id="basic-addon1">Price(KES)</span>
             <input type="number"  name="price" class="form-control" placeholder="price" value="'.$row["price"].'"  aria-label="" aria-describedby="basic-addon1" required>
             </div>
     </div>
     </div>
 </div>
 <hr>
 <div class="row">
     <div class="form-group">
         <label for="">Is on Offer</label>
         <input type="checkbox" name="on_offer" id="is-on-offer-edit" class="" '.(($row["on_offer"]==1) ? "checked" : "").'>
     </div>
 </div>
 <div class="row" id="offer-details-edit" style="display:'.(($row["on_offer"]==1) ? "block": "none").'">
 <div class="col-md-12">
     <div class="form-group">
         
     <div class="input-group mb-3">
             <span style="width:120px" class="input-group-text" id="basic-addon1">Offer Price (KES)</span>
             <input type="number"  name="offer_price" class="form-control" placeholder="" value="'.$row["offer_price"].'"  aria-label="" aria-describedby="basic-addon1" '.(($row["on_offer"]==1) ? "required": "").'>
             </div>
     </div>
     </div>
     <div class="col-md-12">
     <div class="form-group">
     
     <div class="input-group mb-3">
             <span style="width:120px" class="input-group-text" id="basic-addon1">Start Date</span>
             <input type="date"  name="start_date" class="form-control" placeholder="Start Date" value="'.(($row["start_date"]==null) ? "" : date("d-m-Y", strtotime($row["start_date"]))).'"  aria-label="" aria-describedby="basic-addon1" '.(($row["on_offer"]==1) ? "required": "").'>
             </div>
     </div>
     </div>
     <div class="col-md-12">
     
     <div class="form-group">
     <div class="input-group mb-3">
             <span style="width:120px" class="input-group-text" id="basic-addon1">End Date</i></span>
             <input type="date"  name="end_date" class="form-control" placeholder="End Date" value="'.(($row["end_date"]==null) ? "" : date("d-m-Y", strtotime($row["end_date"]))).'"  aria-label="" aria-describedby="basic-addon1" '.(($row["on_offer"]==1) ? "required": "").'>
             <input type="hidden" name="pricelist_id" value="'.$row["pricelist_id"].'" >
             </div>
     </div>
     </div>
 </div>
 ';
  }
//   echo json_encode($output);
 }

 if($_POST['btn_action'] == 'edit-pricelist')
 {
    $query = "
    UPDATE pricelist SET 
    product_id = :product_id,
    weight = :weight, 
    price = :price, 
    offer_price = :offer_price, 
    start_date = :start_date, 
    end_date = :end_date, 
    on_offer = :on_offer
    WHERE pricelist_id = :pricelist_id
    ";
    $statement = $connect->prepare($query);
    $statement->execute(
     array(
      ':product_id' => $_POST["product_id"],
      ':weight' => $_POST["weight"],
      ':price' => $_POST["price"],
      ':offer_price' => $_POST["offer_price"],
      ':start_date' => $_POST["start_date"],
      ':end_date' => $_POST["end_date"],
      ':on_offer' =>((isset($_POST["on_offer"])) ? ($_POST['on_offer']=="on") ? 1:0 : 0),
      ':pricelist_id' => $_POST["pricelist_id"]
     )
    );
    $result = $statement->fetchAll();
    if(isset($result))
    {
     echo 'price edited';
    }
 }
 if($_POST['btn_action'] == 'delete')
 {
  $status = 1;
  if($_POST['status'] == 1)
  {
   $status = 0;
  }
  $query = "
  UPDATE pricelist
  SET pricelist_status = :pricelist_status
  WHERE pricelist_id = :pricelist_id
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    ':pricelist_status' => $status,
    ':pricelist_id'  => $_POST["pricelist_id"]
   )
  );
  $result = $statement->fetchAll();
  if(isset($result))
  {
   echo 'price status change to ' . $status;
  }
 }
}

?>
