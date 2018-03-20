<?php
include('../libraries/connect.php');
$path = '../data/'.basename(__FILE__);
 
$id_klienta = $_POST['id_klienta'];
$wpis = $_POST['wpis'];
$pracownik = $_POST['pracownik'];

$nowy = $pdo->prepare("INSERT INTO windykacja (id_klienta, data, wpis, pracownik) VALUES (?, ?, ?, ?)");
$nowy->bindParam(1, $id_klienta);
$nowy->bindParam(2, date("Y-m-d H:i:s"));
$nowy->bindParam(3, $wpis);
$nowy->bindParam(4, $pracownik);
$nowy->execute();
?>