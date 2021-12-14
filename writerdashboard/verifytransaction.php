<?php
session_start();
include '../functions.php';
include '../connection.php';

$curl = curl_init();
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if(!$reference){
  die('No reference supplied');
}

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Bearer sk_test_c533e8875c7be3fc86dcf195fc32dd2f71131a58",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
    // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}

if('success' == $tranx->data->status){
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
  $comp_ID = substr($reference, 5);
  $query = "UPDATE competitions SET comp_status = 'ongoing' WHERE comp_ID = ?";
  $result =  $connection->prepare($query);
  $result->bind_param("i",$comp_ID);
  if ($result->execute()) {
      header("Location: mycompetitions.php?payment_success=true");
  }
  else{
      echo "Error in verifying transaction please refresh this page";
  }
}
else{
    echo "Error in verifying transaction please refresh this page";
}
?>