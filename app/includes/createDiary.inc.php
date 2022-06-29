<?php   
session_start();
include("db-functions.inc.php");

createDiary($_SESSION["user_id"], $_POST["diaryName"]);

?>