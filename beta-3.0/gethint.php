<?php
require './connect_database.php';
// a query which needs user's ID 
$query = "SELECT `id` FROM user ORDER BY  `user`.`id` ASC";
$query_run = mysql_query($query);
while($row = mysql_fetch_array($query_run)){
  $b[] = array_shift($row); 
}

//get user's ID from equipment_id_judge_multi.php
$q=$_GET["q"];
$q = id_correct($q);

//look up and grab user name by user ID from user table if length of q>0
if (strlen($q) > 0){
  $hint="";
  for($i=0; $i<count($b); $i++){
    if ($q==$b[$i]) {
      $query = "SELECT `name` FROM user WHERE `user`.`id`='".$b[$i]."' ORDER BY  `user`.`id` ASC";
      $query_run = mysql_query($query);
      $query_row = mysql_fetch_assoc($query_run);
      if ($hint==""){
        $hint=  $query_row[ 'name' ] ;
      }
      else{
        $hint=$hint." , ".$query_row[ 'name' ];
      }
    }
  }
}

//check the whether the hint exists(whether user ID exists in user table)
if ($hint == ""){
  $response="No such person!";
}
else{
  $response=$hint;
}

//output the response
echo $response;

function id_correct($id_search){ //unify the ID format and ID debug
    if(preg_match('/^(1)\d{8}$/',$id_search)){
        $id_search = $id_search;
    }
    elseif (preg_match('/^(1)\d{9}$/',$id_search)){
      $id_search = substr($id_search,0,9);
    }
    elseif(preg_match('/^(00)\d{6}$/',$id_search)){
      $id_search = substr('0'.$id_search,0,9);
    }
    elseif(preg_match('/^(00)\d{7}$/',$id_search)){
      $id_search = substr('0'.$id_search,0,9);
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
?>