<?php 
session_start();
include_once("db-functions.inc.php");

if (isset($_POST["action"])){
    $action= $_POST["action"];
    $user_id = $_SESSION["user_id"];
    switch ($action){
        case "dateExists":
            $out= dateExists($_SESSION["user_id"],$_POST["date"]);
            echo $out;
            break;
        
        case "getDiaryData":
            $out= getDiaryData($_SESSION["user_id"],$_POST["date"],$_POST["selectedDiary"]);
            echo $out;
            break;

        case "editDiaryData":
            $out= editDiaryData($_SESSION["user_id"],$_POST["date"],$_POST["selectedDiary"],$_POST["data"]);
            echo $out;
            break;
        case "deleteDiaryData":
            $out= deleteDiaryData($_SESSION["user_id"],$_POST["date"]);
            echo $out;
            break;
        case "writeDiaries":
            $out = writeDiaries($_SESSION["user_id"],$_POST["date"],$_POST["selectedDiaries"],$_POST["data"]);
            echo $out;
            break;
        
        default:
            echo "error Coudn't find action in ajax.inc.php action name is ".$action;
            break;
    }
}


?>