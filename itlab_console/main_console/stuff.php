<?php
	require '../connect_database.php';
	session_start();
	$sql = 'SELECT `e_class` FROM `setting`';
	$sql2 = 'SELECT count(*) FROM `setting`';
	$total_counts_array = mysql_fetch_row(mysql_query($sql2)); 
	$total_counts = $total_counts_array[0];
	$_SESSION['total_class_option'] = '';
	if($query_run =  mysql_query($sql)){
		while ($query_row = mysql_fetch_assoc($query_run)) {
			$_SESSION['total_class_option'] = $_SESSION['total_class_option'].'<option value=\\\''.$query_row['e_class'].'\\\'>'.$query_row['e_class'].'</option>';
		}
	}else{
		echo "<SCRIPT Language=javascript>";
		echo "window.alert('".mysql_error()."')";
		echo "</SCRIPT>";
	}

	$query = "SELECT * FROM `equipment`";
	if($query_run =  mysql_query($query)){
		echo '<table id=divv'.$query_row[ 'id' ].'>';
			echo '<tr>';
			echo '<td style="border-width:1px; width:200px;float:left">';
			echo '物品編號';
			echo '</td>';
			echo '<td style="border-width:1px; width:300px;float:left">';
			echo '物品名稱';
			echo '</td>';
			echo '<td style="border-width:1px; width:100px;float:left">';
			echo '物品類別';
			echo '</td>';
			echo '<td style="border-width:1px; width:200px;float:left">';
			echo '物品狀態';
			echo '</td>';
			echo '<td style="border-width:1px; width:300px;float:left">';
			echo '現在擁有者';
			echo '</td>';
		echo '</tr>';
		echo '</table>';
		while ($query_row = mysql_fetch_assoc($query_run)){
			echo '<table id=divv'.$query_row[ 'id' ].'>';
			echo '<tr>';
			echo '<td style="border-style:solid;border-width:1px; width:200px;float:left">';
			echo $query_row[ 'id' ];
			echo '</td>';
			echo '<td style="border-style:solid;border-width:1px; width:300px;float:left">';
			echo $query_row[ 'name' ];
			echo '</td>';
			if($query_row[ 'class' ]=='undefined'){
				echo '<td style="border-style:solid;border-width:1px;width:100px;float:left;color:red;">';
				echo $query_row[ 'class' ];
				echo '</td>';
			}else{
				echo '<td style="border-style:solid;border-width:1px; width:100px;float:left">';
				echo $query_row[ 'class' ];
				echo '</td>';
			}
			echo '<td style="border-style:solid;border-width:1px; width:200px;float:left">';
			echo $query_row[ 'status' ];
			echo '</td>';
			echo '<td style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $query_row[ 'current_owner' ];
			echo '</td>';
			echo '<td>';
			echo '<input type="button" value="修改" onclick="modify(\''.$query_row[ 'id' ].'\',\''.$query_row[ 'name' ].'\',\''.$query_row[ 'class' ].'\',\''.$query_row[ 'status' ].'\',\''.$query_row[ 'current_owner' ].'\',\''.$_SESSION['total_class_option'].'\');">';
			echo '<input type="button" value="刪除" onclick="removde(\''.$query_row[ 'id' ].'\');">';
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
	function modify(id,name,classes,status,current_owner,total_class_option){
		document.getElementById("divv"+id).innerHTML='<tr><td><input id="'+id+'e_id" type="text" style="border-style:solid;border-width:1px; width:202px;height:21px;"; value="'+id+'"></td><td><input id="'+id+'e_name" type="text" style="border-style:solid;border-width:1px; width:302px;height:21px;"; value="'+name+'"></td><td><select id="'+id+'e_classes" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+classes+'">'+total_class_option+'</select></td><td><select id="'+id+'e_status" style="border-style:solid;border-width:1px; width:202px;height:21px;"; value="'+status+'"><option value="return">return</option><option value="borrowed">borrowed</option></select><input id="'+id+'e_current_owner" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+current_owner+'" disabled></td><td><input type="button" value="修改完畢" onclick="modify_send(\''+id+'\',\''+name+'\',\''+classes+'\',\''+status+'\',\''+current_owner+'\');"></td></tr>';	
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
			document.getElementById("divv"+id).innerHTML="<img src='ajaxloader.gif' />";
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
		    	document.getElementById("divv"+id).innerHTML=xmlhttp.responseText;
		    	document.getElementById("divv"+id).style.background = "";
		  	}	
		}
		xmlhttp.open("GET","modify_hello_stuff.php?q="+strs,true);
		xmlhttp.send();
	}
	</script>
		
		

<!---->