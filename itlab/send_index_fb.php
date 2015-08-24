<?php
	require 'connect_database.php';
	@$i = $_GET["list_id"];
	@$e_id=$_GET["e_id"];
	@$u_id=$_GET["u_id"];
	@$borrow_time=$_GET["borrow_time"];
	@$delaytimes=$_GET["delaytimes"];
	@$info_ass=$_GET["info_ass"];
	@$info_detail=$_GET["info_detail"];
	@$info_time = datey();
	@$trade_sequence=$_GET["trade_sequence"];
	@$recordtimes=$_GET["recordtimes"];
	@$u_turn_time=$_GET["u_turn_time"];
	
	$update_qu = "UPDATE `test`.`index_faceboking`
		SET `info_ass` = '$info_ass', 
			`info_detail` = '$info_detail', 
			`info_time` = '$info_time',
			`u_turn_time` = '$u_turn_time'
		WHERE `trade_sequence`='$trade_sequence' LIMIT 1";
	$update_qu2 = "UPDATE `test`.`index_faceboking`
		SET `info_ass2` = '$info_ass', 
			`info_detail2` = '$info_detail', 
			`info_time2` = '$info_time',
			`u_turn_time2` = '$u_turn_time'
		WHERE `trade_sequence`='$trade_sequence' LIMIT 1";
	$update_qu3 = "UPDATE `test`.`index_faceboking`
		SET `info_ass3` = '$info_ass', 
			`info_detail3` = '$info_detail', 
			`info_time3` = '$info_time',
			`u_turn_time3` = '$u_turn_time'
		WHERE `trade_sequence`='$trade_sequence' LIMIT 1";
	if($recordtimes=='1'){
		record($update_qu,$i,$e_id,$u_id,$borrow_time,$delaytimes,$info_ass,$info_detail,$recordtimes,$trade_sequence,$u_turn_time);
	}else if($recordtimes=='2'){
		record($update_qu2,$i,$e_id,$u_id,$borrow_time,$delaytimes,$info_ass,$info_detail,$recordtimes,$trade_sequence,$u_turn_time);
	}else if($recordtimes=='3'){
		record($update_qu3,$i,$e_id,$u_id,$borrow_time,$delaytimes,$info_ass,$info_detail,$recordtimes,$trade_sequence,$u_turn_time);
	}
	



	function datey(){
		$now_time = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
		return $now_time;
	}
	function record($update_query,$i,$e_id,$u_id,$borrow_time,$delaytimes,$info_ass,$info_detail,$recordtimes,$trade_sequence,$u_turn_time){
		if(mysql_query($update_query)){
			$recordtimes = (int)$recordtimes+1;
			echo @datey().'<br>通知助理:'.@$info_ass.'<br>預計歸還時間:<br>'.@$u_turn_time.'<br>備註:'.@$info_detail.'--'.'<input class="submit_'.$i.'" type="button" value="提交" onclick="xml(\''.$i.'\',\''.$e_id.'\',\''.$u_id .'\',\''.$borrow_time.'\',\''.$delaytimes.'\',\''.$recordtimes.'\',\''.$trade_sequence.'\')">';
		}
	}
?>