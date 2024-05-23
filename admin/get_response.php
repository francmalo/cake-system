<?php
// include_once ('vendor/autoload.php');
// $mpesa= new \Safaricom\Mpesa\Mpesa();
// //creating httpserver
// $postData=$mpesa->getDataFromCallback();
$postData = file_get_contents('php://input');
   //perform your processing here, e.g. log to file....
   $file = fopen("log.txt", "a+"); //url fopen should be allowed for this to occur
   fwrite($file,".................................................");
   fwrite($file,"\n");
   $arrays = json_decode($postData, true);
    if(fwrite($file, $callback["CallbackMetadata"]) === FALSE)
           {
               fwrite("Error: no CallbackMetadata data written".date(yymdhis)."\n");
           }
//$arrays = json_decode($res, true);
if($arrays){
$servername="localhost";
$username="aaagrow_it";
$password='s~j0yZUEo@ZN';
$dbname="aaagrow_orders";
$con = mysqli_connect($servername, $username, $password, $dbname);
if (!$con)
{
die("Connection failed: " . mysqli_connect_error());
}

foreach($arrays as $array){
  $callback=$array["stkCallback"];
 $pst = json_encode($callback);
 $metadata=json_encode($callback["CallbackMetadata"]);
 $type =gettype($metadata);
if(fwrite($file, $callback["ResultDesc"]) === FALSE)
       {
           fwrite("Error: no data written");
       }
       $r1=json_decode($metadata);
       //echo gettype($r1).'<br>';
       $items = json_encode($r1->Item);
       //echo gettype($items).'<br>';
       //echo $items.'<br>';
       $r2=json_decode($items);
       $_SESSION["testing"] = $r2;
       //echo gettype($r2).'<br>';
       //echo $r2;
       $data=array();
       foreach($r2 as $r){
           //foreach($r as $key => $val){
           if($r->Name == "Amount"){
             $Amount = $r->Value;
           }
           if($r->Name == "MpesaReceiptNumber"){
             $MpesaReceiptNumber = $r->Value;
           }
           if($r->Name == "Balance"){

           }
           if($r->Name == "TransactionDate"){
             $TransactionDate = $r->Value;
           }
           if($r->Name == "PhoneNumber"){
             $PhoneNumber = $r->Value;
           }
           // else {
           //  // echo $r->Name.'-'.$r->Value.'<br>';
           // }

           //}
       }
       $CustomerId=$_GET["dfvwefrhtyrueue"];
       $sql="INSERT INTO test(
       name,
       metadata,
       type,
       Amount,
       MpesaReceiptNumber,
       TransactionDate,
       PhoneNumber,
       CustomerId
       )
       VALUES
       (
         '$pst',
         '$metadata',
         '$type',
         '$Amount',
         '$MpesaReceiptNumber',
         '$TransactionDate',
         '$PhoneNumber',
         '$CustomerId'
       )";

       if (!mysqli_query($con,$sql))

       {
       $conerr = mysqli_error($con);
       }


       else
       {
       echo '{"ResultCode":0,"ResultDesc":"Confirmation received successfully"}';
       }

       mysqli_close($con);

       fwrite($file,"\r\n");

echo $callback["ResultDesc"];
fwrite($file,$callback["ResultDesc"]);

fwrite($file,json_encode($callback));
fwrite($file,json_decode($postData, true));
fwrite($file,"\r\n");
fwrite($file,$conerr);
fwrite($file,$callback);
}


  
}
else{
$file = fopen("log.txt", "a+");
    // fwrite("\r\n");
fwrite($file, "no post data");
 
}
fwrite($file,"\n");
fwrite($file,".................................................");
   fwrite($file,"\n");
    fclose($file);


?>
