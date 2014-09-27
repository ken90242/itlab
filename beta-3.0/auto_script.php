<?php
require 'connect_database.php';
///////////////////////////////////////////////////
$t_sql = "SELECT `sequence`,`u_id`,`e_id`,`time`,`deadline_time`,`return_time`,`e_addition_class` FROM `trade` WHERE `trade`.`t_status` = 'return'";

if($query_run =  mysql_query($t_sql)){
	if (mysql_num_rows($query_run) == NULL) {
		echo 'Search Nothing!';
	}
	else{
		while ($query_row = mysql_fetch_assoc($query_run)) {
			$t_sequence = $query_row[ 'sequence' ];
			$u_id = $query_row[ 'u_id' ];
			$e_id = $query_row[ 'e_id' ];
			$t_borrow_time = $query_row[ 'time' ];
			$t_deadline_time = $query_row[ 'deadline_time' ];
			$t_return_time = $query_row[ 'return_time' ];
			if(isset($query_row[ 'e_addition_note' ])) {
				$t_addition_note = $query_row[ 'e_addition_note' ];
			}else{
				$t_addition_note = "";
			}
			$t_class = $query_row[ 'e_addition_class' ];
			
			$u_sql = "SELECT `department` FROM `user` WHERE `id` = '".id_correct($u_id)."'";
			if($query_urun =  mysql_query($u_sql)){
				$query_urow = mysql_fetch_assoc($query_urun);
				$u_department = $query_urow[ 'department' ];
			}
			$e_sql = "SELECT `name`,`class` FROM `equipment` WHERE `id` = '$e_id'";
			if($query_erun = mysql_query($e_sql)){
				$query_erow = mysql_fetch_assoc($query_erun);
				$e_class = $query_erow[ 'class' ];
				$e_name = $query_erow[ 'name' ];
			}

			$insert_sql = "INSERT INTO `trade_analyze`(`t_sequence`,`u_department`,`u_id`,`e_id`,`e_class`,`e_name`,`t_borrow_time`,`t_borrow_week_day`,`t_borrow_month_block`,`t_borrow_time_block`,`t_deadline_time`,`t_return_time`,`t_return_week_day`,`t_return_month_block`,`t_return_time_block`,`t_addition_note`,`t_class`) 
				VALUES ('$t_sequence','$u_department','$u_id','$e_id','$e_class','$e_name','$t_borrow_time',DAYOFWEEK('$t_borrow_time'),DATE_FORMAT('$t_borrow_time','%m'),DATE_FORMAT('$t_borrow_time','%H'),'$t_deadline_time','$t_return_time',DAYOFWEEK('$t_return_time'),DATE_FORMAT('$t_return_time','%m'),DATE_FORMAT('$t_return_time','%H'),'$t_addition_note','$t_class')";

			if(mysql_query($insert_sql)){
				echo 'Insert t_sequence #'.$t_sequence.' success!<br>';	
			}
			else{
				echo 'Error! in Insert t_sequence #'.$t_sequence.'<br>';
				echo mysql_error();
			}
		}
	}
}

///////////////////////////////////////////////////

$de_sql_trade = "DELETE from `trade` WHERE `t_status` = 'return'";
if(mysql_query($de_sql_trade)){
	echo 'Update `trade` success!';	
}
else{
	echo mysql_error();
}
/////////////////////////////////////////////////////
$query = "SELECT * FROM `trade` WHERE `t_status` = 'borrowed' ORDER BY `sequence` DESC";
if($query_run =  mysql_query($query)){
	while ($query_row = mysql_fetch_assoc($query_run)) {
		$sequence = $query_row[ 'sequence' ];
		$u_id = $query_row[ 'u_id' ];
		$e_id = $query_row[ 'e_id' ];
		$delaytimes = $query_row[ 'delaytimes' ];
		$borrow_time = $query_row[ 'time' ];
		$deadline_time = $query_row[ 'deadline_time' ];
	
		if(deadline_gap($deadline_time,get_current_date())<0){
			sync_func($e_id,$u_id,$borrow_time,$sequence);
		}
	}
}
function sync_func($e_id,$u_id,$borrow_time,$trade_sequence){
	$insert_query = "INSERT INTO `test`.`index_faceboking` (`info_progress`,`e_id`,`u_id`,`borrow_time`,`trade_sequence`) 
		VALUES ('processed','$e_id','$u_id','$borrow_time','$trade_sequence')";
	$query_rpt_count = mysql_query("SELECT COUNT(1) FROM `index_faceboking` WHERE `trade_sequence` = '$trade_sequence'");

	if(mysql_result($query_rpt_count, 0)==0){
		mysql_query($insert_query);
	}					
}
function id_correct($id_search){ //unify the ID format and ID debug
	if(preg_match('/^(1)\d{8}$/',$id_search)){
		$id_search = $id_search;
	}
	elseif(preg_match('/^(00)\d{6}$/',$id_search)){
		$id_search = substr('0'.$id_search,0,9);
	}
	elseif(preg_match('/^(00)\d{7}$/',$id_search)){
		$id_search = substr('0'.$id_search,0,9);
	}
	elseif (preg_match('/^(1)\d{9}$/',$id_search)){
		$id_search = substr($id_search,0,9);
	}
	elseif (preg_match('/^(9)\d{7}$/',$id_search)){
		$id_search = '0'.$id_search;
	}
	elseif (preg_match('/^(9)\d{8}$/',$id_search)){
		$id_search = substr('0'.$id_search,0,9);
	}
	elseif(($id_search == '1152542')|| ($id_search == '01152542')){
		$id_search = '1152542';
	}
	else{
		echo "<SCRIPT Language=javascript>";
		echo "window.alert('NOT formal informat!(9xxxxxxx(x)/1xxxxxxxx(x))')";
		echo "</SCRIPT>";
		echo "<script language=\"javascript\">";
		echo "window.parent.window.location.href = \"./index.php\"";
		echo "</script>"; 
						
		exit;
	}
	return $id_search;
}
function deadline_gap($a,$b){ //calculate the time between two time spot
	$second = strtotime($a)-strtotime($b);
		return $second;
}
function get_current_date(){ //+8 is used to adjust server's time  to the correct time
	$datetime = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))) ; 
	return $datetime;
}	
$delete_query = "DELETE FROM `index_faceboking` WHERE `info_progress`='done' ";
mysql_query($delete_query);
?>