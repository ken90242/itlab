<?php
	session_start();
	session_destroy();	
	header('Content-type: text/html;charset=utf-8');
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="assests/css/index.css" rel="stylesheet" type="text/css">
	<link href="assests/css/reset.css" rel="stylesheet" type="text/css">
	<link href="assests/css/laser.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="lib/jquery/jquery-ui.css">
	<link rel="stylesheet" href="lib/jquery/jquery.datetimepicker.css">
	<script src="lib/jquery/jquery.js"></script>
	<script type="text/javascript" src="lib/iscroll.js"></script>
  	<script src="lib/jquery/jquery-ui.js"></script>
  	<script src="lib/jquery/jquery.datetimepicker.js"></script>
  	<script src="assests/scripts/main.js"></script>
  	<script src="assests/scripts/tool.js"></script>
</head>
<body onload="document.getElementById('id_search').focus();">
<?php
	require 'connect_database.php';
	$result_count = 0;
?>
<br>		
<div id="notification" style="margin-top: 10%;">
	<input id="doraemon" type="hidden" value="invisible">


	<div id="nav">
		<div id="prev" onclick="myScroll.scrollToPage(&#39;prev&#39;, 0);return false">← prev</div>
		<div style="display:inline;margin:0px auto;"><span id="current_page"></span></div>
		<div id="next" onclick="myScroll.scrollToPage(&#39;next&#39;, 0);return false">next →</div>
	</div>
	<div id="wrapper" style="overflow: hidden;">
		<div id="scroller" style="transition: 0ms; -webkit-transition: 0ms; transform-origin: 0px 0px 0px; position: absolute; top: 0px; left: 0px;">
			<ul id="thelist">
				<?php
					$i = 0;
					sync_correct();
					$query_rps = "SELECT * FROM `index_faceboking` WHERE `info_progress`='processed' ORDER BY `sequence` ASC";
					if($query_rps_run =  mysql_query($query_rps)){						
						while ($query_rps_row = mysql_fetch_assoc($query_rps_run)) {
							@$borrow_time = $query_rps_row[ 'borrow_time' ];
							@$trade_sequence = $query_rps_row[ 'trade_sequence' ];
							@$u_id = $query_rps_row[ 'u_id' ];
							@$e_id = $query_rps_row[ 'e_id' ];
							@$info_ass = $query_rps_row[ 'info_ass' ];
							@$info_ass2 = $query_rps_row[ 'info_ass2' ];
							@$info_ass3 = $query_rps_row[ 'info_ass3' ];
							@$info_detail = $query_rps_row[ 'info_detail' ];
							@$info_detail2 = $query_rps_row[ 'info_detail2' ];
							@$info_detail3 = $query_rps_row[ 'info_detail3' ];
							@$info_time = $query_rps_row[ 'info_time' ];
							@$info_time2 = $query_rps_row[ 'info_time2' ];
							@$info_time3 = $query_rps_row[ 'info_time3' ];
							@$u_turn_time = $query_rps_row[ 'u_turn_time' ];
							@$u_turn_time2 = $query_rps_row[ 'u_turn_time2' ];
							@$u_turn_time3 = $query_rps_row[ 'u_turn_time3' ];


							$query_uinfo = "SELECT * FROM `user` WHERE `id` = '".id_correct($u_id)."'";
								if($query_urun =  mysql_query($query_uinfo)){
									$query_urow = mysql_fetch_assoc($query_urun);
									$u_name = $query_urow[ 'name' ];
									$u_email = $query_urow[ 'email' ];
									$u_phone = $query_urow[ 'phone' ];
								}
							$query_einfo = "SELECT * FROM `equipment` WHERE `id` = '".$e_id."'";
								if($query_erun =  mysql_query($query_einfo)){
									$query_erow = mysql_fetch_assoc($query_erun);
									$e_name = $query_erow[ 'name' ];
								}
							$query_tinfo = "SELECT * FROM `trade` WHERE `sequence` = '$trade_sequence'";
								if($query_trun =  mysql_query($query_tinfo)){
									$query_trow = mysql_fetch_assoc($query_trun);
									$deadline_time = $query_trow[ 'deadline_time' ];
									$delaytimes = $query_trow[ 'delaytimes' ];
								}
							if(@$info_ass3){
								@$xmlfunction = "alert('已通知三次!')";
							}elseif(@$info_ass2) {
								@$xmlfunction = '"xml(\''.$i.'\',\''.$e_id.'\',\''.$u_id .'\',\''.$borrow_time.'\',\''.$delaytimes.'\',\'3\',\''.$trade_sequence.'\')"';
							}elseif(@$info_ass){
								@$xmlfunction = '"xml(\''.$i.'\',\''.$e_id.'\',\''.$u_id .'\',\''.$borrow_time.'\',\''.$delaytimes.'\',\'2\',\''.$trade_sequence.'\')"';
							}else{
								@$xmlfunction = '"xml(\''.$i.'\',\''.$e_id.'\',\''.$u_id .'\',\''.$borrow_time.'\',\''.$delaytimes.'\',\'1\',\''.$trade_sequence.'\')"';
							}	

							echo '<li id="list_'.$i.'" style="font-size:6px;">';
							echo '<form name="fb_form" method="POST">';
							echo '<input type="checkbox" onclick="gray('.$i.');">';
							echo '<input id="font_color_'.$i.'" type="hidden" value="gray"><br>';
							echo '<hr>';
							echo '借用物品名稱:'.$e_name.'<br>';
							echo '借用時間:'.$borrow_time.'<br>';
							echo '歸還期限:'.$deadline_time.'<br>';
							echo '續借次數:'.$delaytimes.'<br>';
							echo '<hr>';
							echo '借用人資訊<hr>';
							echo '學號:'.$u_id .'<br>';
							echo '姓名:'.$u_name .'<br>';
							echo '聯絡方式:<br><<font color="blue">EMAIL</font>>'.$u_email.'<br><<font color="blue">PHONE</font>>'.$u_phone.'<br>';
							echo '<hr>';
							echo '<label class="submit_'.$i.'" style="display:none;">通知助理:</label>'.'<input id="list_'.$i.'_a" class="submit_'.$i.'" type="text" style="display:none;" onclick="this.focus()">'.'<label class="submit_'.$i.'" style="display:none;"><br></label>';
							echo '<label class="submit_'.$i.'" style="display:none;">借用人預計歸還時間:</label>'.'<input id="list_'.$i.'_u" class="submit_'.$i.' datepick" type="text" style="display:none;" onclick="this.focus()">'.'<label class="submit_'.$i.'" style="display:none;"><br></label>';
							echo '<label class="submit_'.$i.'" style="display:none;">其他事項:</label>'.'<input id="list_'.$i.'_t" class="submit_'.$i.'" type="text" style="display:none;" onclick="this.focus()">'.'<label class="submit_'.$i.'" style="display:none;"><br></label>';
							echo '<div id="button_'.$i.'"><input class="submit_'.$i.'" type="button" value="提交" onclick='.@$xmlfunction.' style="display:none;"></div>';
							echo '<div id="inform'.$i.'_a" style="">'.@$info_time.'<br>通知助理:'.@$info_ass.'<br>預計歸還時間:<br>'.@$u_turn_time.'<br>備註:'.@$info_detail.'</div>';
							echo '<div id="inform'.$i.'_b" style="">'.@$info_time2.'<br>通知助理:'.@$info_ass2.'<br>預計歸還時間:<br>'.@$u_turn_time2.'<br>備註:'.@$info_detail2.'</div>';
							echo '<div id="inform'.$i.'_c" style="">'.@$info_time3.'<br>通知助理:'.@$info_ass3.'<br>預計歸還時間:<br>'.@$u_turn_time3.'<br>備註:'.@$info_detail3.'</div>';
							echo '</form></li>';
							$i++;
							$result_count++;
						}
					}
				?>
			</ul>
		</div>
	</div>
</div>
<?php
	function get_current_date(){ //+8 is used to adjust server's time  to the correct time
		$datetime = date ("Y-m-d H:i:s" , mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y'))) ; 
		return $datetime;
	}	
	function sync_correct(){
		$init = "SELECT * FROM `trade_analyze`";
		if($init_run =  mysql_query($init)){
			while ($init_row = mysql_fetch_assoc($init_run)) {
				$trade_sequence = $init_row['t_sequence'];
				$query_rpt_count = mysql_query("SELECT COUNT(1) FROM `index_faceboking` WHERE `trade_sequence` = '$trade_sequence'");
				if(mysql_result($query_rpt_count, 0)>0){
					mysql_query("UPDATE `test`.`index_faceboking` SET `info_progress` = 'done' WHERE `trade_sequence`='$trade_sequence' LIMIT 1");
				}
			}
		}
			
		$init = "SELECT * FROM `trade` where `t_status`='return'";
		if($init_run =  mysql_query($init)){
			while ($init_row = mysql_fetch_assoc($init_run)) {
				$trade_sequence = $init_row['sequence'];
				$query_rpt_count = mysql_query("SELECT COUNT(1) FROM `index_faceboking` WHERE `trade_sequence` = '$trade_sequence'");
				if(mysql_result($query_rpt_count, 0)>0){
					mysql_query("UPDATE `test`.`index_faceboking` SET `info_progress` = 'done' WHERE `trade_sequence`='$trade_sequence' LIMIT 1");
				}
			}
		}
	}
	function id_correct($id_search){ //unify the ID format and ID debug
		if(preg_match('/^(1)\d{8}$/',$id_search)){
		    $id_search = $id_search;
		}
		elseif(preg_match('/^(00)\d{7}$/',$id_search)){
			$id_search = $id_search = $id_search;;
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
			echo "window.alert('".$id_search."不符合標準化篩選規則!(error-0xe01a000f)')";
			echo "</SCRIPT>";
			exit;
		}
		return $id_search;
	}
?>
<div id="changeside">
	<!-- form to submit ID to id_judge.php-->
	<span id="span_noti"><?php echo $result_count;?></span>
	<form id="form" name="id_form" action="id_judge.php" method="POST" target="tonyy" style="margin-bottom: 0px;" autocomplete="off">
		<img id="laser" src="assests/resource/img/laser.png"/>
		<input id="id_search" style="ime-mode: disabled" type="text" name="id_search" placeholder="Scan ID" value="100306082"><br>
		<div class="submit"><input type="submit" value="" onclick="CKAddGust2('id_search','errors','id_search');" id="submit"><span class="ping1"></span><span class="ping2"></span><span class="ping3"></span></div>
	</form>
	<input id="snowman" type="button" placeholder="" onClick="window.location='main_console/index.php'">
	<!-- show the ID debug info -->
	<div id="errors"></div>
	<div>
	  <div id="bar"></div><!-- xprogress  -->
	</div>			
</div>
<iframe name="tonyy" style="display:none"></iframe>
<img src="assests/resource/img/gemini22.png"  style="display:block; margin:auto; clear:both;"  height="125" width="140" >
	
	
<script type="text/javascript">
$(submit).on('click',function(){
	var u_id = $('#id_search').val();
	var opt ={
		url : '../itlab_api/user/' + u_id,
		method : 'get',
		dataType : 'json'
	}

	$.ajax(opt).then(function(user){
		window.setCookie("u_id", user.id, 1);
		window.to('main_menu');
	});

})


function CKAddGust2(the_value_id,div_id,the_input_id){		
	var valuee = document.getElementById(the_value_id).value;
	var div = document.getElementById(div_id);
	if(valuee == ""){
		document.getElementById(the_input_id).focus();
		div.textContent = "請填寫[查詢id]欄位!";
		div.style.color = "red";
		event.returnValue = false;
	}
	else if((valuee == '1152542')|| (valuee == '01152542')){
		valuee = '1152542';
		event.returnValue = true;
	}
	else if(((document.id_form.id_search.value.length>10)||(document.getElementById(the_input_id).value.length<8))&&
		(isNaN(document.id_form.id_search.value)==true)){
		div.textContent = "請輸入1或9開頭的9-10位數字!";
		div.style.color = "red";
		event.returnValue = false;
		document.getElementById(the_input_id).value = "";
	}
	else if((document.id_form.id_search.value.length>10)||(document.getElementById(the_input_id).value.length<8)){
		document.getElementById(the_input_id).focus();
		div.textContent = "請輸入9-10位字元!";
		div.style.color = "red";
		event.returnValue = false;
		document.getElementById(the_input_id).value = "";
	}
	else if(isNaN(document.id_form.id_search.value)==true){
		document.getElementById(the_input_id).focus();
		div.textContent = "請輸入數字!";
		div.style.color = "red";
		event.returnValue = false;
		document.getElementById(the_input_id).value = "";
	}

	else{
		event.returnValue = true;	
	}
	
}
</script>
<script type="text/javascript">
var myScroll;

function loaded() {
	myScroll = new iScroll('wrapper', {
		mouseWheel: true,
		scrollbars: true,
		snap: true,
		momentum: false,
		hScrollbar: false,
		freeScroll: true,
		onScrollEnd: function () {
			this.pagesX.length = <?php echo $result_count;?>;
			$('#current_page').text(this.currPageX+1+'/'+<?php echo $result_count;?>);
		}
	 });
	// console.dir(myScroll.options);
}

document.addEventListener('DOMContentLoaded', loaded, false);
</script>
<script type="text/javascript">
$(document).ready(function(){ 
	$('#current_page').text('1/'+<?php echo $result_count;?>);
	$("#id_search").keyup(function(){ //字元數進度條模組
	var box=$(this).val();
	var main = box.length *100;
	var value= (main / 9);

	if(box.length < 10){
		$("#bar").animate({"width": value+"%",}, 1);
	 	if(id_search.value.match(/^00/)){if(box.length==8||box.length==9){$("#bar").animate({"width": 100+"%",}, 1);return false;}}
	  	if(id_search.value.match(/^9/)){if(box.length==8||box.length==9){$("#bar").animate({"width": 100+"%",}, 1);return false;}}
		$("#bar").animate({"width": value+"%",}, 1);
  	}
  	else if (box.length = 10){
  		$("#bar").animate({"width": 100+"%",}, 1);
  	}
  	else{
  		alert(' Full ');
  	}
  	return false;
  	});

	$(function(){
		var x=0;
		$("#span_noti").click(function(){
			if(x%2==0){
				$("#notification").css("visibility","visible");
			   	$("#span_noti").css({ opacity: 1.0 });
			   	x++;
			}
			else {
				$("#notification").css("visibility","hidden");
				$("#span_noti").css({ opacity: 0.5 });
				x++;
			}		 
		});			
	});
	
  	$(function(){
		var x=0;
		$("#submit").click(function(){
			if(x%2==0){
			  	$("#laser").addClass("slideOutUp");
			   	$("#laser").fadeIn("200").fadeOut("5000");
			   	$("#laser").removeClass("slideOutUp2");
			   	x++;
			}
			else {
				$("#laser").removeClass("slideOutUp");
				$("#laser").fadeIn("200").fadeOut("5000");
				$("#laser").addClass("slideOutUp2");
				x++;
			}		 
		});			
	});
	
	$(function(){
		var x=0;
		$("#submit2").click(function(){
		 	if(x%2==0){
			   $("#laser2").addClass("slideOutUp");
			   $("#laser2").fadeIn("200").fadeOut("5000");
			   $("#laser2").removeClass("slideOutUp2");
			   x++;
		 	}
			else {
				$("#laser2").removeClass("slideOutUp");
			   	$("#laser2").fadeIn("200").fadeOut("5000");
			   	$("#laser2").addClass("slideOutUp2");
			   	x++;
			}		 
		});			
	});
});
</script>
<script type="text/javascript">

	$(function() {
        $( ".datepick" ).datetimepicker({
        	formatDate:'Y-m-d',
        });
    });
	function gray(id){
		var font_color_id = 'font_color_'+id;
		var submit_id = 'submit_'+id;
		var submit_class = document.getElementsByClassName(submit_id);
		id = 'list_'+id;
		if((!document.getElementById(font_color_id).value)||(document.getElementById(font_color_id).value!='gray')){
			document.getElementById(font_color_id).value='gray';
			var i = submit_class.length;
			while(i--){
				submit_class[i].style.display="none";
			}
			

		}else{
			document.getElementById(font_color_id).value='black';
			var i = submit_class.length;
			while(i--){
				submit_class[i].style.display="inline";
			}
		}
	}
	function show(id){
		if((!document.getElementById("doraemon").value)||(document.getElementById("doraemon").value=='invisible')){
			document.getElementById(id).style.display="block";
			document.getElementById("doraemon").value='visible'
		}else{
			document.getElementById(id).style.display="none"; //hide
			document.getElementById("doraemon").value='invisible'
		}
	}
	function xml(list_id,e_id,u_id,borrow_time,delaytimes,recordtimes,trade_sequence,u_turn_time){
		var srh = 'list_'+list_id+'_a';
		var ass_id = document.getElementById(srh).value;
		var u_t_t_key = 'list_'+list_id+'_u';
		var u_turn_time = document.getElementById(u_t_t_key).value;
		srh = 'list_'+list_id+'_t';
		var thing = document.getElementById(srh).value;
		var xmlhttp;
		var list = 'list_'+list_id;
		var infor_div = 'inform'+list_id+'_a';
		var test_exist = document.getElementById(infor_div).innerHTML;
		
		if(test_exist!='<br>通知助理:<br>預計歸還時間:<br><br>備註:'){''
			infor_div = 'inform'+list_id+'_b';
			test_exist2 = document.getElementById(infor_div).innerHTML;
			if(test_exist2!='<br>通知助理:<br>預計歸還時間:<br><br>備註:'){
				infor_div = 'inform'+list_id+'_c';
				test_exist3 = document.getElementById(infor_div).innerHTML;
				if(test_exist3!='<br>通知助理:<br>預計歸還時間:<br><br>備註:'){
					alert('已通知三次!');
					return false;
				}
			}
		}
			if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				document.getElementById(infor_div).innerHTML="<img src='img/ajaxloader.gif' />";
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					array = xmlhttp.responseText.split("--");
					document.getElementById("button_"+list_id).innerHTML=array[1];
					document.getElementById(infor_div).innerHTML=array[0];
				}
			}

			xmlhttp.open("GET","send_index_fb.php?e_id="+e_id+"&u_id="+u_id+"&borrow_time="+borrow_time+"&delaytimes="+delaytimes+"&info_ass="+ass_id+"&info_detail="+thing+"&list_id="+list_id+"&recordtimes="+recordtimes+"&trade_sequence="+trade_sequence+"&u_turn_time="+u_turn_time,true);
			xmlhttp.send();

	}
</script>
<script>
$(document).ready(function(){ 
	element = $('li');
	var oldFunc = element.onmousedown;
	element.onmousedown = function (evt) {
    	this.focus();
	}
	$('#notification').css( "visibility", "hidden" );
});
</script>
</body>
</html>
<!-- Index design by Guang -->