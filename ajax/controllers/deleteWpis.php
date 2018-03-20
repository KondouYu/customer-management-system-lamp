<?php
include('../libraries/connect.php');
$path = '../data/'.basename(__FILE__);

$id = $_POST['id'];

$nowy = $pdo->prepare("DELETE FROM wpisy WHERE id=?");
$nowy->bindParam(1, $id);
$nowy->execute();
?>