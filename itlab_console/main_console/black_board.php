<?php
session_start();
require '../connect_database.php';


if(isset($_POST["txtara"]) ) {
	if(trim($_POST["txtara"])==""){
		echo "<script language=\"javascript\">";
		echo "window.location.href = \"./black_board.php\"";
		echo "</script>"; 
	}else{
		$opinion = trim($_POST["txtara"]);
		$insert_query = "INSERT INTO  `test`.`testing` (`opinion`) VALUES ('$opinion')";
		if(!mysql_query($insert_query)) {
			echo mysql_error();
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Gochi Hand">
	<title>Black board</title>
	<style type="text/css">
		/**
		  * Copyright (c) 2012-2013 Arbaoui Mehdi
		  * PSD : http://pixelsdaily.com/resources/photoshop/psds/sticky-notepaper-psd/
		  * http://www.depotwebdesigner.com
		  **/
		body {
			background:url('./background.jpg');
			/*font-family: "Gochi Hand";*/
			 font-family: "Helvetica Neue", Helvetica, Arial, "微軟正黑體", sans-serif;
		}

		a {
			text-decoration: none;
			font-weight: bold;
		}

		.btn {
			background-image: linear-gradient(bottom, rgb(112,87,65) 3%, rgb(163,136,102) 82%);
			background-image: -o-linear-gradient(bottom, rgb(112,87,65) 3%, rgb(163,136,102) 82%);
			background-image: -moz-linear-gradient(bottom, rgb(112,87,65) 3%, rgb(163,136,102) 82%);
			background-image: -webkit-linear-gradient(bottom, rgb(112,87,65) 3%, rgb(163,136,102) 82%);
			background-image: -ms-linear-gradient(bottom, rgb(112,87,65) 3%, rgb(163,136,102) 82%);
			background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0.03, rgb(112,87,65)),
			color-stop(0.82, rgb(163,136,102)));
			color:#4e3c2a;
			border-radius: 20px;
			padding:3px 17px;
			text-shadow:0 1px 0 #aa8863;
			border:1px solid #5d4d3a;
			font-size:18px;
			font-style: italic;
		}

		.note {	
			float: left;
			display:block;
			width:340px;
			height:440px;
			position:relative;
			margin:40px 0 0 20px;
		}

		.lines {
			position: absolute;
			width:100%;
			opacity: 0.6;
			top:36px;
		}

		.lines span { display: block; }

		.horizontal span {
			width:100%;
			height:1px;
		    background: linear-gradient(to right, rgba(236,231,191,1),rgba(211,206,167,1), rgba(236,231,191,1));
			background-image: -o-linear-gradient(right, rgba(236,231,191,1),rgba(211,206,167,1), rgba(236,231,191,1));
			background-image: -moz-linear-gradient(right, rgba(236,231,191,1),rgba(211,206,167,1), rgba(236,231,191,1));
			background-image: -webkit-linear-gradient(right, rgba(236,231,191,1),rgba(211,206,167,1), rgba(236,231,191,1));
			background-image: -ms-linear-gradient(right, rgba(236,231,191,1),rgba(211,206,167,1), rgba(236,231,191,1));
			margin-bottom:28px;
		}

		.vertical { margin:-239px 0 0 30px; }

		.vertical span {
			float:left;
			margin-right:5px;
			width:1px;
			height: 237px;
			background: linear-gradient(to bottom, rgba(236,231,191,1),rgba(211,206,167,1), rgba(236,231,191,1));
			background-image: -o-linear-gradient(bottom, rgba(236,231,191,1),rgba(211,206,167,1), rgba(236,231,191,1));
			background-image: -moz-linear-gradient(bottom, rgba(236,231,191,1),rgba(211,206,167,1), rgba(236,231,191,1));
			background-image: -webkit-linear-gradient(bottom, rgba(236,231,191,1),rgba(211,206,167,1), rgba(236,231,191,1));
			background-image: -ms-linear-gradient(bottom, rgba(236,231,191,1),rgba(211,206,167,1), rgba(236,231,191,1));
		}

		.sticky {
			background: repeat #f3efd1;
			width:100%;
			height: 100%;
			border:1px solid #f3f0d3;
			box-shadow: 1px 2px 4px -1px rgba(0,0,0,0.2);
			text-align: center;
		}

		.inner {
			height:100%;
			box-shadow: inset 0 0 22px 8px rgba(220,215,174,0.35);
			z-index:1;
		}

		.sticky .paper {
			position: absolute;
			line-height: 1.4em;
			font-size: 22px;
			color: #494949;
			padding: 43px 10px 0 37px;
			text-align: left;
		}
		.sticky .paper .english {
			font-family: "Gochi Hand";
		}

		.paper b {
			background:#fdfbf0;
			padding:0 5px;
			font-size:17px; 
		}

		.scratch {
			display:block;
			background-color:rgba(255,255,255,0.4);
			width:45%;
			height:33px;
			margin:-20px 0 0 28%;
			float:left;
			transform: rotate(-2deg);
			-ms-transform: rotate(-2deg); /* IE 9 */
			-webkit-transform: rotate(-2deg); /* Safari and Chrome */
			-o-transform: rotate(-2deg); /* Opera */
			-moz-transform: rotate(-2deg); /* Firefox */
			box-shadow: 1px 2px 2px -1px rgba(0, 0, 0, 0.1);
		}
	</style>
</head>
<body>
<div class="note">
	<div class="lines">
		<span class="horizontal">
			<span>I</span>
			<span>II</span>
			<span>III</span>
			<span>IV</span>
			<span>V</span>
			<span>VI</span>
			<span>VII</span>
			<span></span>
		</span>
		<span class="vertical">
			<span></span>
			<span></span>
		</span>
	</div>
	<div class="sticky">
		<div class="inner">
			<span class="scratch">用途(ex)</span>
			<div class="paper">
				<p>紀錄錯誤<br>功能改善<br>想加的功能<br>很酷的構想
				</p>
			</div>
		</div>
	</div>
</div>
<?php
$query = "SELECT * FROM  `testing`";
if($query_run =  mysql_query($query)){
	if(mysql_num_rows($query_run) != NULL){
		$num=1;
		while($query_row = mysql_fetch_assoc($query_run)){
			echo '<div class="note">
					<div class="lines">
						<span class="horizontal">
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
						</span>
						<span class="vertical">
							<span></span>
							<span></span>
						</span>
					</div>
					<div class="sticky">
						<div class="inner">
							<span class="scratch">Opinion'.$num.'</span>
							<div class="paper">
								<p>'.$query_row[ 'opinion' ].'</p>
							</div>
						</div>
					</div>
				</div>';
			$num=$num+1;
		}
	}
	else{
		echo mysql_error();
	}
}else{
	echo mysql_error();
}
?>
<div style="width:50%;height:30%">
	<form action="" method="POST" >
		<textarea style="margin-top:5%;width:300px;height:200px;" name="txtara"></textarea>
		<br>
		<input style="width:50%;height:30%" type="submit" value="Submit">	
	</form>
</div>
	

</body>
</html>

