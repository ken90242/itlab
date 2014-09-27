<?php
  session_start();
  // remove the div where equipment is going to be borrowed or returned
  $q=$_GET["q"];
  $_SESSION[$q] = "";
  $_SESSION['counts']=$_SESSION['counts']+$_SESSION['one'];
  echo "<SCRIPT Language=javascript>";
	echo "window.alert('移除".$q."中ㄏㄏ')";
	echo "</SCRIPT>";
?>