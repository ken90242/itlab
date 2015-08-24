<?php
	session_start();
	require 'connect_database.php';

	for($z=1;$z<=$_SESSION['times'];$z++){
		@$u_id = @$_POST['usr_id'.$z];
		@$e_id = @$_POST['equ_id'.$z];
		@$e_class = @$_POST['equ_cls'.$z];
		@$e_status = @$_POST['equ_stats'.$z];
		@$tra_handler0 = @$_POST['tra_handler'];
		@$e_addition_class = @$_POST['equ_add_clas'.$z];
		@$bck_chs = @$_POST['bck_chs'.$z];
		@$e_addition_note = @$_POST['e_addition_note'.$z];
		@$over_check_day = @$_POST['over_check_day'.$z];
		@$sub_parent = @$_POST['sub_parent'.$z];
		
		if((64800-strtotime(datey()))<0) { /*修改限時:把這行程式碼的 > 改成 < */

			if ($e_status=='borrowed') {
				if($bck_chs=='just_return'){
					$query_tra = "SELECT * FROM `trade` WHERE `e_id`='$e_id' ORDER BY `sequence` DESC LIMIT 1";
					if($query_tra_run =  mysql_query($query_tra)){
						if(mysql_num_rows($query_tra_run) != NULL){
							while($query_tra_row = mysql_fetch_assoc($query_tra_run)){
								@$tra_handler1 = $query_tra_row[ 'handler' ] ;
							}
						}
						else{
							echo mysql_error();
						}
					}
					@$tra_handler1 = @$tra_handler1.' 歸還: '.$tra_handler0;
					if($_POST['inpot'.$z]!=NULL){
						$datetime = datey();
						$update_query = "UPDATE `test`.`equipment` SET `status` = 'return' WHERE `equipment`.`id` = '$e_id' LIMIT 1 ";
							
						if($query_run = mysql_query($update_query)) { /*TO update the trade/equipment data when return equipment*/
							$update_query = "UPDATE `test`.`equipment` SET `status` = 'return',`current_owner` = 'itlab',`addition` = '' WHERE `equipment`.`id` = '$e_id'";
							$update_trade_query = "UPDATE `test`.`trade` SET  `return_time` = '$datetime',`t_status` = 'return',`handler` = '$tra_handler1' WHERE (`trade`.`e_id` = '$e_id') AND (`trade`.`t_status` = 'borrowed')  ORDER BY sequence DESC  LIMIT 1";

							mysql_query($update_query);
							mysql_query($update_trade_query);

							$the_session = 'divv'.$z;
							$_SESSION[$the_session] = "";
						}
						else{
							echo mysql_error(); /*decect the reason why CANNOT return back equipment*/
						}
					}
				}
				elseif ($bck_chs=='continue_borrow') {
					$query_tra = "SELECT * FROM  `trade` WHERE `e_id`='$e_id' ORDER BY `sequence` DESC LIMIT 1";
					if($query_tra_run =  mysql_query($query_tra)){
						if(mysql_num_rows($query_tra_run) != NULL){
							while($query_tra_row = mysql_fetch_assoc($query_tra_run)){
								@$tra_handler1 = $query_tra_row[ 'handler' ] ;
							}
						}
						else{
							echo mysql_error();
						}
					}
					@$tra_handler1 = @$tra_handler1.' 續借: '.$tra_handler0;
					$query_class = "SELECT * FROM equipment WHERE `id`='$e_id'";
					$query = "SELECT * FROM trade WHERE `u_id`='$u_id' ORDER BY `sequence` DESC";

					if($query_run_c = mysql_query($query_class)){
						$query_row =  mysql_fetch_assoc($query_run_c);						
						if($query_run = mysql_query($query)) {
							$query_row =  mysql_fetch_assoc($query_run);
							$delay_times = $query_row[ 'delaytimes' ];
							$delay_time = $query_row[ 'deadline_time' ];								
					    /*TO update trade date that user can delay their deadline date for 2 days*/
							$sql = 'SELECT * FROM `setting` WHERE `setting`.`e_class` = \''.$e_class.'\'';
							$continue_borrow_interval='ori';
							if($query_run =  mysql_query($sql)){
								while($query_row = mysql_fetch_assoc($query_run)){
									$continue_borrow_interval = $query_row[ 'continue_deadline_gap' ];
								}
							}else{
								echo mysql_error();
							}
							$update_trade_query = "UPDATE `test`.`trade` SET  `deadline_time` = (`deadline_time` + INTERVAL ".$continue_borrow_interval." DAY ) 
							, `delaytimes` = '1' , `handler` = '$tra_handler1' WHERE (`trade`.`e_id` = '$e_id') AND (`trade`.`t_status` = 'borrowed') 
							ORDER BY sequence DESC  LIMIT 1";
							mysql_query($update_trade_query);
						    $the_session = 'divv'.$z;
							$_SESSION[$the_session] = "";						
						}
					}
					else{
						echo mysql_error(); /*decect the reason why CANNOT refreshing the deadline date*/
						echo $e_id;
					}
				}
			}
			elseif ($e_status=='return'){

				$query_tra = "SELECT * FROM  `trade` WHERE `e_id`='$e_id' ORDER BY `sequence` DESC LIMIT 1";
				@$tra_handler1 = '借用: '.$tra_handler0;
				if($_POST['inpot'.$z]!=NULL){
					$borrow_time = datey();
					$deadtime = deadline_datey($_SESSION['e_class'],'n');
					if(isset($over_check_day)){
						$deadtime = deadline_datey($_SESSION['e_class'],'y');
					}
					global $statuss;
					
					$insert_query = "INSERT INTO  `test`.`trade` (`u_id`,`e_id`,`time`,`deadline_time`,`handler`) VALUES ('$u_id','$e_id','$borrow_time','$deadtime','$tra_handler1')";
					if((isset($_POST['sub_parent'.$z]))&&(trim($_POST['sub_parent'.$z])!="") ){
						$insert_query = "INSERT INTO  `test`.`trade` (`u_id`,`e_id`,`time`,`deadline_time`,`handler`,`parent`) VALUES ('$u_id','$e_id','$borrow_time','$deadtime','$tra_handler1','$sub_parent')";
					}
					$read_query = "SELECT * FROM equipment WHERE `id`='$e_id'";
					global $addition;
					
					for($i=1;$i<=12;$i++){
						if ( ! isset( $_POST[$i])) {
						    $_POST[$i] = null;
						}
					}
					if(($_POST['1']=="<br>攝影機本體")){
						$addition = $_POST['1'];
					}
					elseif(($_POST['1']=="<br>電源線")){
						$addition = $_POST['1'];
					}
					if(($_POST['2']=="<br>攝影機保護套")){
						$addition = $addition.$_POST['2'];
					}
					elseif(($_POST['2']=="<br>滑鼠")){
						$addition = $addition.$_POST['2'];
					}
					if(($_POST['3']=="<br>充電插座及變電器")){
						$addition = $addition.$_POST['3'];
					}
					elseif(($_POST['3']=="<br>螢幕線")){
						$addition = $addition.$_POST['3'];
					}
					if(($_POST['4']=="<br>外接麥克風")){
						$addition = $addition.$_POST['4'];
					}
					elseif(($_POST['4']=="<br>音源線")){
						$addition = $addition.$_POST['4'];
					}
					if(($_POST['5']=="<br>麥克風與攝影機連接轉接線")){
						$addition = $addition.$_POST['5'];
					}
					elseif(($_POST['5']=="<br>網路線")){
						$addition = $addition.$_POST['5'];
					}
					if(!empty($_POST['6'])&&($_POST['6']=="<br>16GB SDHC記憶卡")){
						$addition = $addition.$_POST['6'];
					}
					if(!empty($_POST['7'])&&($_POST['7']=="<br>備用電池及膠套")){
						$addition = $addition.$_POST['7'];
					}
					if(!empty($_POST['8'])&&($_POST['8']=="<br>攜行袋")){
						$addition = $addition.$_POST['8'];
					}
					/*if(!empty($_POST['9'])&&($_POST['9']=="<br>腳架雲台")){
						$addition = $addition.$_POST['9'];
					}*/
					if(!empty($_POST['10'])){
						$addition = $addition.'備註: '.$_POST['10'];
					}
					if(!empty($_POST['11'])){
						$addition = $addition.'備註: '.$_POST['11'];
					}
					if(!empty($_POST['12'])){
						$e_addition_class = $_POST['12'];
					}

					$update_query = "UPDATE `test`.`equipment` SET `status` = 'borrowed',`current_owner` = '$u_id',`addition` = '$addition' 
						WHERE `equipment`.`id` = '$e_id'";
					$update_trade_query = "UPDATE `test`.`trade` SET `t_status` = 'borrowed' ,`e_addition` = '$addition',`e_addition_class` = '$e_addition_class' ,`e_addition_note` = '$e_addition_note' WHERE `trade`.`e_id` = '$e_id' ORDER BY sequence DESC LIMIT 1";

					if($query_run = mysql_query($insert_query)){
						if(mysql_query($update_query)){
							mysql_query($update_trade_query);
						}else{
							echo "<SCRIPT Language=javascript>";
							echo "window.alert('更新equipment table時出錯!(lend_return_multi - line 199)')";
							echo "</SCRIPT>";
						}
					}else{
						echo "<SCRIPT Language=javascript>";
						echo "window.alert('新增物品紀錄時出錯!(lend_return_multi - line 204)')";
						echo "</SCRIPT>";
					}
						
					$_SESSION['additionn'] = @$addition;
					$_SESSION['additionn_class'] = $e_addition_class;
					$_SESSION['borrow_time'] = $borrow_time;
					$the_session = 'divv'.$z;
					$_SESSION[$the_session] = "";
				}
			}
			// else{
			// 	global $error;
			// 	@$spec_item_func = @$_POST['bck_chs'.$z];
			// 	$query_spec = "SELECT * FROM  `equipment` WHERE `id`='$e_id' LIMIT 1";
				
			// 	if($query_spec_run =  mysql_query($query_spec)){
			// 		if(mysql_num_rows($query_spec_run) != NULL){
			// 			while($query_spec_row = mysql_fetch_assoc($query_spec_run)){
			// 				@$equ_status_counts = $query_spec_row[ 'status' ] ;
			// 			}
			// 		}
			// 		else{
			// 			echo mysql_error();
			// 		}
			// 	}

			// 	if($spec_item_func=='just_lend'){ //借用
			// 		@$equ_status_counts = $equ_status_counts - 1;
			// 		$borrow_time = datey();
			// 		$deadtime = deadline_datey($_SESSION['e_class'],'n');
			// 		if(isset($over_check_day)){
			// 			$deadtime = deadline_datey($_SESSION['e_class'],'y');
			// 		}
			// 		global $statuss;
			// 		$query_tra = "SELECT * FROM  `trade` WHERE `e_id`='$e_id' ORDER BY `sequence` DESC LIMIT 1";
			// 		@$tra_handler1 = '借用: '.$tra_handler0;
					
			// 		$insert_query = "INSERT INTO  `test`.`trade` (`u_id`,`e_id`,`time`,`deadline_time`,`handler`) VALUES ('$u_id','$e_id','$borrow_time','$deadtime','$tra_handler1')";

			// 		$update_query = "UPDATE `test`.`equipment` SET `status` = '$equ_status_counts' WHERE `equipment`.`id` = '$e_id'";

			// 		$update_trade_query = "UPDATE `test`.`trade` SET `t_status` = 'borrowed' ,`e_addition_class` = '$e_addition_class',`e_addition_note` = '$e_addition_note' WHERE `trade`.`e_id` = '$e_id' ORDER BY sequence DESC LIMIT 1";

			// 		if($query_run = mysql_query($insert_query)){
			// 			if(mysql_query($update_query)){
			// 				mysql_query($update_trade_query);
			// 			}else{
			// 				echo "<SCRIPT Language=javascript>";
			// 				echo "window.alert('更新equipment table時出錯!(lend_return_multi - line 199)')";
			// 				echo "</SCRIPT>";
			// 			}
			// 		}else{
			// 			echo "<SCRIPT Language=javascript>";
			// 			echo "window.alert('新增物品紀錄時出錯!(lend_return_multi - line 204)')";
			// 			echo "</SCRIPT>";
			// 		}

			// 		// $_SESSION['additionn'] = $addition;
			// 		$_SESSION['additionn_class'] = $e_addition_class;
			// 		$_SESSION['borrow_time'] = $borrow_time;

			// 	} 
			// 	elseif($spec_item_func=='just_return') { //歸還
			// 		$query_tra = "SELECT * FROM `trade` WHERE (`e_id`='$e_id') AND (`trade`.`u_id` = '$u_id') AND (`trade`.`t_status` = 'borrowed') ORDER BY `sequence` ASC LIMIT 1";
			// 		if($query_tra_run =  mysql_query($query_tra)){
			// 			if(mysql_num_rows($query_tra_run) != NULL){
			// 				while($query_tra_row = mysql_fetch_assoc($query_tra_run)){
			// 					@$tra_handler1 = $query_tra_row[ 'handler' ] ;
			// 				}
			// 			}
			// 			else{
			// 				echo "<SCRIPT Language=javascript>";
			// 				echo "window.alert('歸還執行失敗(目前無可歸還之項目)!')";
			// 				echo "</SCRIPT>";
			// 				$error = '1';
			// 			}
			// 		}

			// 		@$tra_handler1 = @$tra_handler1.' 歸還: '.$tra_handler0;

			// 		if($_POST['inpot'.$z]!=NULL){
			// 			$datetime = datey();
			// 			$update_query = "UPDATE `test`.`equipment` SET `status` = 'return' WHERE `equipment`.`id` = '$e_id' LIMIT 1 ";
						
			// 			@$equ_status_counts = $equ_status_counts + 1;

			// 			if($query_run = mysql_query($update_query)) { /*TO update the trade/equipment data when return equipment*/
			// 				$update_query = "UPDATE `test`.`equipment` SET `status` = '$equ_status_counts',`addition` = '' WHERE `equipment`.`id` = '$e_id'";
			// 				$update_trade_query = "UPDATE `test`.`trade` SET  `return_time` = '$datetime',`t_status` = 'return',`handler` = '$tra_handler1' WHERE (`trade`.`e_id` = '$e_id') AND (`trade`.`t_status` = 'borrowed') AND (`trade`.`u_id` = '$u_id')  ORDER BY sequence ASC LIMIT 1";

			// 				mysql_query($update_query);
			// 				mysql_query($update_trade_query);

			// 				$the_session = 'divv'.$z;
			// 				$_SESSION[$the_session] = "";
			// 			}
			// 			else{
			// 				echo mysql_error(); /*decect the reason why CANNOT return back equipment*/
			// 			}
			// 		}
			// 	}
			// 	elseif($spec_item_func=='continue_borrow') { //續借
			// 		$query_tra = "SELECT * FROM `trade` WHERE (`e_id`='$e_id') AND (`trade`.`u_id` = '$u_id') AND (`trade`.`t_status` = 'borrowed') AND (`trade`.`delaytimes` = '0') ORDER BY `sequence` ASC LIMIT 1";
			// 		if($query_tra_run =  mysql_query($query_tra)){
			// 			if(mysql_num_rows($query_tra_run) != NULL){
			// 				while($query_tra_row = mysql_fetch_assoc($query_tra_run)){
			// 					@$tra_handler1 = $query_tra_row[ 'handler' ] ;
			// 				}
			// 			}
			// 			else{
			// 				echo mysql_error();
			// 				echo "<SCRIPT Language=javascript>";
			// 				echo "window.alert('續借執行失敗(目前無可續借之項目)!')";
			// 				echo "</SCRIPT>";
			// 				$error = '1';
			// 			}
			// 		}
			// 		@$tra_handler1 = @$tra_handler1.' 續借: '.$tra_handler0;
			// 		$query_class = "SELECT * FROM equipment WHERE `id`='$e_id'";
			// 		$query = "SELECT * FROM trade WHERE (`e_id`='$e_id') AND (`trade`.`u_id` = '$u_id') AND (`trade`.`t_status` = 'borrowed') ORDER BY `sequence` ASC LIMIT 1";

			// 		if($query_run_c = mysql_query($query_class)){
			// 			$query_row =  mysql_fetch_assoc($query_run_c);						
			// 			if($query_run = mysql_query($query)) {
			// 				$query_row =  mysql_fetch_assoc($query_run);
			// 				$delay_times = $query_row[ 'delaytimes' ];
			// 				$delay_time = $query_row[ 'deadline_time' ];								
			// 		    /*TO update trade date that user can delay their deadline date for 2 days*/
			// 				$sql = 'SELECT * FROM `setting` WHERE `setting`.`e_class` = \''.$e_class.'\'';
			// 				$continue_borrow_interval='ori';
			// 				if($query_run =  mysql_query($sql)){
			// 					while($query_row = mysql_fetch_assoc($query_run)){
			// 						$continue_borrow_interval = $query_row[ 'continue_deadline_gap' ];
			// 					}
			// 				}else{
			// 					echo mysql_error();
			// 				}
			// 				$update_trade_query = "UPDATE `test`.`trade` SET  `deadline_time` = (`deadline_time` + INTERVAL ".$continue_borrow_interval." DAY ) 
			// 				, `delaytimes` = '1' , `handler` = '$tra_handler1' WHERE (`e_id`='$e_id') AND (`trade`.`u_id` = '$u_id') AND (`trade`.`t_status` = 'borrowed') AND (`trade`.`delaytimes` = '0') ORDER BY `sequence` ASC LIMIT 1";
							
			// 				mysql_query($update_trade_query);
			// 			    $the_session = 'divv'.$z;
			// 				$_SESSION[$the_session] = "";						
			// 			}
			// 		}
			// 		else{
			// 			echo mysql_error(); /*decect the reason why CANNOT refreshing the deadline date*/
			// 			echo $e_id;
			// 		}
			// 	}
				
			// 	$the_session = 'divv'.$z;
			// 	$_SESSION[$the_session] = "";
			// }
			
			// if(($z==$_SESSION['times'])&&($error!='1')){
			// 	echo "<SCRIPT Language=javascript>";
			// 	echo "window.alert('序列執行成功!')";
			// 	echo "</SCRIPT>";
			// 	echo "<script language=\"javascript\">";
			// 	echo "window.parent.window.location.href = \"./main_menu.php\"";
			// 	echo "</script>"; 
			// }
			if(($z==$_SESSION['times'])){
				echo "<SCRIPT Language=javascript>";
				echo "window.alert('序列執行成功!')";
				echo "</SCRIPT>";
				echo "<script language=\"javascript\">";
				echo "window.parent.window.location.href = \"./main_menu.php\"";
				echo "</script>"; 
			}
		}
		elseif(deadline_gap(deadline_datey('ot','n'),datey())<0){
			$the_session = 'divv'.$z;
			$_SESSION[$the_session] = "";
			if($z==$_SESSION['times']){
				echo "<SCRIPT Language=javascript>";
				echo "window.alert('請於一至五下午六點前借用,謝謝.')";
				echo "</SCRIPT>";
				echo "<script language=\"javascript\">";
				echo "window.parent.window.location.href = \"./main_menu.php\"";
			    echo "</script>"; 
			}
		}
	}

	function datey(){
		$borrow_time = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
		return $borrow_time;
	}
	function deadline_datey($e_class,$check_overday){
		$query_set = "SELECT * FROM `setting` WHERE `setting`.`e_class` = '".$e_class."'";
		if($query_set_run =  mysql_query($query_set)){
			if(mysql_num_rows($query_set_run) != NULL){
				while($query_set_row = mysql_fetch_assoc($query_set_run)){
					@$set_deadline_gap = $query_set_row[ 'deadline_gap' ] ;
					@$enable_overday = $query_set_row[ 'enable_overday' ] ;
				}
			}
			else{
				echo mysql_error();
			}
		}
		$deadline_time = date ("Y-m-d H:i:s" , mktime('18','0','0', date('m'), date('d')+$set_deadline_gap, date('Y')));
		if($check_overday=='y'){
			$deadline_time = date ("Y-m-d H:i:s" , mktime('12','0','0', date('m'), date('d')+$set_deadline_gap+1, date('Y')));
		}
		return $deadline_time;
	}
	function deadline_gap($a,$b){
		$second = strtotime($a)-strtotime($b);
		return $second;
	}
?>