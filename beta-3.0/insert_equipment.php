<?php
	require 'connect.php';
	if ($_POST) {
		$insert_equip_id = $_POST["insert_equip_id"];
		$insert_equip_name = $_POST["insert_equip_name"];
		$insert_equip_class = $_POST["insert_equip_class"];
		//$insert_equip_status = $_POST["insert_equip_status"];
		$insert_query = "INSERT INTO  `test`.`equipment` (`id`,`name`,`class`,`status`,`current_owner`) VALUES ('$insert_equip_id','$insert_equip_name','$insert_equip_class','return',`itlab`)";
		
		if($query_run = mysql_query($insert_query)) {
			$query = "SELECT id , name , class , status FROM equipment WHERE `id`='$insert_equip_id'";
			$query_run = mysql_query($query);
			$query_row = mysql_fetch_assoc($query_run);
			echo 'insert success';
		}
		else{
			echo $insert_query;
			echo 'insert error!';
		}
	}
	else{
		echo 'errrrrr!';
	}
?>