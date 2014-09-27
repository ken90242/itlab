<?php
require '../connect_database.php';
$q=$_GET["q"];

$NewString2 = preg_split("/[,]+/",$q);
$id = $NewString2[0];
$blackornot = $NewString2[1];
if($blackornot=='y'){
$update_blacklist_query = "UPDATE `test`.`user` SET `blacklisted` = 'y' WHERE `user`.`id` = '".$id."' LIMIT 1 ;";
mysql_query($update_blacklist_query);
}else if($blackornot=='n'){
$update_blacklist_query = "UPDATE `test`.`user` SET `blacklisted` = 'n' WHERE `user`.`id` = '".$id."' LIMIT 1 ;";
mysql_query($update_blacklist_query);
}
?>