<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"");
curl_setopt($ch, CURLOPT_POST, 1);

$user = "";
$pass = "";
$type = "";
$from = "";

$post = "user=$user&pass=$pass";
$post = str_replace(" ","%20",$post);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);

curl_close ($ch);
?>