<?php
require '../connect_database.php';
$e_id=$_GET["q"];
$query = "DELETE FROM `equipment` WHERE CONVERT(`equipment`.`id` USING utf8 )  = '".$e_id."' LIMIT 1";
mysql_query($query);
?>