<?php
	mysql_connect('localhost:8889','root','root')
	or die("無法開啟Mysql資料庫連結");
	mysql_query("SET NAMES `UTF8`");
	mysql_select_db('itlab');
?>
