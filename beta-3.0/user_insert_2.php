<?php
	session_start();
	ob_start();
	require 'connect_database.php';
	if ($_POST) { //read the data from the form(clientside)
		$insert_user_id = $_POST["insert_user_id"];
		$insert_user_name = $_POST["insert_user_name"];
		$insert_user_department = $_POST["insert_user_department"];
		$insert_user_email = $_POST["insert_user_email"];
		$insert_user_phone = $_POST["insert_user_phone"];
		$insert_query = "INSERT INTO  `test`.`user` (`id` , `name` ,`department` ,`email` ,`phone`,`blacklisted`) 
		VALUES ('$insert_user_id' , '$insert_user_name', '$insert_user_department' , '$insert_user_email', '$insert_user_phone','n')";
		
		/*TO makesure insert user data into database when no blank space*/
		if(($query_run = mysql_query($insert_query))&&($insert_user_name!=NULL)&&
		($insert_user_department!=NULL)&&($insert_user_id!=NULL)&&($insert_user_email!=NULL)
		&&($insert_user_phone!=NULL)){							
			
			$query = "SELECT * FROM user WHERE `id`='$insert_user_id'"; /*Insert user data into database*/
			$query_run = mysql_query($query);
			$query_row = mysql_fetch_assoc($query_run);

			$_SESSION['id']=  $query_row[ 'id' ] ;
			$_SESSION['name'] = $query_row[ 'name' ];
			$_SESSION['department'] = $query_row[ 'department' ];
			$_SESSION['email'] = $query_row[ 'email' ];
			$_SESSION['phone'] = $query_row[ 'phone' ];
			header('Location: ./main_menu.php');
		}
		else{
			echo "<SCRIPT Language=javascript>";
			echo "window.alert('Maybe should fulfill the blank first.')";
			echo "</SCRIPT>";
			echo "<script language=\"javascript\">";
	   	 	echo "window.parent.window.location.href = \"./user_insert_1.php\"";
	    	echo "</script>"; 
			//echo mysql_error();   /*detect the reason why "insert user data error"*/
		}
		
	$insert_user_phone = $_POST["insert_user_phone"];	
	function phone_correct($insert_user_phone){ //debug phone number format(10numbers)
		if ( ! preg_match('/[0-9]{10}/', $insert_user_phone))
			{
			echo "<SCRIPT Language=javascript>";
			echo "window.alert('Input your phone number again')";
			echo "</SCRIPT>";
			echo "<script language=\"javascript\">";
	   	 	echo "window.parent.window.location.href = \"./user_insert_1.php\"";
	    	echo "</script>";
			} 	
		}
		
	}
?>