<?php
session_start();
include_once("db.inc.php");


$sql="INSERT INTO diary_names (user_id, diary_name_id, diary_name) VALUES ($_SESSION[user_id], 0, '$_POST[diary_name]')";
echo $sql;

$output;
try{$output = $conn->query($sql);}
catch(Exception $e){
    header("Location: /createFirstDiary.php?error=" . $e->getMessage());
}
if(!$output){
    header("Location: /createFirstDiary.php?error=".$conn->errno);
    exit();
}else{
    header("Location: /index.php");
}

?>