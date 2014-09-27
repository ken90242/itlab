<?php
	require 'connect_database.php';
	if ($_POST) { //receive equipment info from equipment_insert_1
		$insert_equip_id = $_POST["insert_equip_id"];
		$insert_equip_name = $_POST["insert_equip_name"];
		$insert_equip_class = $_POST["insert_equip_class"];
		$insert_query = "INSERT INTO  `test`.`equipment` (`id`,`name`,`class`,`status`,`current_owner`) 
		VALUES ('$insert_equip_id','$insert_equip_name','$insert_equip_class','return','itlab')";
		
		/*TO makesure insert equipment data into database when no blank space*/
		if($query_run = mysql_query($insert_query)&&($insert_equip_name!=NULL)&& 
		($insert_equip_class!=NULL)&&($insert_equip_id!=NULL)){ 

			$query = "SELECT * FROM equipment WHERE `id`='$insert_equip_id'";
			$query_run = mysql_query($query);	/*Insert equipment data into database*/
			$query_row = mysql_fetch_assoc($query_run);
			echo 'Insert equipment data Success!';
		}
		else{
			echo mysql_error(); //detect why CANNOT insert equipment correctly
		}
	}
	else{
		echo mysql_error(); //detect why index2.php sending POST request fail
	}
	
	
?>