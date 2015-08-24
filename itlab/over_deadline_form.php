<?php
require './connect_database.php';
$q = $_GET["q"]; //receive string sent equipment_id_judge_multi.php
$fine_array = preg_split("/[,]+/",$q); //turn string into array
$total_fine = 0;
$OrigiArray= array();
$str = '無';
//send the value(equipment ID) in fine_array to database to grab the data one by one
for($i=0;$i<count($fine_array);$i++){ 
	$e_id = $fine_array[$i];

	//query to grab equipment class in equipment table by equipment ID
	$quety_class = "SELECT * FROM equipment WHERE `id` = '".$e_id."' LIMIT 1"; 
	if($quety_class_run = mysql_query($quety_class)){
		$quety_class_row = mysql_fetch_assoc($quety_class_run);
		$e_class = $quety_class_row[ 'class' ];	
	}
	if($quety_class_row[ 'parent' ] == NULL){
		//query to grab deadline in trade table by equipment ID 
		$query = "SELECT * FROM trade WHERE `e_id` = '".$e_id."' ORDER BY `trade`.`sequence` DESC LIMIT 1";
		if($query_run = mysql_query($query)){
			$query_row = mysql_fetch_assoc($query_run);
			$deadline_time = $query_row[ 'deadline_time' ];	
		}

		//query to grab fine in setting table by equipment class
		$query_fine = "SELECT * FROM setting WHERE `e_class` = '".$e_class."' LIMIT 1";
		
		if($query_fine_run = mysql_query($query_fine)){
			$query_fine_row = mysql_fetch_assoc($query_fine_run);
			$e_class_fine = $query_fine_row[ 'fine' ];	
		}
		//judge whether it's overdue or not and calculate the total fine, and add it to OrigiArray(if it's overdue)
		$time_gap = strtotime($deadline_time) - strtotime(current_date());
		if($time_gap<0){
			$total_fine = $total_fine+$e_class_fine;
			array_push($OrigiArray,$e_id);
		}	
	}
}

//turn OrigiArray into String and connect them with ","
if(sizeof($OrigiArray)==1){
	$str = $OrigiArray[0];
}
elseif((sizeof($OrigiArray)>1)){
	$str = $OrigiArray[0];
	for($x=1;$x<sizeof($OrigiArray);$x++){
		$str = $str.','.$OrigiArray[$x];
	}
}else{
	$str = '無';
}
//connect String(all overdue equipment ID connecting with ",") and total fine with "-" and output them
echo $str.'*'.$total_fine;
function current_date(){
	$current_time = date ("Y-m-d H:i:s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y'))) ; 
	return $current_time;
	}
?>