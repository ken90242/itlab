<?php
require '../connect_database.php';
if ($_POST) {
	$search = trim($_POST["stuff_name_search"]);
	$NewString_search = preg_split("/[\s,]+/",$search);
	if(count($NewString_search)<=1){
		$sql = 'SELECT * FROM `equipment` WHERE `id` LIKE \'%'.$NewString_search[0].'%\' OR `name` LIKE \'%'.$NewString_search[0].'%\' OR `class` LIKE \'%'.$NewString_search[0].'%\' OR `status` LIKE \'%'.$NewString_search[0].'%\' OR `current_owner` LIKE \'%'.$NewString_search[0].'%\' OR `addition` LIKE \'%'.$NewString_search[0].'%\'';
	}
	elseif (count($NewString_search)>1) {
		$sql = 'SELECT * FROM `equipment` WHERE '."(".' `id` LIKE \'%'.$NewString_search[0].'%\' OR `name` LIKE \'%'.$NewString_search[0].'%\' OR `class` LIKE \'%'.$NewString_search[0].'%\' OR `status` LIKE \'%'.$NewString_search[0].'%\' OR `current_owner` LIKE \'%'.$NewString_search[0].'%\' OR `addition` LIKE \'%'.$NewString_search[0].'%\')';
		for($i=1;$i<count($NewString_search);$i++){
			$sql_add = ' AND (`id` LIKE \'%'.$NewString_search[$i].'%\' OR `name` LIKE \'%'.$NewString_search[$i].'%\' OR `class` LIKE \'%'.$NewString_search[$i].'%\' OR `status` LIKE \'%'.$NewString_search[$i].'%\' OR `current_owner` LIKE \'%'.$NewString_search[$i].'%\' OR `addition` LIKE \'%'.$NewString_search[$i].'%\')';
			$sql = $sql.$sql_add;	
		}
	}
	//echo $sql;
	//echo '<br>';
	//$sql = 'SELECT * FROM `equipment` WHERE `id` LIKE \'%'.$search.'%\' OR `name` LIKE \'%'.$search.'%\' OR `class` LIKE \'%'.$search.'%\' OR `status` LIKE \'%'.$search.'%\' OR `current_owner` LIKE \'%'.$search.'%\' OR `addition` LIKE \'%'.$search.'%\'';
	$sql_result = mysql_query($sql);


	if($sql_row=mysql_fetch_array($sql_result)){
		echo '<div>';
		echo '<div style="border-width:1px; width:100px;float:left">';
		echo '物品編號';
		echo '</div>';
		echo '<div style="border-width:1px; width:100px;float:left">';
		echo '物品名稱';
		echo '</div>';
		echo '<div style="border-width:1px; width:100px;float:left">';
		echo '物品類別';
		echo '</div>';
		echo '<div style="border-width:1px; width:200px;float:left">';
		echo '物品狀態';
		echo '</div>';
		echo '<div style="border-width:1px; width:300px;float:left">';
		echo '現在擁有者';
		echo '</div>';
		echo '</div>';
		echo '<br>';
		echo '<br>';
		echo '<div id=divv'.$sql_row[ 'id' ].'>';
		echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
		echo $sql_row[ 'id' ];
		echo '</div>';
		echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
		echo $sql_row[ 'name' ];
		echo '</div>';
		echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
		echo $sql_row[ 'class' ];
		echo '</div>';
		echo '<div style="border-style:solid;border-width:1px; width:200px;float:left">';
		echo $sql_row[ 'status' ];
		echo '</div>';
		echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
		echo $sql_row[ 'current_owner' ];
		echo '</div>';
		echo '<input type="button" value="修改" onclick="modify(\''.$sql_row[ 'id' ].'\',\''.$sql_row[ 'name' ].'\',\''.$sql_row[ 'class' ].'\',\''.$sql_row[ 'status' ].'\',\''.$sql_row[ 'current_owner' ].'\');">';
		echo '<input type="button" value="刪除" onclick="removde(\''.$sql_row[ 'id' ].'\');">';
		echo '<br>';
		echo '<br>';
		echo '</div>';
		while ($sql_row = mysql_fetch_array($sql_result)){
			echo '<div id=divv'.$sql_row[ 'id' ].'>';
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'id' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'name' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'class' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:200px;float:left">';
			echo $sql_row[ 'status' ];
			echo '</div>';
			echo '<div style="border-style:solid;border-width:1px; width:100px;float:left">';
			echo $sql_row[ 'current_owner' ];
			echo '</div>';
			echo '<input type="button" value="修改" onclick="modify(\''.$sql_row[ 'id' ].'\',\''.$sql_row[ 'name' ].'\',\''.$sql_row[ 'class' ].'\',\''.$sql_row[ 'status' ].'\',\''.$sql_row[ 'current_owner' ].'\');">';
			echo '<input type="button" value="刪除" onclick="removde(\''.$sql_row[ 'id' ].'\');">';
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