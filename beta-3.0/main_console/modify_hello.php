<?php
//CONVERT(`equipment`.`id` USING utf8)
require '../connect_database.php';
$q=$_GET["q"];

$NewString1 = preg_split("/[,]+/",$q);
$id = $NewString1[0];
$name = $NewString1[1];
$department = $NewString1[2];
$email = $NewString1[3];
$phone = $NewString1[4];
$ori_id = $NewString1[5];
$black_or_not = $NewString1[6];

$update_user_query = "UPDATE `test`.`user` SET `id` = '".$id."' , `name` =  '".$name."' , `department` =  '".$department."' , `email` = '".$email."' ,
`phone` = '".$phone."' WHERE `user`.`id` = '".$ori_id."' LIMIT 1 ;";
mysql_query($update_user_query);
echo '<tr>';
echo '<td style="border-style:solid;border-width:1px; width:100px;float:left">';
echo $id;
echo '</td>';
echo '<td style="border-style:solid;border-width:1px; width:100px;float:left">';
echo $name;
echo '</td>';
echo '<td style="border-style:solid;border-width:1px; width:200px;float:left">';
echo $department;
echo '</td>';
echo '<td style="border-style:solid;border-width:1px; width:200px;float:left">';
echo $email;
echo '</td>';
echo '<td style="border-style:solid;border-width:1px; width:100px;float:left">';
echo $phone;
echo '</td>';
echo '<td><input type="button" value="修改" onclick="modify(\''.$id.'\',\''.$name.'\',\''.$department.'\',\''.$email.'\',\''.$phone.'\');"></td>';
echo '<td><input type="button" value="刪除" onclick="removde(\''.$id.'\');"></td>';
if($black_or_not =="black_no"){
	echo '<td><input type="button" id="black_'.$id.'" value="取消黑名單" onclick="blackbody(\''.$id.'\',\''.$name.'\',\''.$department.'\',\''.$email.'\',\''.$phone.'\');"></td>';
}else if($black_or_not =="black_yes"){
	echo '<td><input type="button" id="black_'.$id.'" value="黑名單" onclick="blackbody(\''.$id.'\',\''.$name.'\',\''.$department.'\',\''.$email.'\',\''.$phone.'\');"></td>';	
}else{
	echo "modify_hello.php ERRoR!";
}
echo '</tr>';
?>