<html>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<body>
<?php
	require '../connect_database.php';
	$sql = 'SELECT `e_class`,`subcategory` FROM `setting`';
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
?>
<div>
	<div>
	<span><strong><新增類別></strong></span><br>
		<form action="" method="POST" style="width:800px;">
			<label>新增類別:  </label><input type="text" name="e_class_name_new"></input>
			<input type="submit" value="確定"></input>
		</form>
	</div>
	<div>
	<span><strong><刪除類別></strong></span><br>
		<form action="" method="POST" style="width:800px;">
			<label>刪除類別:  </label>
			<select name="e_class_name_delete">
			<?php
				echo $total_class_option;
			?>
			</select>
			<input type="submit" value="確定"></input>
		</form>
	</div>
	<div>
	<span><strong><修改類別名稱></strong></span><br>
		<form action="" method="POST" style="width:800px;">
			<label>修改前原類別名稱:  </label><select name="e_class">
			<?php
				echo $total_class_option;
			?>
			</select>
			<br><label>修改後新類別名稱: </label>
			<input type="text" name="e_class_name_modify"></input>
			<input type="submit" value="確定"></input>
		</form>
	</div>
	<div>
	<span><strong><類別天數設定></strong></span><br>
		<form action="" method="POST" style="width:800px;">
			<label>類別:  </label><select name="e_class">
			<?php
				echo $total_class_option;
			?>
			</select>
			<label>初借用天數(日):  </label><input type="text" name="deadline_gap"></input>
			<input type="submit" value="確定"></input>
		</form>
		<form action="" method="POST" style="width:800px;">
			<label>類別:  </label><select name="e_class">
			<?php
				echo $total_class_option;
			?>
			</select>
			<label>續借用天數(日):  </label><input type="text" name="continue_deadline_gap"></input>
			<input type="submit" value="確定"></input><label>&nbsp;&nbsp;(設為0即該項目不得續借)</label>
		</form>
	</div>
	<div>
	<span><strong><類別金額設定></strong></span><br>
		<form action="" method="POST" style="width:800px;">
			<label>類別:  </label><select name="e_class">
			<?php
				echo $total_class_option;
			?>
			</select>
			<label>保證金金額(元):  </label><input type="text" name="margin"></input>
			<input type="submit" value="確定"></input>
		</form>
		<form action="" method="POST" style="width:800px;">
			<label>類別:  </label><select name="e_class">
			<?php
				echo $total_class_option;
			?>
			</select>
			<label>罰金金額(元):  </label><input type="text" name="fine"></input>
			<input type="submit" value="確定"></input>
		</form>
	</div>
	<div>
	<span><strong><類別是否重複借用設定></strong></span><br>
		<form action="" method="POST" style="width:800px;">
			<label>類別:  </label><select name="e_repeat">
			<?php
				echo $total_class_option;
			?>
			</select>
			<input type="submit" value="確定"></input>
		</form>
	</div>
	<div>
	<span><strong><類別是否可延借至隔天設定></strong></span><br>
		<form action="" method="POST" style="width:800px;">
			<label>類別:  </label><select name="e_overday_noon">
			<?php
				echo $total_class_option;
			?>
			</select>
			<input type="submit" value="確定"></input>
		</form>
	</div>
	<div>
	<span><strong><子類別管理></strong></span><br>
		<table>
		
		<?php
			if($query_run =  mysql_query($sql)){
				echo '<tr><th>父類別</th>';
				while($query_row = mysql_fetch_assoc($query_run)) {
					echo '<td style="text-align:center">'.$query_row['e_class'].'</td>';
				}
			}
			if($query_run1 =  mysql_query($sql)){
				echo '</tr><tr><th>子類別</th>';
				while($query_row1 = mysql_fetch_assoc($query_run1)) {
					if(isset($query_row1['subcategory'])){
						echo '<td style="text-align:center">'.substr($query_row1['subcategory'],0,-1).'</td>';
					}else{
						echo '<td style="text-align:center">無</td>';
					}
				}
				echo '</tr>';
			}
		?>
			
		</table>
		<form action="" method="POST" style="width:800px;">
			<input type="radio" name="Psubclass" onclick="document.getElementById('Psubclass_new').style.display='block';document.getElementById('Psubclass_remove').style.display='none';">新增
			<input type="radio" name="Psubclass" onclick="document.getElementById('Psubclass_remove').style.display='block';document.getElementById('Psubclass_new').style.display='none';">刪除
			<div id="Psubclass_remove" style="display:none">
				<label>父類別:  </label><select name="parent_class_d">
				<?php
					$sql4 = "SELECT `e_class` FROM `setting` WHERE `subcategory` IS NOT NULL";
					if($query_run =  mysql_query($sql4)){
						while ($query_row = mysql_fetch_assoc($query_run)) {
							$parent_option = $parent_option.'<option value="'.$query_row['e_class'].'">'.$query_row['e_class'].'</option>';
						}
					}
					echo $parent_option;
				?>
				</select>
				<label>子類別:  </label><select name="child_class_d" disabled>
					
				</select>
				<input type="submit" value="確定刪除"></input>
			</div>
			<div id="Psubclass_new" style="display:none">
				<label>父類別:  </label><select name="parent_class_n">
				<?php
					echo $total_class_option;
				?>
				</select>
				<label>子類別:  </label><select name="child_class_n" disabled>
					
				</select>
				<input type="submit" value="確定新增"></input>
			</div>
		</form>
	</div>	
</div>
</body>
</html>
<?php 
	if(!is_null(@$_POST["e_class_name_new"])){
		$e_class = $_POST["e_class_name_new"];
		$sql = 'INSERT INTO `test`.`setting` (`e_class`, `deadline_gap`, `fine`) VALUES (\''.$e_class.'\',\'4\', \'500\');';
		if(mysql_query($sql)){
			echo "<SCRIPT Language=javascript>";
			echo "window.alert('已新增類別".$e_class."!(預設天數為4天,罰金為500元)')";
			echo "</SCRIPT>";
			BackToIndexPage();
		}else{
			echo "<SCRIPT Language=javascript>";
			echo "window.alert('".mysql_error()."')";
			echo "</SCRIPT>";
		}
	}
	if(!is_null(@$_POST["e_class_name_delete"])){
		$e_class =  mysql_real_escape_string($_POST["e_class_name_delete"]);
		$sql = 'DELETE FROM `setting` WHERE CONVERT(`setting`.`e_class` USING utf8) = \''.$e_class.'\' LIMIT 1;';
		if(mysql_query($sql)){
			//修改原物品類別為undefined

			$sql3 = 'UPDATE  `test`.`equipment` SET  `class` =  \'undefined\' WHERE  `class` = \''.$e_class.'\'';
			if(mysql_query($sql3)){
				echo "<SCRIPT Language=javascript>";
				echo "window.alert('success!')";
				echo "</SCRIPT>";
			}else{
				echo "<SCRIPT Language=javascript>";
				echo "window.alert('failed')";
				echo "</SCRIPT>";
			}			
				
			// echo "<SCRIPT Language=javascript>";
			// echo "window.alert('類別id: ".$tca."!')";
			// echo "window.alert('已刪除類別".$e_class."!(該類別所有物品類別將改為'undefined',未修改前不得進行任何運行作業)')";
			// echo "</SCRIPT>";
			// BackToIndexPage();
		}else{
			echo "<SCRIPT Language=javascript>";
			echo "window.alert('".mysql_error()."')";
			echo "</SCRIPT>";
		}			
	}
	if((!is_null(@$_POST["e_class_name_modify"]))&&(!is_null($_POST["e_class"]))){
		$e_class_before = $_POST["e_class"];
		$e_class_after = $_POST["e_class_name_modify"];
		$sql = 'UPDATE `test`.`setting` SET `e_class` = \''.$e_class_after.'\' WHERE CONVERT(`setting`.`e_class` USING utf8) = \''.$e_class_before.'\' LIMIT 1;';
		if(mysql_query($sql)){
			echo "<SCRIPT Language=javascript>";
			echo "window.alert('已修改類別名稱!(".$e_class_before." --> ".$e_class_after.")')";
			echo "</SCRIPT>";
			BackToIndexPage();
		}else{
			echo "<SCRIPT Language=javascript>";
			echo "window.alert('".mysql_error()."')";
			echo "</SCRIPT>";
		}
	}
	if(!is_null(@$_POST["deadline_gap"])){
		$e_class = $_POST["e_class"];
		$deadline_gap = $_POST["deadline_gap"];
		$query_update_e_class = "UPDATE `test`.`setting` SET  `deadline_gap` = $deadline_gap WHERE CONVERT( `setting`.`e_class` USING utf8 ) = '".$e_class."' LIMIT 1 ";
		mysql_query($query_update_e_class);
		echo "<SCRIPT Language=javascript>";
		echo "window.alert('已更改類別".$e_class."的原借用天數為".$deadline_gap."天!"."')";
		echo "</SCRIPT>";
		BackToIndexPage();
	}
	if(!is_null(@$_POST["continue_deadline_gap"])){
		$e_class = $_POST["e_class"];
		$continue_deadline_gap = $_POST["continue_deadline_gap"];
		$query_update_e_class = "UPDATE `test`.`setting` SET  `continue_deadline_gap` = $continue_deadline_gap WHERE CONVERT( `setting`.`e_class` USING utf8 ) = '".$e_class."' LIMIT 1 ";
		mysql_query($query_update_e_class);
		echo "<SCRIPT Language=javascript>";
		echo "window.alert('已更改類別".$e_class."的續借用天數為".$continue_deadline_gap."天!"."')";
		echo "</SCRIPT>";
		BackToIndexPage();
	}
	if(!is_null(@$_POST["margin"])){
		$e_class = $_POST["e_class"];
		$margin = $_POST["margin"];
		$query_update_margin = "UPDATE `test`.`setting` SET `margin` = '$margin' , `fine` = '$margin' WHERE CONVERT( `setting`.`e_class` USING utf8 ) = '".$e_class."' LIMIT 1 ";
		mysql_query($query_update_margin);
		echo "<SCRIPT Language=javascript>";
		echo "window.alert('已更改類別".$e_class."的罰金為".$margin."元!(該類別之預設罰金為此次更動之保證金金額)"."')";
		echo "</SCRIPT>";
		BackToIndexPage();
	}
	if(!is_null(@$_POST["fine"])){
		$e_class = $_POST["e_class"];
		$fine = $_POST["fine"];
		$query_update_fine = "UPDATE `test`.`setting` SET `fine` = '$fine' WHERE CONVERT( `setting`.`e_class` USING utf8 ) = '".$e_class."' LIMIT 1 ";
		mysql_query($query_update_fine);
		echo "<SCRIPT Language=javascript>";
		echo "window.alert('已更改類別".$e_class."的罰金為".$fine."元!"."')";
		echo "</SCRIPT>";
		BackToIndexPage();
	}
	if(!is_null(@$_POST["e_repeat"])){
		$e_class_repeat = $_POST["e_repeat"];
		$query_update_repeat_class = "UPDATE `test`.`equipment` SET `status` = '500' , `current_owner` = 'MultiOwner' WHERE `equipment`.`class` = '".$e_class_repeat."'";
		mysql_query($query_update_repeat_class);
		echo "<SCRIPT Language=javascript>";
		echo "window.alert('已更改類別".$e_class_repeat."為可重複借用!"."')";
		echo "</SCRIPT>";
		BackToIndexPage();
	}
	if(!is_null(@$_POST["e_overday_noon"])){
		$e_overday_noon = $_POST["e_overday_noon"];
		$query_update_e_overday_noon = "UPDATE `test`.`setting` SET `enable_overday` = 1 WHERE `setting`.`e_class` = '".$e_overday_noon."'";
		if(mysql_query($query_update_e_overday_noon)){
			echo "<SCRIPT Language=javascript>";
			echo "window.alert('已更改類別".$e_overday_noon."為可延借至隔天!"."')";
			echo "</SCRIPT>";
			BackToIndexPage();
		}else{
			echo mysql_error();
		}
		
	}
	function BackToIndexPage(){
		echo "<script language=\"javascript\">";
		echo "window.parent.window.location.href = \"./index.php\"";
		echo "</script>"; 
	}
?>
<script type="text/javascript">
	var parent_class = [];
	<?php
		if($query_run0 =  mysql_query($sql)){
			while($query_row0 = mysql_fetch_assoc($query_run0)) {
				echo 'parent_class["'.$query_row0['e_class'].'"] = "'.substr($query_row0['subcategory'],0,-1).'";';
			}
		}
	?>
	$('select[name=parent_class_d]').change(function(){
		var parent = $("option:selected",this).text();
		var array = parent_class[parent].split(";");

		var childhtml = '';
		for(var i=0;i<array.length;i++){
			childhtml+='<option>'+array[i]+'</option>';
		}
		$('select[name=child_class_d]').html(childhtml);
	});
	$('select[name=parent_class_n]').change(function(){
		var parent = $("option:selected",this).text();
		var array = parent_class[parent].split(";");

		var childhtml = '';
		for(var i=0;i<array.length;i++){
			childhtml+='<option>'+array[i]+'</option>';
		}
		$('select[name=child_class_n]').html(childhtml);
	});
	<?php
		// $sql5 = "SELECT `e_class` FROM `setting` WHERE `subcategory` NOT IN (SELECT `subcategory` FROM `setting`) OR `subcategory` IS NULL";
		// if($query_run =  mysql_query($sql5)){
		// 	while ($query_row = mysql_fetch_assoc($query_run)) {
		// 		$child_option = $child_option.'<option value="'.$query_row['e_class'].'">'.$query_row['e_class'].'</option>';
		// 	}
		// }
		// echo $child_option;
	?>
</script>