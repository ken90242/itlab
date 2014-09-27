
<style type="text/css">
	tr,td{
		padding:3px;
	}
</style>

<form action="" method="POST">
	<strong><label><借用物品數量></label></strong>
	<br>
	<label>選擇年分:</label>
	<select name="year" onchange='this.form.submit()'>
		<option>2014</option>
	</select>
	<label>選擇月份:</label>
	<select name="month" onchange='this.form.submit()'>
		<option>01</option>
		<option>02</option>
		<option>03</option>
		<option>04</option>
		<option>05</option>
		<option>06</option>
		<option>07</option>
		<option>08</option>
		<option>09</option>
		<option>10</option>
		<option>11</option>
		<option>12</option>
	</select>
</form>
<!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
	["Element", "Density", { role: "style" } ],
        ["Copper", 8.94, "#b87333"],
	["Silver", 10.49, "silver"],
	["Gold", 19.30, "gold"],
	["Platinum", 21.45, "color: #e5e4e2"],
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
	title: "Density of Precious Metals, in g/cm^3",
	width: 600,
	height: 400,
	bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="barchart_values" style="width: 900px; height: 300px;"></div> -->


<?php
require '../connect_database.php';
// $sql2 = "SELECT * FROM `trade_analyze` WHERE 1";
// if($query_run =  mysql_query($sql2)){
// 	if (mysql_num_rows($query_run) == NULL) {
// 		echo 'Search Nothing!';
// 	}
// 	else{
// 		while ($query_row = mysql_fetch_assoc($query_run)) {
// 			$query_row[ 'sequence' ]
// 			echo 
// 		}
// 	}
// }




if (isset($_POST['month'])) {
	$cross_total_arr = array();
	$horizonal_arr = array();

	$month = $_POST['month'];
	$hr_bginblock = '09';
	$hr_endblock = '22';

	echo '<font color="red">'.$month.'</font>月份';
	$sql3 = "SELECT count(1) FROM `trade_analyze` WHERE `trade_analyze`.`t_borrow_month_block`='$month'";
	$result_count3 = mysql_query($sql3);
	echo '<br>';	
	echo '<table style="float:left;" border="1" cellspacing="1" style="text-align:center;">';
	echo '<tr>';
			echo '<td></td>';
			for($i=$hr_bginblock;$i<=$hr_endblock;$i++){
				$j = $i+1;
				echo '<td>'.$i.'-'.$j.'</td>';
			}
			echo '<td>總和</td>';
		echo '</tr>';	
	for ($weekdy=1;$weekdy<=7;$weekdy++) { 
		echo '<tr>';
			$total=0;
			echo '<td>星期'.$weekdy.'</td>';
			for($i=$hr_bginblock;$i<=$hr_endblock;$i++){
				$sql2 = "SELECT count(1) FROM `trade_analyze` WHERE `trade_analyze`.`t_borrow_month_block`='$month' AND `t_borrow_week_day`='$weekdy' AND`t_borrow_time_block`='$i'";
				$result_count2 = mysql_query($sql2);
				echo '<td>'.mysql_result($result_count2, 0).'</td>';
				$total+= mysql_result($result_count2, 0);
				if(!isset($horizonal_arr[$weekdy])){
					$horizonal_arr[$weekdy]=0;
				}
				$horizonal_arr[$weekdy]+=mysql_result($result_count2, 0);

				if(!isset($cross_total_arr[$i])){
					$cross_total_arr[$i]=0;
				}
				$cross_total_arr[$i] += mysql_result($result_count2, 0);
			}
			echo '<td>'.$total.'</td>';
		echo '<tr>';	
	}
	echo '<tr>';
		echo '<td>總和</td>';
		for($i=$hr_bginblock;$i<=$hr_endblock;$i++){
			echo '<td>'.$cross_total_arr[$i].'</td>';
		}
		echo '<td>'.mysql_result($result_count3, 0).'</td>';
	echo '</tr>';
	echo '</table>';
	echo '<img src="http://chart.apis.google.com/chart?cht=bhs&chs=800x233&chd=t:'.$horizonal_arr['1'].','.$horizonal_arr['2'].','.$horizonal_arr['3'].','.$horizonal_arr['4'].','.$horizonal_arr['5'].','.$horizonal_arr['6'].','.$horizonal_arr['7'].'&chxt=y,x&chxl=0:|Sun|Sat|Fri|Thu|Wed|Tue|Mon&chg=10,20&chm=N*f0*,000000,0,-1,11">';
	echo '<img src="http://chart.apis.google.com/chart?cht=bvg&chs=800x300&chd=t:'.$cross_total_arr['09'].','.$cross_total_arr['10'].','.$cross_total_arr['11'].','.$cross_total_arr['12'].','.$cross_total_arr['13'].','.$cross_total_arr['14'].','.$cross_total_arr['15'].','.$cross_total_arr['16'].','.$cross_total_arr['17'].','.$cross_total_arr['18'].','.$cross_total_arr['19'].','.$cross_total_arr['20'].','.$cross_total_arr['21'].','.$cross_total_arr['22'].'&chxt=x,y&chxl=0:|09-10|10-11|11-12|12-13|13-14|14-15|15-16|16-17|17-18|18-19|19-20|20-21|21-22|22-23&chg=10,20&chm=N*f0*,000000,0,-1,11">';
}	
?>