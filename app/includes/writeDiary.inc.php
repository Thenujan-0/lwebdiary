<?php
session_start();

$user_id=$_SESSION["user_id"];
include_once("db.inc.php");
include_once("db-functions.inc.php");

$date =  $_POST["date"];
$selected = $_POST["selectedDiaries"];
$selectedDiaries = array_filter(explode("$$$$$", $selected));
$data = $_POST["data"];

if(count($selectedDiaries)==0){
    echo "noDiarySelected";
}


writeDiaries($user_id, $date,$selectedDiaries, $data);

?>