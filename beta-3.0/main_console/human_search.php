<?php
require '../connect_database.php';
if ($_POST) {
	$search = trim($_POST["human_name_search"]);
	$NewString_search = preg_split("/[\s,]+/",$search);
	if(count($NewString_search)<=1){
		$sql = 'SELECT * FROM `user` WHERE `id` LIKE \'%'.$NewString_search[0].'%\' OR `name` LIKE \'%'.$NewString_search[0].'%\' OR `department` LIKE \'%'.$NewString_search[0].'%\' OR `email` LIKE \'%'.$NewString_search[0].'%\' OR `phone` LIKE \'%'.$NewString_search[0].'%\'';
	}
	elseif (count($NewString_search)>1) {
		$sql = 'SELECT * FROM `user` WHERE (`id` LIKE \'%'.$NewString_search[0].'%\' OR `name` LIKE \'%'.$NewString_search[0].'%\' OR `department` LIKE \'%'.$NewString_search[0].'%\' OR `email` LIKE \'%'.$NewString_search[0].'%\' OR `phone` LIKE \'%'.$NewString_search[0].'%\')';
		for($i=1;$i<count($NewString_search);$i++){
			$sql_add = ' AND (`id` LIKE \'%'.$NewString_search[$i].'%\' OR `name` LIKE \'%'.$NewString_search[$i].'%\' OR `department` LIKE \'%'.$NewString_search[$i].'%\' OR `email` LIKE \'%'.$NewString_search[$i].'%\' OR `phone` LIKE \'%'.$NewString_search[$i].'%\')';
			$sql = $sql.$sql_add;	
		}
	}
	$sql_result = mysql_query($sql);

	if($sql_row=mysql_fetch_array($sql_result)){
		echo '<div>';
			echo '<div style="border-width:1px; width:100px;float:left">';
			echo '學號';
			echo '</div>';
			echo '<div style="border-width:1px; width:100px;float:left">';
			echo '姓名';
			echo '</div>';
			echo '<div style="border-width:1px; width:100px;float:left">';
			echo '系級';
			echo '</div>';
			echo '<div style="border-width:1px; width:200px;float:left">';
			echo 'E-mail';
			echo '</div>';
			echo '<div style="border-width:1px; width:300px;float:left">';
			echo '電話(欄位限制:十碼)';
			echo '</div>';
		echo '</div>';
		echo '<br>';
		echo '<br>';
		if($sql_row[ 'blacklisted' ]=='y'){
				echo '<div id=divv'.$sql_row[ 'id' ].' style="color:red;">';
			}else if($sql_row[ 'blacklisted' ]=='n'){
				echo '<div id=divv'.$sql_row[ 'id' ].' style="color:black;">';
			}
		echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'id' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'name' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'department' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:200px;float:left">';
			echo $sql_row[ 'email' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'phone' ];
			echo '</div>';
			
			echo '<input type="button" value="修改" onclick="modify(\''.$sql_row[ 'id' ].'\',\''.$sql_row[ 'name' ].'\',\''.$sql_row[ 'department' ].'\',\''.$sql_row[ 'email' ].'\',\''.$sql_row[ 'phone' ].'\');">';
			echo '<input type="button" value="刪除" onclick="removde(\''.$sql_row[ 'id' ].'\');">';
			
			if($sql_row[ 'blacklisted' ]=='y'){
				echo '<input type="button" id="black_'.$sql_row[ 'id' ].'" value="取消黑名單" onclick="blackbody(\''.$sql_row[ 'id' ].'\',\''.$sql_row[ 'name' ].'\',\''.$sql_row[ 'department' ].'\',\''.$sql_row[ 'email' ].'\',\''.$sql_row[ 'phone' ].'\');">';
			}else if($sql_row[ 'blacklisted' ]=='n'){
				echo '<input type="button" id="black_'.$sql_row[ 'id' ].'" value="黑名單" onclick="blackbody(\''.$sql_row[ 'id' ].'\',\''.$sql_row[ 'name' ].'\',\''.$sql_row[ 'department' ].'\',\''.$sql_row[ 'email' ].'\',\''.$sql_row[ 'phone' ].'\');">';
			}	

		echo '<br>';
		echo '<br>';
		echo '</div>';

		while ($sql_row = mysql_fetch_array($sql_result)){
			if($sql_row[ 'blacklisted' ]=='y'){
				echo '<div id=divv'.$sql_row[ 'id' ].' style="color:red;">';
			}else if($sql_row[ 'blacklisted' ]=='n'){
				echo '<div id=divv'.$sql_row[ 'id' ].' style="color:black;">';
			}
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'id' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'name' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'department' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:200px;float:left">';
			echo $sql_row[ 'email' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'phone' ];
			echo '</div>';

			echo '<input type="button" value="修改" onclick="modify(\''.$sql_row[ 'id' ].'\',\''.$sql_row[ 'name' ].'\',\''.$sql_row[ 'department' ].'\',\''.$sql_row[ 'email' ].'\',\''.$sql_row[ 'phone' ].'\');">';
			echo '<input type="button" value="刪除" onclick="removde(\''.$sql_row[ 'id' ].'\');">';
			
			if($sql_row[ 'blacklisted' ]=='y'){
				echo '<input type="button" id="black_'.$sql_row[ 'id' ].'" value="取消黑名單" onclick="blackbody(\''.$sql_row[ 'id' ].'\',\''.$sql_row[ 'name' ].'\',\''.$sql_row[ 'department' ].'\',\''.$sql_row[ 'email' ].'\',\''.$sql_row[ 'phone' ].'\');">';
			}else if($sql_row[ 'blacklisted' ]=='n'){
				echo '<input type="button" id="black_'.$sql_row[ 'id' ].'" value="黑名單" onclick="blackbody(\''.$sql_row[ 'id' ].'\',\''.$sql_row[ 'name' ].'\',\''.$sql_row[ 'department' ].'\',\''.$sql_row[ 'email' ].'\',\''.$sql_row[ 'phone' ].'\');">';
			}			
			echo '<br>';
			echo '<br>';
			echo '</div>';

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
				document.getElementById("divv"+id).innerHTML='<input id="'+id+'u_id" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+id+'"><input id="'+id+'u_name" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+name+'"><input type="text" id="'+id+'u_depart" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+department+'"><input id="'+id+'u_email" type="text" style="border-style:solid;border-width:1px;width:202px;height:21px;"; value="'+email+'"><input id="'+id+'u_phone" type="text" style="border-style:solid;border-width:1px; width:102px;height:21px;"; value="'+phone+'"><input type="button" value="修改完畢" onclick="modify_send(\''+black_value+'\',\''+id+'\',\''+name+'\',\''+department+'\',\''+email+'\',\''+phone+'\');"><br><br>';	
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