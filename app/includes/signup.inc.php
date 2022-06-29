<?php
    include_once("db.inc.php");

    if (isset($_POST["submit"])){

        $email=$_POST["email"];
        $password=hash("sha256",$_POST["password"]);
        $fullname=$_POST["fullname"];

        $sql="INSERT INTO users (username, email, password_sha256) VALUES ('$fullname', '$email', '$password')";

        if($conn->query($sql)){
            echo "Success";
        }else{
            echo "Failed";
        }
        
        $coll->insertOne([
            "username" => $fullname,
            "email" => $email,
            "password_sha256" => $password
        ]);


    }
?>