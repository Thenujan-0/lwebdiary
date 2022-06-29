<?php
    include_once("db.inc.php");

    function getDiaries($user_id){
        global $conn;
        $sql = "SELECT diary_name FROM diary_names WHERE user_id = $user_id";
        $result=$conn->query($sql);
        $diaries = array();
        while($row= $result->fetch_array()){
            array_push($diaries, $row['diary_name']);
        }
        return $diaries;
    }

    function writeDiaries($user_id,$date,$selectedDiaries, $data){
        global $conn;
        $data1=addslashes($data);

        foreach($selectedDiaries as $selectedDiary){
            $sql1="SELECT diary_name_id FROM diary_names WHERE diary_name = '$selectedDiary' AND user_id = $user_id";
            $result1=$conn->query($sql1);
            $diaryNameId=$result1->fetch_array()["diary_name_id"];
            $sql="INSERT INTO diary (user_id, date , diary_name_id, data) VALUES ($user_id, '$date', $diaryNameId, '$data1')";
            $result=$conn->query($sql);
            if($result){
                echo "true";
            }else{
                echo "false";
            }

        }

        global $coll;
    }

    function dateExists($user_id,$date){
        global $conn;
        $sql="SELECT * FROM diary WHERE user_id = $user_id AND date = '$date'";
        $result=$conn->query($sql);
        if($result->num_rows > 0){
            echo "true";
        } else { 
            echo "false";
        }

    }

    function getDates($user_id){
        global $conn;
        $sql="SELECT DISTINCT date FROM diary WHERE user_id = $user_id 
        ORDER BY date DESC";
        $result=$conn->query($sql);
        $dates = array();
        while($row= $result->fetch_array()){
            array_push($dates, $row['date']);
        }
        return $dates;
    }

    function getDiaryData($user_id,$date,$selectedDiary){
        global $conn;
        // echo $date;
        // echo $user_id;
        // echo $selectedDiary;
        $sql="SELECT diary_name_id FROM diary_names WHERE user_id = $user_id AND diary_name = '$selectedDiary'";
        $result=$conn->query($sql);
        $diaryNameId = $result->fetch_array()["diary_name_id"];
        // echo "$diaryNameId";
        $sql1="SELECT data FROM diary WHERE user_id = $user_id AND date = '$date' AND diary_name_id = $diaryNameId";
        $result1=$conn->query($sql1);

        $data = $result1->fetch_array()["data"];
        return $data;   
    }


    function editDiaryData($user_id,$date,$selectedDiary,$data){
        global $conn;
        echo "yes";
        $data1=addslashes($data);
        $sql="SELECT diary_name_id FROM diary_names WHERE user_id = $user_id AND diary_name = '$selectedDiary'";
        $result=$conn->query($sql);
        $diaryNameId = $result->fetch_array()["diary_name_id"];
        $sql1="UPDATE diary SET data = '$data1' WHERE user_id = $user_id AND date = '$date' AND diary_name_id = $diaryNameId";
        $result1=$conn->query($sql1);
        return $result1;
    }


    function deleteDiaryData($user_id,$date){
        global $conn;
        $sql="DELETE FROM diary WHERE user_id = $user_id AND date = '$date'";
        $result=$conn->query($sql);
        return $result;
    }


    function createDiary($user_id,$diaryName){
        
        if($diaryName==""){
            return "DiaryName is empty";
        }
        
        global $conn;

        //Find last diary Id
        $sql1="SELECT MAX(diary_name_id) FROM diary_names";
        $result1=$conn->query($sql1);
        $diaryNameId=$result1->fetch_array()["MAX(diary_name_id)"];
        echo $diaryNameId;

        $diaryNameId= intval($diaryNameId)+1;

        $sql="INSERT INTO diary_names (user_id, diary_name_id, diary_name) VALUES ($user_id, $diaryNameId, '$diaryName')";
        echo $sql;
        $result=$conn->query($sql);
        return $result;
    }

?>