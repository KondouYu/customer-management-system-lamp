<?php
//DB configuration Constants
 define('_HOST_NAME_', '');
 define('_USER_NAME_', '');
 define('_DB_PASSWORD', '');
 define('_DATABASE_NAME_', '');
 
 //PDO Database Connection
 try {
 $pdo = new PDO('mysql:host='._HOST_NAME_.';dbname='._DATABASE_NAME_, _USER_NAME_, _DB_PASSWORD, array(
 PDO::ATTR_PERSISTENT => false
 ));
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 $pdo->query("SET NAMES 'utf8'");
 } catch(PDOException $e) {
 echo 'ERROR: ' . $e->getMessage();
 }
?>