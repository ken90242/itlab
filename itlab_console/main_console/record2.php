<?php
	require '../connect_database.php';
	$query = "SELECT * FROM `trade_analyze`";
	if($query_run =  mysql_query($query)){
		echo '<table style="position:fixed;background-color:yellow;">';
		echo '<tr>';
			echo '<td style="border-width:1px; width:100px;float:left;text-align: center;">';
			echo '借用人ID';
			echo '</td>';
			echo '<td style="border-width:1px; width:250px;float:left;text-align: center;">';
			echo '借用人系所';
			echo '</td>';
			echo '<td style="border-width:1px; width:200px;float:left;text-align: center;">';
			echo '物品ID';
			echo '</td>';
			// echo '<td style="border-width:1px; width:350px;float:left;text-align: center;">';
			// echo '經辦人ID';
			// echo '</td>';
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
			echo '其他備註';
			echo '</td>';
			echo '<td style="border-width:1px; width:200px;float:left;text-align: center;">';
			echo '使用課程';
			echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '<hr style="position:fixed;">';
		echo '<br>';
		echo '<br>';
		while ($query_row = mysql_fetch_assoc($query_run)){
			echo '<table id=divv'.$query_row[ 't_sequence' ].' ">';
			echo '<tr>';
				echo '<td style="border-style:solid;border-width:1px; width:100px;font-size:8px;">';
				echo $query_row[ 'u_id' ]!="" ? $query_row[ 'u_id' ] : '無';
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:250px;font-size:8px;">';
				echo $query_row[ 'u_department' ]!="" ? $query_row[ 'u_department' ] : '無';
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;font-size:8px;">';
				echo $query_row[ 'e_id' ]!="" ? $query_row[ 'e_id' ] : '無';
				echo '</td>';

				// echo '<td style="border-style:solid;border-width:1px; width:350px; font-size:7px;">';
				// echo $query_row[ 'handler' ];
				// echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;font-size:8px;">';
				echo $query_row[ 't_borrow_time' ]!="" ? $query_row[ 't_borrow_time' ] : '無';
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;font-size:8px;">';
				echo $query_row[ 't_deadline_time' ]!="" ? $query_row[ 't_deadline_time' ] : '無';
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;font-size:8px;">';
				echo $query_row[ 't_return_time' ]!="" ? $query_row[ 't_return_time' ] : '無';
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;font-size:8px;">';
				echo $query_row[ 't_addition_note' ]!="" ? $query_row[ 't_addition_note' ] : '無';
				echo '</td>';

				echo '<td style="border-style:solid;border-width:1px; width:200px;font-size:8px;">';
				echo $query_row[ 't_class' ]!="" ? $query_row[ 't_class' ] : '無';
				echo '</td>';

			echo '</tr>';
			echo '</table>';
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