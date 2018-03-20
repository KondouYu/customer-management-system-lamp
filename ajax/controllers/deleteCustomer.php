<?php
include('../libraries/connect.php');
$path = '../data/'.basename(__FILE__);

$id = $_POST['id'];

$nowy = $pdo->prepare("DELETE FROM klienci WHERE id=?");
$nowy->bindParam(1, $id);
$nowy->execute();

$nowy = $pdo->prepare("DELETE FROM windykacja WHERE id_klienta=?");
$nowy->bindParam(1, $id);
$nowy->execute();

$nowy = $pdo->prepare("DELETE FROM wpisy WHERE id_klienta=?");
$nowy->bindParam(1, $id);
$nowy->execute();
?>