<?php
	require '../connect_database.php';
	$query = "SELECT * FROM `user`";
	if($query_run =  mysql_query($query)){
		echo '<table><tr>';
			echo '<td style="border-width:1px; width:100px;float:left">';
			echo '學號';
			echo '</td>';
			echo '<td style="border-width:1px; width:100px;float:left">';
			echo '姓名';
			echo '</td>';
			echo '<td style="border-width:1px; width:200px;float:left">';
			echo '系級';
			echo '</td>';
			echo '<td style="border-width:1px; width:200px;float:left">';
			echo 'E-mail';
			echo '</td>';
			echo '<td style="border-width:1px; width:300px;float:left">';
			echo '電話(欄位限制:十碼)';
			echo '</td>';
		echo '</tr></table>';
		while ($query_row = mysql_fetch_assoc($query_run)){
			if($query_row[ 'blacklisted' ]=='y'){
				echo '<table id=divv'.$query_row[ 'id' ].' style="color:red;"><tr>';
			}else if($query_row[ 'blacklisted' ]=='n'){
				echo '<table id=divv'.$query_row[ 'id' ].' style="color:black;"><tr>';
			}
			echo '<td style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $query_row[ 'id' ];
			echo '</td>';
			echo '<td style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $query_row[ 'name' ];
			echo '</td>';
			echo '<td style="border-style:solid;border-width:1px; width:200px;float:left">';
			echo $query_row[ 'department' ];
			echo '</td>';
			echo '<td style="border-style:solid;border-width:1px; width:200px;float:left">';
			echo $query_row[ 'email' ];
			echo '</td>';
			echo '<td style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $query_row[ 'phone' ];
			echo '</td>';
			echo '<td><input type="button" value="修改" onclick="modify(\''.$query_row[ 'id' ].'\',\''.$query_row[ 'name' ].'\',\''.$query_row[ 'department' ].'\',\''.$query_row[ 'email' ].'\',\''.$query_row[ 'phone' ].'\');"></td>';
			echo '<td><input type="button" value="刪除" onclick="removde(\''.$query_row[ 'id' ].'\');"></td>';
			if($query_row[ 'blacklisted' ]=='y'){
				echo '<td><input type="button" id="black_'.$query_row[ 'id' ].'" value="取消黑名單" onclick="blackbody(\''.$query_row[ 'id' ].'\',\''.$query_row[ 'name' ].'\',\''.$query_row[ 'department' ].'\',\''.$query_row[ 'email' ].'\',\''.$query_row[ 'phone' ].'\');"></td>';
			}else if($query_row[ 'blacklisted' ]=='n'){
				echo '<td><input type="button" id="black_'.$query_row[ 'id' ].'" value="黑名單" onclick="blackbody(\''.$query_row[ 'id' ].'\',\''.$query_row[ 'name' ].'\',\''.$query_row[ 'department' ].'\',\''.$query_row[ 'email' ].'\',\''.$query_row[ 'phone' ].'\');"></td>';
			}			
			echo '</tr></table>';
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
			xmlhttp.open("GET","remove_hello.php?q="+divvid,true);
			xmlhttp.send();
		}
		else{
			return false;
		}
		
	}
	function modify(id,name,department,email,phone){
		var black_value = document.getElementById("black_"+id).value;
		// document.getElementById("divv"+id).innerHTML='<input id="'+id+'u_id" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+id+'"><input id="'+id+'u_name" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+name+'"><select id="'+id+'u_depart" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+department+'"><option value="mis">mis</option><option value="sim">sim</option><option value="ims">ims</option></select><input id="'+id+'u_email" type="text" style="border-style:solid;border-width:1px;width:202px;height:21px;"; value="'+email+'"><input id="'+id+'u_phone" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+phone+'"><input type="button" value="修改完畢" onclick="modify_send(\''+black_value+'\',\''+id+'\',\''+name+'\',\''+department+'\',\''+email+'\',\''+phone+'\');"><br><br>';	
		document.getElementById("divv"+id).innerHTML='<tr><td><input id="'+id+'u_id" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+id+'"></td><td><input id="'+id+'u_name" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+name+'"></td><td><input type="text" id="'+id+'u_depart" style="border-style:solid;border-width:1px; width:202px;height:21px;"; value="'+department+'"></td><td><input id="'+id+'u_email" type="text" style="border-style:solid;border-width:1px;width:202px;height:21px;"; value="'+email+'"></td><td><input id="'+id+'u_phone" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+phone+'"></td><td><input type="button" value="修改完畢" onclick="modify_send(\''+black_value+'\',\''+id+'\',\''+name+'\',\''+department+'\',\''+email+'\',\''+phone+'\');"></td></tr>';	
		if(black_value=="取消黑名單"){
			document.getElementById("divv"+id).style.background = "pink";
		}
	}
	function modify_send(black_value,id,name,department,email,phone){
		var strs = new Array();
		strs[0] = document.getElementById(id+"u_id").value;
		strs[1] = document.getElementById(id+"u_name").value;
		strs[2] = document.getElementById(id+"u_depart").value;
		strs[3] = document.getElementById(id+"u_email").value;
		strs[4] = document.getElementById(id+"u_phone").value;
		strs[5] = id; //original id's value
		if(black_value=="黑名單"){//要修
			strs[6] = "black_yes";
		}else if(black_value=="取消黑名單"){
			strs[6] = "black_no";
		}
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
		xmlhttp.open("GET","modify_hello.php?q="+strs,true);
		xmlhttp.send();
	}
	function blackbody(id,name,department,email,phone){		
		var blacks = new Array();
		blacks[0] = id;
		blacks[1] = '';
		var xmlhttp;
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else{// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		if(document.getElementById("black_"+id).value=="黑名單"){ //決定要黑名單人
			document.getElementById("divv"+id).style.color = "red";
			document.getElementById("black_"+id).value="取消黑名單";
			blacks[1] = 'y';
			xmlhttp.open("GET","blacklist_hello.php?q="+blacks,true);
			xmlhttp.send();
		}
		else if(document.getElementById("black_"+id).value=="取消黑名單"){//決定要取消黑名單人
			document.getElementById("divv"+id).style.color = "black";
			document.getElementById("black_"+id).value="黑名單";	
			blacks[1] = 'n';
			xmlhttp.open("GET","blacklist_hello.php?q="+blacks,true);
			xmlhttp.send();
		}

		
	}
	</script>
		
		

<!---->