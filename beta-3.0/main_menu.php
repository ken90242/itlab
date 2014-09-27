<?php session_start(); require 'connect_database.php';?>
<!-- Main menu contain MOST of information users can see-->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="refresh" content="301"; url="./main_menu.php"charset="UTF-8">
		<link href="css/index2.css" rel="stylesheet" type="text/css"><!-- x -->
		<link href="css/reset.css" rel="stylesheet" type="text/css"><!-- x -->
		<link href="css/laser.css" rel="stylesheet" type="text/css"><!-- x -->
		<style type="text/css">
		#sign_up{
			position:fixed;
			z-index:50;
			border:3px solid #243F57;
			background:#E8E8E8;
			width:600px;
			height:450px;
			margin-top:-250px;
			margin-left:-270px;
			top:50%;
			left:50%;
			text-align:center;
			font-family:"Trebuchet MS", verdana, arial,tahoma;
			font-size:10pt;
		}
		#haha{
			float:right;
		}
		#r1,#r2,#r3,#haha:hover{
			cursor:pointer;
		}
		#usrname,#astname{
			color:#3d74b8;
		}
		#lightbox-shadow {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: #000;
			opacity: 0.75;
			z-index: 40;
		}
		#txtraa{
				  
		}
	</style>
	</head>
	<body onload="document.getElementById('equipment_search_0').focus()">
	<?php
		$sql = 'SELECT `blacklisted` FROM `user` WHERE `user`.`id` = '.$_SESSION['id'];
		$blacklisted_array = mysql_fetch_row(mysql_query($sql)); 
		$_SESSION['blacklisted'] = $blacklisted_array[0];
		if($_SESSION['blacklisted'] =='y'){
			echo "<SCRIPT Language=javascript>";
			echo "window.alert('您目前被列入黑名單控管中!')";
			echo "</SCRIPT>";
		}
	?>
	<div class="container">
		<div class="row-fluid">
			<div id="sign_up" style="display:none;"  >
				<!-- final check form close button (at upper right corner of the form) -->
					<button id="haha" onclick="ray.notshow()">X</button>
					<br><br>
					<!-- show equipment ID which will be borrowed and display the bail  -->
					<label id="out"></label><label style="color: gray;">&nbsp;&nbsp;|&nbsp;&nbsp;</label><label id="money" style="color: #d57499;">處理中...請稍候</label><br><br>
					<!-- show equipment ID which will be returned or extend borrowing and display the bail(extend borrowing doesn't need bail)  -->
					<label id="back_c"></label>&nbsp;/&nbsp;<label id="back"></label>&nbsp;&nbsp;|&nbsp;&nbsp;<label id="money_back" style="color: #d57499;">處理中...請稍候</label><br><br>
					<!-- show equipment ID which was over the return deadline and display the penalty  -->
					<label id="out_deadline">處理中...請稍候</label><label style="color: gray;">&nbsp;&nbsp;|&nbsp;&nbsp;</label><label style="color: #d57499;" id="fine">處理中...請稍候</label><br>
					<hr style="border-color: black;">
					<!-- show the contract and [user,assistant]'s name -->
					<div id="txtraa" align="left">
					1.請確認器材使用人為借用或歸還本人身份 。<br>
					2.借用器材時押證件或學生證於數為平台，於歸還時清點無誤、點收人簽收，完成歸還程序後始返還證件或學生證。<br>
					3.如有器材損壞，除需扣除押金，並視情況需負責額外修復或損壞賠償之責任。<br>
					4.如未依規定時間內歸還者，將沒收押金。<br> 
					5.未遵守規定者除以上條款，將列入借用黑名單。<br> 
					6.被列為黑名單者，將停權一學期。</div>
					<hr>	
					<input id="r1" type="radio" name="i can read"><label>我同意以上條款並全權負起責任</label>
					<input id="r2" type="radio" name="i can read"><label>不同意</label><br><br>
					<input id="r3" type="checkbox">經手助理<label id='astname'></label>已確實辦理借用人<label id='usrname'><?php echo $_SESSION['name'];?></label>押證事務<br><br><hr>
					<button id="clk" onclick="ray.judge();">確認送出</button>
				</div>
				<!-- shadow around the final check form -->
				<div id="lightbox-shadow" style="display:none;width: 100%; height:100%" ></div>
			<div id="dashboard" style="float:left;width:700px">
				<div>
				<!-- show logged in user info and button used to go back to index(if no data ,go back to index.php) -->
					<?php
						if($_SESSION['id']==NULL){
							echo "<script language=\"javascript\">";
						 	echo "window.location.href = \"./index.php\"";
							echo "</script>"; 
						}
						echo '<input type="button" value="回首頁" id="form3to1" name="B4" onClick="window.location=\'index.php\'"><br><br>';
						echo '學號 : ' , $_SESSION['id'] , '<br>';
						echo '姓名 : ' , $_SESSION['name'] , '<br>';
						echo '系所 : ' , $_SESSION['department'] , '<br>';
						echo 'E-mail : ' , $_SESSION['email'] , '<br>';
						echo '電話 : ' , $_SESSION['phone'];
					?>
				</div>
				<hr>


				<!-- hidden menu(final check form) -->
			
				<div>
				<!-- form for searching equipment ID and sending it to equipment_id_judge_multi.php -->
					<form id="form3" action="equipment_id_judge_multi.php" method="POST" target="frame">
						<label></label>
						<!-- in order to clean the text of equipment_search_0 immediately to let user input next ID (function:cleanandclear)and 
							 have somewhere to store that equipment ID temporary, we set up equipment_search_1 as a hidden text to record that.-->
						<input id="equipment_search_0" style="ime-mode: disabled" type="text" placeholder="Scan ID" name="equipment_id_search_0" value="DVSNYXA1001">
						<input id="equipment_search_1" type="hidden" value="" name="equipment_id_search_1">
						<input id="submit3" type="submit" value=""   onclick="cleanandclear();">
						
					</form>
					<hr>
					<!-- area to show debug info -->
					<div id="myframe"></div>
					<div>
					<!-- to show info in main_menu_frame_src.php in case of user pressing F5 -->
						<iframe frameborder="0" id="frame" name="frame" width="700" height="600"  src="main_menu_frame_src.php"></iframe>
					</div>
				</div>
			</div>
			<!-- show user's historical record -->
			<div id="historyboard"  >
			<strong>歷史紀錄</strong><br><hr>
			<div style="float:left;">
				<?php
					// grab the data from database and list them by time series
					$u_id = $_SESSION['id'];
					$query = "SELECT * FROM trade WHERE `u_id`='$u_id' AND `parent` IS NULL ORDER BY `sequence` DESC";
					if($query_run =  mysql_query($query)){
						if (mysql_num_rows($query_run) == NULL) {
							echo 'Search Nothing!';
						}
						else{
							while ($query_row = mysql_fetch_assoc($query_run)) {
								$timee = $query_row[ 'time' ];
								$return_time = $query_row[ 'return_time' ];
								$dead_time = $query_row[ 'deadline_time' ];
								$e_id = $query_row[ 'e_id' ];
								$e_addition = $query_row[ 'e_addition' ];
								$e_addition_note = $query_row[ 'e_addition_note' ];
								$e_addition_class = $query_row[ 'e_addition_class' ];
								$query_equ = "SELECT * FROM equipment WHERE `id`='$e_id'";
								$query_tra = "SELECT * FROM trade WHERE `time`='$timee' AND `e_id`='$e_id'";
								/*To get equipment status(borrowed or return)*/
								if($query_run_equ =  mysql_query($query_equ)){
									$query_row = mysql_fetch_assoc($query_run_equ);
									$statuss = $query_row[ 'status' ];
									$e_name = $query_row[ 'name' ];
								}
								else{
									echo 'main_menu Error!- line 148';
								}

								/*Show trade data informations under different conditions*/
								if($query_run_tra =  mysql_query($query_tra)){
									$query_row = mysql_fetch_assoc($query_run_tra);
									$return_timee = $query_row[ 'return_time' ];
									$handlers = $query_row[ 'handler' ];
									$tra_status = $query_row[ 't_status' ];
									echo '借用時間: ' , $timee , '<br>';
									echo '借用器材名稱: ' , $e_name , '<br>';
									echo '借用器材編號: ' , $e_id , '<br>';
									echo '使用課程: ' , $e_addition_class , '<br>';
									echo '經辦助理: <font color="#3d74b8">' , $handlers , '</font><br>';
									/*Show whether equipment is return or borrowed*/
									if(($tra_status == 'borrowed') && ($return_timee == NULL)){
										echo '借用狀態: <font color="#d57499">尚未歸還<br></font>';
									}
									elseif (($tra_status == 'borrowed') && ($return_timee != NULL)){
										echo '借用狀態: 已歸還<br>';
									}
									elseif ($tra_status == 'return') {
										echo '借用狀態: 已歸還<br>';
									}
									else{
										echo 'main_menu.php error1.<br>';
									}

									/*Show trade data under different conditions*/
									if (($return_timee == NULL)&&(deadline_gap($dead_time,get_current_date()))<0){
										// echo get_current_date().'<br>';
										// echo deadline_gap($dead_time,get_current_date()).'<br>';
										echo '歸還期限: <font color="#d57499">',$dead_time,'</font><br>';
										echo '歸還時間: <font color="#d57499">尚未歸還</font><br>';
										echo '<font color="#d57499">已超過歸還期限.',over_deadline_time(get_current_date(),$dead_time),'</font>';
									}
									elseif(($return_timee == NULL)&&(deadline_gap($dead_time,$return_time)>=0)){
										echo '歸還期限: ',$dead_time,'<br>';
										echo '歸還時間: <font color="#d57499">尚未歸還</font><br>';
										echo '距離歸還期限: ',over_deadline_time($dead_time,get_current_date());
									}
									elseif (($return_timee != NULL)&&(deadline_gap($dead_time,$return_time)<0)){
										echo '歸還期限: <font color="#d57499">',$dead_time,'</font><br>';
										echo '歸還時間: <font color="#d57499">', $return_timee,'</font><br>';
										echo '<font color="#d57499">已超過歸還期限.',over_deadline_time($return_time,$dead_time),'</font>';
									}
									elseif(($return_timee != NULL)&&(deadline_gap($dead_time,$return_time)>=0)){
										echo '歸還期限: ',$dead_time , '<br>';
										echo '歸還時間: ', $return_timee;
									}
									else{
										echo 'main_menu.php error2.';
									}
									if($e_addition_note != NULL){
										echo '<br>其他備註: <font color="green">'.$e_addition_note.'</font>';
									}
									$sub_sql = 'SELECT * FROM  `trade` WHERE  `parent` =  "'.$e_id.'" ORDER BY `sequence` ASC';
									$sub_arr=array();
									if($sub_sql_run =  mysql_query($sub_sql)){
										if(mysql_num_rows($sub_sql_run) != NULL) {
											while ($sub_sql_row = mysql_fetch_assoc($sub_sql_run)) {
												array_push($sub_arr,$sub_sql_row["e_id"]);
											}
											
											echo "<br>借用子器材名稱如下:<br>";
											$i=1;
											foreach ($sub_arr as $key => $value) {
												$sub_e_sql = "SELECT * FROM equipment WHERE `id`='".$value."'";
												$sub_e_run = mysql_query($sub_e_sql);
												$sub_e_row = mysql_fetch_assoc($sub_e_run);
											    echo "<div><img id='img_".$sub_e_row["id"]."'' style=\"height:15px;vertical-align:middle;cursor:pointer\" src=\"img/pre_prolong.png\" onClick=\"expand_subobj('".$sub_e_row["id"]."')\"><label>".$i.".".$sub_e_row["name"]."</label></div>";
											    echo '<div id="'.$sub_e_row["id"].'" style="display:none">';
											    echo '&nbsp;&nbsp;&nbsp;&nbsp;- 子器材編號: ' , $sub_e_row["id"] , '<br>';
												echo '&nbsp;&nbsp;&nbsp;&nbsp;- 子器材類別: ' , $sub_e_row["class"] , '<br>';
											    echo '</div>';
											    $i++;
											}
										}else{
											if($e_addition != NULL){
												echo "<br>借用配件如下";
												echo $e_addition;
											}
											elseif($e_addition == NULL){
												echo '<br>未借用配件.';
											}
										}
									}
									else{
										echo 'main_menu.php error3.';
									}
									
									echo '<hr>';
								}
								else{
									echo mysql_error();
								}
							}
						}
					}
					else{
						echo mysql_error();
					}
				?>
			</div>
			</div>
		</div>
	</div>

	</body>
</html>
<?php
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 301)) {
		/*last request was more than 60 seconds ago*/
		session_unset();	 /*unset $_SESSION variable for the run-time*/
		session_destroy();   /*destroy session data in storage*/

		echo "<script language=\"javascript\">";
		echo "window.location.href = \"./index.php\"";
		echo "</script>";
	}
	$_SESSION['LAST_ACTIVITY'] = time();
	
	function over_deadline_time($a,$b){ //calculate overdue time and trun it into date format
		$second = strtotime($a)-strtotime($b);
		$day = floor($second/60/60/24);
		$hour = floor(($second/60/60)-($day*24));
		$minute = floor(($second/60)-($day*24*60)-($hour*60));
		$sec = floor(($second)-($day*24*60*60)-($hour*60*60)-($minute*60));
		return $day.'天'.$hour.'時'.$minute.'分'.$sec.'秒';
	}
	function deadline_gap($a,$b){ //calculate the time between two time spot
		$second = strtotime($a)-strtotime($b);
		return $second;
	}
	function get_current_date(){ //+8 is used to adjust server's time  to the correct time
		$datetime = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))) ; 
		return $datetime;
	}
?>

<script type="text/javascript">
	var ray={
		judge:function(){ //confirm if the user check the agree button indeed
			if((this.getid('r1').checked)&&(this.getid('r3').checked)){
				document.getElementById('sign_up').style.display='none';
				document.getElementById('lightbox-shadow').style.display='none';
				document.getElementById('frame').contentWindow.document.getElementById('childform').submit();
			}
			else if((!this.getid('r1').checked)||(!this.getid('r3').checked)){
				alert('請確實勾選同意條款以及押證確認!');
			}
			else{
				alert('unpredictable mistakes happen');
			}
		},
		notshow:function(){ //clear the agree button status, final check form and shadow
			this.getid('sign_up').style.display='none';
			this.getid('lightbox-shadow').style.display='none';
			this.getid('r1').checked="";
			this.getid('r2').checked="";
			this.getid('r3').checked="";
		},
		getid:function(id){
			return document.getElementById(id);
		}
	}
function expand_subobj(sub_div_id){
	if(document.getElementById(sub_div_id).style.display=='none'){
		document.getElementById('img_'+sub_div_id).src='img/prolong.png';
		document.getElementById(sub_div_id).style.display='block';
	}else{
		document.getElementById('img_'+sub_div_id).src='img/pre_prolong.png';
		document.getElementById(sub_div_id).style.display='none';
	}
	
}
function cleanandclear(){ // clean equipment_search_0, submit equipment_search_0's value to equipment_search_1, and call CKAddGust1(debug function)
	var equip_id = document.getElementById("equipment_search_0").value;
	document.getElementById("equipment_search_1").value = equip_id;
	document.getElementById("equipment_search_0").value = "";
	document.getElementById("equipment_search_0").focus();
	CKAddGust1('equipment_search_1','myframe','equipment_search_0');
}
function CKAddGust1(the_value_id,div_id,input_id){ //check if it's blank
	var valuee = document.getElementById(the_value_id).value;
	var div = document.getElementById(div_id);
	if(valuee == ""){
		document.getElementById(input_id).focus();
		div.textContent = "請填寫[器材id]欄位!";
		div.style.color = "red";
		event.returnValue = false;
	}
	else{
		div.textContent = "";
		var equ_id1 = document.getElementById("equipment_search_1").value;
		var subc_obj = document.getElementById("frame").contentDocument.getElementsByClassName("i_subcategory");
		var subc_obj_value="";
		
		if(subc_obj==null){
			nochongfu(valuee,equ_id1);
		}
		if (typeof subc_obj != "undefined") {
			for(var i =0 ;i<subc_obj.length;i++){
				par_id = document.getElementById("frame").contentDocument.getElementsByName("equ_id"+subc_obj[i].parentNode.id.split("divv")[1])[0].value
				subc_obj_value = subc_obj_value+"|"+par_id+"|"+subc_obj[i].value;
			}
			send_object(subc_obj_value,equ_id1,valuee);
			event.returnValue = false;
		}
		
	}
}
function nochongfu (the_value,the_equ_id) { //check if it's duplicate
	var search = 'equ_val'+the_value;
	var multi_search = 'equ_multi'+the_value;
	if(document.getElementById('frame').contentWindow.document.getElementById(search)){
		if(!document.getElementById('frame').contentWindow.document.getElementById(multi_search)){
			alert('已輸入過此euqipment_id'); //可以改成其他方式呈現錯誤
			event.returnValue = false;
			return;
		}
	}	
	document.getElementById("form3").submit();
}
function send_object(value,equ_id,valuee){
	var xmlhttp;
	if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		var arr = document.getElementById("frame").contentDocument.getElementsByClassName("blink");
		
		for(var i=0;i<arr.length;i++){
			arr[i].src = "img/wait.gif";
		}
		for(var i=arr.length-1;i>=0;i--){
			arr[i].className = "waiting";
		}
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			if(xmlhttp.responseText=='ERRor!'){
				nochongfu(valuee,equ_id);
				// var arr = document.getElementById("frame").contentDocument.getElementsByClassName("waiting");
				// for(var i=0;i<arr.length;i++){
				// 	arr[i].src = "img/question.png";
				// }
				// for(var i=arr.length-1;i>=0;i--){
				// 	arr[i].className = "blink";
				// }
			}else{
				if(document.getElementById('frame').contentWindow.document.getElementsByClassName("label_subid")){
					var label_subid_arr = document.getElementById('frame').contentWindow.document.getElementsByClassName("label_subid");
					for(var i=0;i<label_subid_arr.length;i++){
						console.log("label_subid_arr[i].innerText:["+i+"]"+label_subid_arr[i].innerText);
						console.log("the_value(input):"+equ_id);
						console.log("---------------------------");
						if(label_subid_arr[i].innerText.split("[")[0]==equ_id) {
							alert('子類別已輸入過此euqipment_id'); //可以改成其他方式呈現錯誤
							var arr = document.getElementById("frame").contentDocument.getElementsByClassName("waiting");
							for(var i=0;i<arr.length;i++){
								arr[i].src = "img/question.png";
							}
							for(var i=arr.length-1;i>=0;i--){
								arr[i].className = "blink";
							}
							event.returnValue = false;
							return;
						}
					}
				}
				var equ_arr = xmlhttp.responseText.split(";");
				var e_class = equ_arr[0];
				var e_id = equ_arr[1];
				var e_name = equ_arr[2];
				var text = e_id+"["+e_name+"]";
				var position=1;
				var sub_c_val="";
				var sub_c_arr = document.getElementById("frame").contentDocument.getElementsByClassName("i_subcategory");
				for(var i=0;i<sub_c_arr.length;i++){
					if(sub_c_arr[i].value.indexOf(e_class) > -1){
						sub_c_val = sub_c_arr[i].value.replace(e_class+";","")
						position = i;
						break;
					}
				}
				sub_c_arr[position].value = sub_c_val;
				sub_c_arr[position].parentNode.querySelectorAll('[name=lbl_'+e_class+']')[0].innerText=text;
				sub_c_arr[position].parentNode.querySelectorAll('[name=lbl_'+e_class+']')[0].style.color="blue";
				sub_c_arr[position].parentNode.querySelectorAll('[name=img_'+e_class+']')[0].className = "ok";
				sub_c_arr[position].parentNode.querySelectorAll('[name=img_'+e_class+']')[0].src = "img/ok.png";
				
				sub_c_arr[position].parentNode.querySelectorAll('[name=img_'+e_class+']')[0].parentNode.querySelectorAll('input[type=button')[0].disabled = false;

				var arr = document.getElementById("frame").contentDocument.getElementsByClassName("waiting");
				for(var i=0;i<arr.length;i++){
					arr[i].src = "img/question.png";
				}
				for(var i=arr.length-1;i>=0;i--){
					arr[i].className = "blink";
				}
				var new_object = document.createElement('div');
				var object = document.getElementById("frame").contentDocument.getElementById("childform").appendChild(new_object);
				object.innerHTML=equ_arr[3];
			}
			
		}
	}
	xmlhttp.open("GET","object_subajax.php?sub_c="+value+"&e_id="+equ_id,true);
	xmlhttp.send();
}
</script>

