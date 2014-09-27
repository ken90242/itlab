<?php
	require './connect_database.php';
	$q=$_GET["q"];
	$query = "SELECT * FROM equipment WHERE `id`='$q'";
		if($query_run =  mysql_query($query)){
			if(mysql_num_rows($query_run) != NULL){
				while ($query_row = mysql_fetch_assoc($query_run)) { 
					$response =  $query_row[ 'status' ];
					echo $response;
			}
		}else{ 
			echo mysql_error();
		}
	}
?>