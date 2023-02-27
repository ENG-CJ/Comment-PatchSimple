<?php

include 'conn.php';


if(isset($_POST['insert'])){
    extract($_POST);
  
    $response=array();
    if(empty($name) || empty($comment)){
        $response=array("error"=>true,"message"=>"All Fileds Are erquired 🤔");
    }
    else{
        $sql = "INSERT INTO `comments`(`sender_name`, `comment`) VALUES ('$name','$comment');";
        $result = $conn->query($sql);
        if($result){
            $response=array("error"=>false,"message"=>"You're Commented Current Article😊");
    
        }else
        $response=array("error"=>true,"message"=>$conn->error);
    }
  

    echo json_encode($response);
}

if(isset($_POST['fetch'])){
  
    $response=array();
   
        $sql = "SELECT *FROM comments ORDER BY comment_id DESC LIMIT 0,1;";
        $result = $conn->query($sql);
        if($result){
            $rows=$result->fetch_all();
            $response=array("error"=>false,"response"=>$rows);
    
        }else
        $response=array("error"=>true,"message"=>$conn->error);
  
  

    echo json_encode($response);
}
?>