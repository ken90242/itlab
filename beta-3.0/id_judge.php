<?php 
	session_start();
	ob_start();
	require 'connect_database.php';
	if ($_POST) {
        $id_search =  id_correct($_POST["id_search"]);
		$query = "SELECT * FROM `user` WHERE `id`='$id_search'";

		if($query_run =  mysql_query($query)){   /*Let user insert user data if id doesnt exist*/
			if (mysql_num_rows($query_run) == NULL) {
				$_SESSION['id_pre'] = $id_search;
				email_correct($id_search); 
				
				echo '<script type="text/javascript">';
   				echo 'var str = "<form id=\"form2\" action=\"user_insert_2.php\" method=\"POST\"><img id=\"laser2\" src=\"img/laser.png\"/><input type=\"text\" name=\"insert_user_id\" placeholder=\"輸入學號\" onchange=\"checkValue()\" value=\"'.$_SESSION['id_pre'].'\"><br><input type=\"text\" id=\"insert_user_name\" placeholder=\"輸入姓名\" name=\"insert_user_name\" onchange=\"checkValue()\"><br><select name=\"insert_user_department\" placeholder=\"輸入系所\" onchange=\"checkValue()\"><option>新聞系</option><option>廣告系</option><option>廣電系</option><option>新聞所</option><option>廣告所</option><option>廣電所</option><option>數位內容學士學程</option><option>國際傳播學士學程</option><option>傳播學士學位學程</option><option>資管系</option><option>資科系</option><option>哲學系</option><option>政治系</option><option>法律系</option><option>經濟系</option><option>會計系</option><option>教育系</option><option>外交系</option><option>中文系</option><option>英文系</option><option>日文系</option><option>韓文系</option><option>阿語系</option><option>斯語系</option></select><br><input type=\"text\" name=\"insert_user_email\" placeholder=\"輸入email\" onchange=\"checkValue()\" value=\"'.$_SESSION['email_pre'].'\"><br><input type=\"text\" name=\"insert_user_phone\" placeholder=\"輸入電話\" onchange=\"checkValue()\"><br><input type=\"submit\" value=\"\" id=\"submit2\" ><br><img id=\"laser2\" src=\"img/laser.png\"/></form><input  id=\"form2to1\" value=\"回首頁\" type=\"button\" onClick=\"window.location=\'index.php\'\">";';
				echo "window.parent.document.getElementById('changeside').innerHTML = str;";
   				echo '</script>';
	    		
				//header('Location: ./user_insert_1.php');

			}else{ /*Let user go in main_menu if id exist*/
				while ($query_row = mysql_fetch_assoc($query_run)) {
					$_SESSION['id']=  $query_row[ 'id' ] ;
					$_SESSION['name'] = $query_row[ 'name' ];
					$_SESSION['department'] = $query_row[ 'department' ];
					$_SESSION['email'] = $query_row[ 'email' ];
					$_SESSION['phone'] = $query_row[ 'phone' ];
					echo "<script language=\"javascript\">";
			   	 	echo "window.parent.window.location.href = \"./main_menu.php\";";
			    	echo "</script>"; 
				}
			}
		}else{
			echo mysql_error();
		}
	}
	ob_end_flush();

	function id_correct($id_search){ //unify the ID format and ID debug
		if(preg_match('/^(1)\d{8}$/',$id_search)){
		    $id_search = $id_search;
		}
		elseif(preg_match('/^(00)\d{6}$/',$id_search)){
			$id_search = substr('0'.$id_search,0,9);
		}
		elseif(preg_match('/^(00)\d{7}$/',$id_search)){
			$id_search = substr('0'.$id_search,0,9);
		}
		elseif (preg_match('/^(1)\d{9}$/',$id_search)){
			$id_search = substr($id_search,0,9);
		}
		elseif (preg_match('/^(9)\d{7}$/',$id_search)){
			$id_search = '0'.$id_search;
		}
		elseif (preg_match('/^(9)\d{8}$/',$id_search)){
			$id_search = substr('0'.$id_search,0,9);
		}
		elseif(($id_search == '1152542')|| ($id_search == '01152542')){
		   $id_search = '1152542';
		}
		else{
			echo "<SCRIPT Language=javascript>";
    		echo "window.alert('NOT formal informat!(9xxxxxxx(x)/1xxxxxxxx(x))')";
    		echo "</SCRIPT>";
	    	echo "<script language=\"javascript\">";
	   	 	echo "window.parent.window.location.href = \"./index.php\"";
	    	echo "</script>"; 
			
	    	exit;
		}
		return $id_search;
	}
	// unify email format(add @nccu.edu.tw behind student ID)
	function email_correct($id_search){
		if(preg_match('/^(1)\d{8}$/',$id_search)){
			$_SESSION['email_pre'] = $id_search.'@nccu.edu.tw';
		}
		elseif (preg_match('/^(0)\d{8}$/',$id_search)){
			$_SESSION['email_pre'] = substr($id_search,1,9).'@nccu.edu.tw';
		}	
	}
	
	
?>
       



<!-- judge id exist or not -->