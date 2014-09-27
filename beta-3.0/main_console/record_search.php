<?php
require '../connect_database.php';
if ($_POST) {
	$search = trim($_POST["record_name_search"]);
	$NewString_search = preg_split("/[\s,]+/",$search);
	if(count($NewString_search)<=1){
		$sql = 'SELECT * FROM `trade` WHERE `u_id` LIKE \'%'.$NewString_search[0].'%\' OR `e_id` LIKE \'%'.$NewString_search[0].'%\' OR `time` LIKE \'%'.$NewString_search[0].'%\' OR `deadline_time` LIKE \'%'.$NewString_search[0].'%\' OR `return_time` LIKE \'%'.$NewString_search[0].'%\' OR `e_addition_class` LIKE \'%'.$NewString_search[0].'%\'';
	}
	elseif (count($NewString_search)>1) {
		$sql = 'SELECT * FROM `trade` WHERE (`u_id` LIKE \'%'.$NewString_search[0].'%\' OR `e_id` LIKE \'%'.$NewString_search[0].'%\' OR `time` LIKE \'%'.$NewString_search[0].'%\' OR `deadline_time` LIKE \'%'.$NewString_search[0].'%\' OR `return_time` LIKE \'%'.$NewString_search[0].'%\' OR `e_addition_class` LIKE \'%'.$NewString_search[0].'%\')';
		for($i=1;$i<count($NewString_search);$i++){
			$sql_add = ' AND (`u_id` LIKE \'%'.$NewString_search[$i].'%\' OR `e_id` LIKE \'%'.$NewString_search[$i].'%\' OR `time` LIKE \'%'.$NewString_search[$i].'%\' OR `deadline_time` LIKE \'%'.$NewString_search[$i].'%\' OR `return_time` LIKE \'%'.$NewString_search[$i].'%\' OR `e_addition_class` LIKE \'%'.$NewString_search[$i].'%\')';
			$sql = $sql.$sql_add;
		}
	}
	$sql_result = mysql_query($sql);
	if($sql_row=mysql_fetch_array($sql_result)){
		echo '<table style="position:fixed;background-color:yellow;">';
		echo '<tr>';

		echo '<td style="border-width:1px; width:100px;float:left;text-align: center;">';
			echo '借用人ID';
			echo '</td>';
			echo '<td style="border-width:1px; width:200px;float:left;text-align: center;">';
			echo '物品ID';
			echo '</td>';
			echo '<td style="border-width:1px; width:350px;float:left;text-align: center;">';
			echo '經辦人ID';
			echo '</td>';
			echo '<td style="border-width:1px; width:200px;float:left;text-align: center;">';
			echo '借用時間';
			echo '</td>';
			echo '<td style="border-width:1px; width:200px;float:left;text-align: center;">';
			echo '歸還期限';
			echo '</td>';
			echo '<td style="border-width:1px; width:200px;float:left;text-align: center;">';
			echo '歸還時間';
			echo '</td>';
			echo '<td style="border-width:1px; width:200px;float:left;text-align: center;">';
			echo '使用課程';
			echo '</td>';
		echo '</tr>';
		echo '</table>';

		echo '<table id=divv'.$sql_row[ 'sequence' ].' ">';
		echo '<tr>';
			echo '<td style="border-style:solid;border-width:1px; width:100px;">';
			echo $sql_row[ 'u_id' ];
			echo '</td>';

			echo '<td style="border-style:solid;border-width:1px; width:200px;">';
			echo $sql_row[ 'e_id' ];
			echo '</td>';

			echo '<td style="border-style:solid;border-width:1px; width:350px;font-size:6px;">';
			echo $sql_row[ 'handler' ];
			echo '</td>';

			echo '<td style="border-style:solid;border-width:1px; width:200px;">';
			echo $sql_row[ 'time' ];
			echo '</td>';

			echo '<td style="border-style:solid;border-width:1px; width:200px;">';
			echo $sql_row[ 'deadline_time' ];
			echo '</td>';

			echo '<td style="border-style:solid;border-width:1px; width:200px;">';
			echo $sql_row[ 'return_time' ];
			echo '</td>';

			echo '<td style="border-style:solid;border-width:1px; width:200px;font-size:6px;">';
			echo $sql_row[ 'e_addition_class' ];
			echo '</td>';
		echo '</tr>';
		echo '</table>';
		while($sql_row = mysql_fetch_array($sql_result)){
			echo '<table id=divv'.$sql_row[ 'sequence' ].' ">';
			echo '<tr>';
				echo '<td style="border-style:solid;border-width:1px; width:100px;">';
				echo $sql_row[ 'u_id' ];
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;">';
				echo $sql_row[ 'e_id' ];
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:350px;font-size:6px;">';
				echo $sql_row[ 'handler' ];
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;">';
				echo $sql_row[ 'time' ];
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;">';
				echo $sql_row[ 'deadline_time' ];
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;">';
				echo $sql_row[ 'return_time' ];
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;font-size:6px;">';
				echo $sql_row[ 'e_addition_class' ];
				echo '</td>';

			echo '</tr>';
			echo '</table>';
		}
	}else if(!$sql_row = mysql_fetch_array($sql_result)){
		echo '查無資料';
	}
}

?>
<script language="javascript">;
	function removde(divvid){
		var xmlhttp;
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		if(confirm("確定刪除?")){
			document.getElementById("divv"+divvid).parentNode.removeChild(document.getElementById("divv"+divvid));
			xmlhttp.open("GET","remove_hello_stuff.php?q="+divvid,true);
			xmlhttp.send();
		}
		else{
			return false;
		}
		
	}
	function modify(id,name,classes,status,current_owner){
		document.getElementById("divv"+id).innerHTML='<input id="'+id+'e_id" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+id+'"><input id="'+id+'e_name" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+name+'"><select id="'+id+'e_classes" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+classes+'"><option value="ot">ot</option><option value="nb">nb</option><option value="dv">dv</option></select><select id="'+id+'e_status" style="border-style:solid;border-width:1px; width:202px;height:21px;"; value="'+status+'"><option value="return">return</option><option value="borrowed">borrowed</option></select><input id="'+id+'e_current_owner" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+current_owner+'" disabled><input type="button" value="修改完畢" onclick="modify_send(\''+id+'\',\''+name+'\',\''+classes+'\',\''+status+'\',\''+current_owner+'\');"><br><br>';	
	}
	function modify_send(id,name,classes,status,current_owner){
		var strs = new Array();
		strs[0] = document.getElementById(id+"e_id").value;
		strs[1] = document.getElementById(id+"e_name").value;
		strs[2] = document.getElementById(id+"e_classes").value;
		strs[3] = document.getElementById(id+"e_status").value;
		strs[4] = document.getElementById(id+"e_current_owner").value;
		strs[5] = id; //original id's value
		var xmlhttp;
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("divv"+id).innerHTML=xmlhttp.responseText;
				document.getElementById("divv"+id).style.background = "";
			}
		}
		xmlhttp.open("GET","modify_hello_stuff.php?q="+strs,true);
		xmlhttp.send();
	}
	</script>