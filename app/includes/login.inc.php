<?php session_start();?>

<?php 

if (isset($_POST["submit"])){

    include_once("db.inc.php");

    $email=$_POST["email"];
    if(!empty($email)){
        //Remember cookie for a month
        setcookie("email",$email,time()+2592000,"/");
    }
    $password=hash("sha256",$_POST["password"]);

    $sql="SELECT user_id, username FROM users WHERE email='$email' AND password_sha256='$password'";

    $output=$conn->query($sql);

    if(!$output){
        header("Location: /login.php?error=queryFailed");
        exit();
    }

    $row=$output->fetch_array();
    if (empty($row)){
        header("Location: /login.php?error=invalid_credentials");
        exit();
    }

    echo $row['username'];
    $_SESSION["username"]=$row['username'];
    $_SESSION["user_id"]=$row['user_id'];
    $_SESSION["user_id_mongodb"]=$row['user_id'];

    echo $_SESSION["username"];
    echo $_SESSION["user_id"];

    $sql="SELECT * FROM diary_names WHERE user_id='$row[user_id]'";
    $output=$conn->query($sql);

    // $cursor = $coll->find(["email" => $email]);
    
    // foreach($cursor as $doc){
    //     echo $doc['username'];
    // }

    
    if(!$output){
        header("Location: /login.php?error=queryFailed");
        exit();
    }

    $row=$output->fetch_array();

    if(empty($row)){
        header("Location: /createFirstDiary.php");
        exit();
    }

    header("Location: /index.php");
    exit();

    

    
}else{
    echo "not submitted";
    header("Location: /login.php?error=notSubmittedInternalError");
    exit();
}


?>