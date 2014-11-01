<?php
  	session_start();
  	// remove the div where equipment is going to be borrowed or returned
  	$q = $_GET["q"];
  	$_SESSION[$q] = "";
  	echo '移除'.$q.'中';
?>