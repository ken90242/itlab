<?php 	
	session_start();
	echo 
	'<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		</head>
		<body onload="document.getElementById(\'insert_user_name\').focus()">
			<form action="user_insert_2.php" method="POST">'; //head to user_insert_2.php
		echo '<label>輸入學號</label><input type="text" name="insert_user_id" onchange="checkValue()" value=',$_SESSION['id_pre'],'><br>';
		echo '<label>輸入姓名</label><input type="text" id="insert_user_name" name="insert_user_name" onchange="checkValue()"><br>';
		echo '<label>輸入系所</label><select name="insert_user_department" onchange="checkValue()">
 				<option>請選擇系所</option>
				<option>系所1</option>
 				<option>系所2</option>
 				<option>系所3</option>
			</select><br>';
		echo '<label>輸入email</label><input type="text" name="insert_user_email" onchange="checkValue()" value="',$_SESSION['email_pre'],'"><br>';
		echo '<label>輸入電話</label><input type="text" name="insert_user_phone" onchange="checkValue()"><br>';
		echo '<input type="submit" value="submit">';
		?>		
	</form>
</body>
</html>