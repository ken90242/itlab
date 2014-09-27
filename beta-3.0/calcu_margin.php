<?php

require './connect_database.php';
$q = $_GET["q"]; //receive string sent equipment_id_judge_multi.php
if($q == '無'){
	echo '0';
}else{
	$e_id_array = preg_split("/[,]+/",$q); //turn string into array
	$total_margin = 0;
	for($i=0;$i<count($e_id_array);$i++){ 
		$e_id = $e_id_array[$i];
		$quety_class = "SELECT * FROM equipment WHERE `id` = '".$e_id."' LIMIT 1"; 
		if($quety_class_run = mysql_query($quety_class)){
			$quety_class_row = mysql_fetch_assoc($quety_class_run);
			$e_class = $quety_class_row[ 'class' ];	
		}
		else{
			echo mysql_error();
		}

		//query to grab fine in setting table by equipment class
		$query_fine = "SELECT * FROM setting WHERE `e_class` = '".$e_class."' LIMIT 1";
		
		if($query_fine_run = mysql_query($query_fine)){
			$query_fine_row = mysql_fetch_assoc($query_fine_run);
			$e_class_margin = $query_fine_row[ 'margin' ];	
		}
		else{
			echo mysql_error();
		}
		$total_margin = $total_margin + $e_class_margin;
	}
	echo $total_margin;
}
?>