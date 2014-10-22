<?php
require './connect_database.php';
header("Content-Type:text/html; charset=utf-8");
//look up and grab user name by user ID from user table if length of q>0
if(isset($_GET["q"])){
  $query = "SELECT `id` FROM `user` ORDER BY `user`.`id` ASC";
  $query_run = mysql_query($query);
  while($row = mysql_fetch_assoc($query_run)){
    $b[] = $row["id"]; 
  }


  $q=$_GET["q"];
  $q=id_correct($q);
  if (strlen($q) > 0){
    $hint="找不到使用者[".$q."]";
    for($i=0; $i<count($b); $i++){
      if($q==$b[$i]) {
        $query_1 = "SELECT `name` FROM `user` WHERE `user`.`id`='".$b[$i]."' ORDER BY  `user`.`id` ASC LIMIT 1";
        $query_run_1 = mysql_query($query_1);
        $query_row_1 = mysql_fetch_assoc($query_run_1);

        if(isset($query_row_1[ 'name' ])){
          $hint=$query_row_1[ 'name' ] ;
        }
      }
    }
  }
  //output the response
  echo $hint;
}

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
    return $id_search;
  }
?>