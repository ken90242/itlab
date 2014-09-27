<?php
require '../connect_database.php';
$u_id=$_GET["q"];
$query = "DELETE FROM `user` WHERE `user`.`id` = '".$u_id."' LIMIT 1";//CONVERT(`equipment`.`id` USING utf8)
mysql_query($query);
?>