<?php
require '../../connect_database.php';
if(isset($_POST["amount"])){
	$sub_items = '';
	$dsub_items = '';
	for($i=0;$i<$_POST["amount"];$i++){
		$took = "package_content_".$i;	
		$took2 = "default_item_".$i;
		if(isset($_POST[$took])){
			$sql = "UPDATE `test`.`equipment` SET `parent` = '".$_POST["parent_id"]."',`current_owner` = 'itlab',`addition`=NULL WHERE  `equipment`.`id` =  '".$_POST[$took]."'";
		}elseif(isset($_POST[$took2])){
			$sql = "UPDATE `test`.`equipment` SET `parent` = NULL,`current_owner` = 'itlab',`addition` = NULL WHERE `equipment`.`id` =  '".$_POST[$took2]."'";
		}
		if(mysql_query(@$sql)){
			if(isset($_POST[$took])){
				if($sub_items!=''){
					$sub_items = $sub_items.','.$_POST[$took];	
				}else{
					$sub_items = $_POST[$took];
				}
			}elseif(isset($_POST[$took2])){
				if($dsub_items!=''){
					$dsub_items = $dsub_items.','.$_POST[$took2];	
				}else{
					$dsub_items = $_POST[$took2];
				}
			}
		}
		
	}
	echo "<script language=\"javascript\">";
	echo "alert('成功設立".$_POST["parent_id"]."子項目:[".$sub_items."],刪除子項目:[".$dsub_items."]');";
	echo "window.parent.window.location.href = \"../index.php\";";
	echo "</script>"; 
}
?>