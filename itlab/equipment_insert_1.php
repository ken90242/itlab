<?php
	session_start();
	require 'connect_database.php';
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<!-- equipment client side -->
	<body onload="document.getElementById('insert_equip_name').focus()">
	<form action="equipment_insert_2.php" method="POST">
		<?php
			$new_equip_id = $_SESSION['new_equid_id'];
			echo "<label>新增設備狀態</label><br><br><label>器材條碼</label><input type=\"text\" id=\"insert_equip_id\" name=\"insert_equip_id\" value=\"$new_equip_id\" onchange=\"checkValue()\"><br>";
		?>
		<label>器材名稱</label><input type="text" id="insert_equip_name" name="insert_equip_name" onchange="checkValue()"><br>
		<label>器材類別</label><select name="insert_equip_class">
		<?php 
			$sql = 'SELECT `e_class` FROM `setting`';
			$sql2 = 'SELECT count(*) FROM `setting`';
			$total_counts_array = mysql_fetch_row(mysql_query($sql2)); 
			$total_counts = $total_counts_array[0];
			global $total_class_option;
			$total_class_option = '';
			if($query_run =  mysql_query($sql)){
				while ($query_row = mysql_fetch_assoc($query_run)) {
					$total_class_option = $total_class_option.'<option value="'.$query_row['e_class'].'">'.$query_row['e_class'].'</option>';
				}
			}else{
				echo "<SCRIPT Language=javascript>";
				echo "window.alert('".mysql_error()."')";
				echo "</SCRIPT>";
			}
			echo $total_class_option;
		?></select><br>
		<input type="submit" value="submit">
	</form>
</body>
</html>