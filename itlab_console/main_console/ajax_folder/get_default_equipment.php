<?php
	require '../../connect_database.php';
	$e_id = $_POST["e_id"];
	$sql = "SELECT `setting`.`subcategory` FROM `equipment` INNER JOIN `setting` ON (`equipment`.`class` = `setting`.`e_class` AND `setting`.`subcategory` IS NOT NULL AND `equipment`.`parent` IS NULL AND `equipment`.`id` = '".$e_id."' ) GROUP BY `equipment`.id";
	$sql_run = mysql_query($sql);
	$sql_row = mysql_fetch_assoc($sql_run);

	$subcategory_arr = explode(';',$sql_row["subcategory"]);
	array_pop($subcategory_arr);
	$result = '';

	$sql_equ = "SELECT `equipment`.`id` FROM `equipment` INNER JOIN `setting` ON (`setting`.`subcategory` IS NULL AND `equipment`.`parent` IS NULL) GROUP BY `equipment`.id";
	$sql_equ_run = mysql_query($sql_equ);
	$other_option = '';
	while($sql_equ_row = mysql_fetch_assoc($sql_equ_run)){
		$other_option = $other_option.'<option value="'.$sql_equ_row["id"].'">'.$sql_equ_row["id"].'</option>';
	}

	for($i=0;$i<sizeof($subcategory_arr);$i++){
		$sql_G = "SELECT `id` FROM `equipment` WHERE `equipment`.`class` = '".$subcategory_arr[$i]."' AND `parent` = '".$e_id."' LIMIT 1";
		$sql_run_G = mysql_query($sql_G);
		
		$sql_Gson = "SELECT `equipment`.`id` FROM `equipment`,`setting` WHERE `setting`.`subcategory` IS NULL AND `equipment`.`parent` IS NULL AND `equipment`.`class`='".$subcategory_arr[$i]."' AND `equipment`.`class` = `setting`.`e_class`";
		$sql_run1 = mysql_query($sql_Gson);
		$the_option = '';
		while($sql_row1 = mysql_fetch_assoc($sql_run1)){
			$the_option = $the_option.'<option value="'.$sql_row1["id"].'">'.$sql_row1["id"].'</option>';
		}
		if(mysql_num_rows($sql_run_G)>0){
			while($sql_row_G = mysql_fetch_assoc($sql_run_G)){
				$result = $result.'<div>類別:  <span style="background-color:pink">'.$subcategory_arr[$i].'</span><select name="package_content_'.$i.'"><option disabled value="NONE">請選擇物品</option><option value="'.$sql_row_G["id"].'" selected>'.$sql_row_G["id"].'</option>'.$the_option.'</select><input type="hidden" name="amount" value="'.sizeof($subcategory_arr).'" /><input type="hidden" name="parent_id" value="'.$e_id.'" /><input type="hidden" name="default_item_'.$i.'" value="'.$sql_row_G["id"].'" /><img style="height:19px;vertical-align:middle" src="cancel.png" onclick="this.parentNode.getElementsByTagName(\'option\')[0].selected = true;" /></div>';
			}
		}else{
			$result = $result.'<div>類別:  <span style="background-color:pink">'.$subcategory_arr[$i].'</span><select name="package_content_'.$i.'"><option disabled value="NONE" selected>請選擇物品</option>'.$the_option.'</select><input type="hidden" name="amount" value="'.sizeof($subcategory_arr).'" /><input type="hidden" name="parent_id" value="'.$e_id.'" /><img style="height:19px;vertical-align:middle;" src="cancel.png" onclick="this.parentNode.getElementsByTagName(\'option\')[0].selected = true;" /></div>';
		}
	}
	echo json_encode($result);
?>