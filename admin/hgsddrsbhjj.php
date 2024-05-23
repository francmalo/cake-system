<?php
    include 'database_connection.php';
if(isset($_POST["btn_action"])){
  include 'function.php';
include_once ('vendor/autoload.php');
$mpesa= new \Safaricom\Mpesa\Mpesa();
if($_POST["btn_action"]=='hvhkvhvhjcfgxjklkgdxxfj'){
  date_default_timezone_set("Africa/Nairobi");
  $timestamp = date('yyyymmddhhiiss');
  // echo $timestamp.'<br>';
  // echo $timestamp.'<br>';
  $password = base64_encode('50966afd61759c1e0d63250e12655b8069c7f2722574ebbf8c94ca484368e041'.$timestamp.'');
  $BusinessShortCode='176339';
  $LipaNaMpesaPasskey='50966afd61759c1e0d63250e12655b8069c7f2722574ebbf8c94ca484368e041';
  $TransactionType='CustomerPayBillOnline';
  //$Amount=$_POST["amountpayable"];
  $Amount=10;
  $PartyA=$_POST["value"];
  $PartyB='176339';
  $PhoneNumber=$_POST["value"];
  $CallBackURL='https://www.aaagrowers.co.ke/orders/get_response.php?dfvwefrhtyrueue='.$_SESSION["clientordernumber"].'';
  $AccountReference='account';
  $TransactionDesc='checkout';
  $Remarks='';
  $result = json_decode($mpesa->STKPushSimulation($BusinessShortCode, $LipaNaMpesaPasskey, $TransactionType, $Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference, $TransactionDesc, $Remarks));
  echo json_encode($result);
}
if($_POST["btn_action"]=='hgfkgfdsrtjskdtrdyiolggfdsgt'){
  date_default_timezone_set("Africa/Nairobi");
  $timestamp = date('YmdHis');
  // echo $timestamp;
  // $timestamp='20200909033751';
  $password = base64_encode('17633950966afd61759c1e0d63250e12655b8069c7f2722574ebbf8c94ca484368e041'.$timestamp.'');
  $BusinessShortCode='176339';


  // $CheckoutRequestID=$result->CheckoutRequestID;
  // echo $CheckoutRequestID;
  $result= json_decode($mpesa->STKPushQuery($_POST["valueid"], $BusinessShortCode, $password, $timestamp));
  // session_start();
  // echo $_SESSION["callback"];
  // echo json_encode($result);
  //echo $result->ResultCode;
  echo 0;
}
if($_POST["btn_action"]=='hyfhyvrfgr5grg5rf6e8rgr6e'){
  //bulk payment
  $sqlgetinvoices="SELECT * FROM invoiceheader
  WHERE CustomerId=:CustomerId and PaymentStatus=:PaymentStatus0";
  $statement_invoices=$connect->prepare($sqlgetinvoices);
  $statement_invoices->execute(array(
    ':CustomerId' => $_SESSION["clientordernumber"],
    ':PaymentStatus0' => 0
  ));
 // print_r($statement_invoices->errorInfo());
  $result=$statement_invoices->fetchAll();
  foreach($result as $row){
    $sql="UPDATE invoiceheader SET
    PaymentStatus=:PaymentStatus,
    AmountPaid=:AmountPaid,
    DatePayed=:DatePayed,
    BulkAmount=:BulkAmount
    WHERE InvoiceHeaderId=:InvoiceHeaderId";
    $statement=$connect->prepare($sql);
    $statement->execute(array(
      ':PaymentStatus' => 1,
      ':AmountPaid' => getLineTotal($connect, $row["InvoiceHeaderId"]),
      ':DatePayed' => date('Y-m-d H:i:s'),
      ':BulkAmount' => $_POST["amountpayable"],
      ':InvoiceHeaderId' => $row["InvoiceHeaderId"]
    ));
    //print_r($statement->errorInfo()).'<br>';
  }
  if($_POST["claimvalue"] == 0){

  }
  else {
    echo insertIntoCaimTraceBulk($connect, $_POST["claimvalue"], getLastInvoiceHeaderId($connect, $_SESSION["clientordernumber"]));
    echo updateClaims($connect, $_SESSION["clientordernumber"]);
  }


//print_r($statement->errorInfo());
}
if($_POST["btn_action"]=='wegybkiyrdfgtydwerfyhyjytf'){
  //single payment
  echo 'single:'.$_POST["session_invoiceheaderid"];

  if($_POST["claimvalue"] == 0){
      echo '--inside 0';
    $sql="UPDATE invoiceheader SET
    PaymentStatus=:PaymentStatus,
    AmountPaid=:AmountPaid,
    DatePayed=:DatePayed
    WHERE InvoiceHeaderId=:InvoiceHeaderId";
    $statement=$connect->prepare($sql);
    $statement->execute(array(
      ':PaymentStatus' => 1,
      ':AmountPaid' => $_POST["amountpayable"],
      ':DatePayed' => date('Y-m-d H:i:s'),
      ':InvoiceHeaderId' => $_POST["session_invoiceheaderid"]
    ));
    print_r($statement->errorInfo());
  }
  else {
    $claimtraceid=insertIntoCaimTraceSingle($connect, $_POST["claimvalue"], $_POST["session_invoiceheaderid"]);
    echo updateClaims($connect, $_SESSION["clientordernumber"]);
    $sql="UPDATE invoiceheader SET
    PaymentStatus=:PaymentStatus,
    AmountPaid=:AmountPaid,
    DatePayed=:DatePayed,
    ClaimTraceId=:ClaimTraceId
    WHERE InvoiceHeaderId=:InvoiceHeaderId";
    $statement=$connect->prepare($sql);
    $statement->execute(array(
      ':PaymentStatus' => 1,
      ':AmountPaid' => $_POST["amountpayable"],
      ':DatePayed' => date('Y-m-d H:i:s'),
      ':ClaimTraceId' => $claimtraceid,
      ':InvoiceHeaderId' => $_POST["session_invoiceheaderid"]
    ));
  }

}
//checked payment
if($_POST["btn_action"]=='ndyhsavxdfsrweadclkjhs'){
  //checked payment
  $invoices=$_SESSION["invoices"];
foreach($invoices as $invoice){

  if($_POST["claimvalue"] == 0){
    $check_claim=0;
      echo '--inside 0';
    $sql="UPDATE invoiceheader SET
    PaymentStatus=:PaymentStatus,
    AmountPaid=:AmountPaid,
    DatePayed=:DatePayed
    WHERE InvoiceHeaderId=:InvoiceHeaderId";
    $statement=$connect->prepare($sql);
    $statement->execute(array(
      ':PaymentStatus' => 1,
      ':AmountPaid' => $_POST["amountpayable"],
      ':DatePayed' => date('Y-m-d H:i:s'),
      ':InvoiceHeaderId' => $invoice
    ));
    //print_r($statement->errorInfo());
  }
  else {
    $check_claim=1;
    $sql="UPDATE invoiceheader SET
    PaymentStatus=:PaymentStatus,
    AmountPaid=:AmountPaid,
    DatePayed=:DatePayed
    WHERE InvoiceHeaderId=:InvoiceHeaderId";
    $statement=$connect->prepare($sql);
    $statement->execute(array(
      ':PaymentStatus' => 1,
      ':AmountPaid' => $_POST["amountpayable"],
      ':DatePayed' => date('Y-m-d H:i:s'),
      ':InvoiceHeaderId' => $invoice
    ));
  }
  $invoicelast=$invoice;

}//end foreach invoice
if($check_claim==1){
  $claimtraceid=insertIntoCaimTraceSingle($connect, $_POST["claimvalue"], $invoicelast);
  $sql="UPDATE invoiceheader SET
  ClaimTraceId=:ClaimTraceId
  WHERE InvoiceHeaderId=:InvoiceHeaderId";
  $statement=$connect->prepare($sql);
  $statement->execute(array(
    ':ClaimTraceId' => $claimtraceid,
    ':InvoiceHeaderId' => $invoicelast
  ));
  echo updateClaims($connect, $_SESSION["clientordernumber"]);
}

}
// $MerchantRequestID=$result->MerchantRequestID;
// $CheckoutRequestID=$result->CheckoutRequestID;
// echo $CheckoutRequestID;
// echo $mpesa->STKPushQuery($CheckoutRequestID, $BusinessShortCode, $password, $timestamp);
// session_start();
// echo $_SESSION["callback"];

}
 ?>
