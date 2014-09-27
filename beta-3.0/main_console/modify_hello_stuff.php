<?php
	require '../connect_database.php';
	session_start();
	$q=$_GET["q"];

	$NewString1 = preg_split("/[,]+/",$q);
	$id = $NewString1[0];
	$name = $NewString1[1];
	$class = $NewString1[2];
	$status = $NewString1[3];
	$current_owner = $NewString1[4];
	@$ori_id = $NewString1[5];

	$update_user_query = "UPDATE `test`.`equipment` SET `id` = '".$id."' , `name` =  '".$name."' , `class` =  '".$class."' , `status` = '".$status."' ,
	`current_owner` = '".$current_owner."' WHERE CONVERT(`equipment`.`id` USING utf8 )  = '".$ori_id."' LIMIT 1 ;";
	mysql_query($update_user_query);

	echo '<table><tr>';
	echo '<td style="border-style:solid;border-width:1px; width:200px;float:left">';
	echo $id;
	echo '</td>';
	echo '<td style="border-style:solid;border-width:1px; width:300px;float:left">';
	echo $name;
	echo '</td>';
	echo '<td style="border-style:solid;border-width:1px; width:100px;float:left">';
	echo $class;
	echo '</td>';
	echo '<td style="border-style:solid;border-width:1px; width:200px;float:left">';
	echo $status;
	echo '</td>';
	echo '<td style="border-style:solid;border-width:1px; width:100px;float:left">';
	echo $current_owner;
	echo '</td>';
	echo '<td><input type="button" value="修改" onclick="modify(\''.$id.'\',\''.$name.'\',\''.$class.'\',\''.$status.'\',\''.$current_owner.'\',\''.$_SESSION['total_class_option'].'\');"></td>';
	echo '<td><input type="button" value="刪除" onclick="removde(\''.$id.'\');"></td>';
	echo '</tr></table>';

?>