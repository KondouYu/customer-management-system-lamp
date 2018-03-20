<?php
$wiadomosc = $_POST['wiadomosc'];
$numer = $_POST['numer'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"");
curl_setopt($ch, CURLOPT_POST, 1);
		
$user = "";
$pass = "";
if(strlen($wiadomosc) > 160){
$type = "concat";		
} else {
$type = "sms";		
}

$from = "";

$post = "user=$user&pass=$pass&type=$type&number=$numer&from=$from&text=$wiadomosc";
$post = str_replace(" ","%20",$post);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  

$returnment = curl_exec($ch);

curl_close($ch);

$returnment = substr($returnment, 8, 3);

echo $returnment;

?>