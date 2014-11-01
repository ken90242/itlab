<?php
  	session_start();
  	// remove the div where equipment is going to be borrowed or returned
  	$q = $_GET["q"];
  	$_SESSION[$q] = "";
  	echo '執行動作:移除'.$q.'及其子類別';
?>