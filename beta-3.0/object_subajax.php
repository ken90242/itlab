<?php 
session_start(); 
require 'connect_database.php';

$sub_c = $_GET["sub_c"];
$sub_c_arr=explode("|",$sub_c);
$e_id = $_GET["e_id"];
$e_name='empty';
$e_class='empty';
$u_id = $_SESSION["id"];
$token=0;
$query = "SELECT * FROM  `equipment` WHERE `id` = '".$e_id."' Limit 0,1";
	if($query_run =  mysql_query($query)){
		while ($query_row = mysql_fetch_assoc($query_run)) {
			$e_class = $query_row["class"];
			$e_name = $query_row["name"];
			$e_stus = $query_row["status"];
		}
		for($i=2;$i<sizeof($sub_c_arr);$i=$i+2){
			if (strpos($sub_c_arr[$i],$e_class) !== false) {
				$_SESSION["times"] = $_SESSION["times"]+1;
				echo $e_class.';'.$e_id.';'.$e_name.';'.'<input type="hidden" name="equ_id'.$_SESSION["times"].'" value="'.$e_id.'"><input type="hidden" name="usr_id'.$_SESSION["times"].'" value="'.$u_id.'"><input type="hidden" name="equ_stats'.$_SESSION["times"].'" value="'.$e_stus.'"><input type="hidden" name="equ_cls'.$_SESSION["times"].'" value="'.$e_class.'"><input type="hidden" name="inpot'.$_SESSION["times"].'" value="物品名稱 : '.$e_name.'<br>物品類別 : '.$e_class.'"><input type="hidden" class="equ_add_clas" name="equ_add_clas'.$_SESSION["times"].'"><input type="hidden" class="sub_parent" name="sub_parent'.$_SESSION["times"].'" value="'.$sub_c_arr[$i-1].'">;divv'.$_SESSION["times"].';';
				$token=1;
			}
		}
		if($token==0){
			echo 'ERRor!';
		}

	}
	else{
		echo mysql_error();
	}

?>