<?php
    include "../util/sqlcon.php";
    include "../util/session.php";
    
    $method = $_SERVER['REQUEST_METHOD'];
    
    
    //Check the duplicate
    function checkDup($username, $conn){
        $sql = "SELECT username FROM member WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)==0){
            return true;
        }else{
            return false;
        }
    }
    
    switch($method){
    case "GET":
    $request = explode("/", substr(@$_SERVER['REQUEST_URI'], 1));
    $bool = checkDup($request[3], $conn);
    mysqli_close($conn);
    echo $bool ? 'true' : 'false'; 
    break;
    
    case "POST":  
    $json = file_get_contents('php://input');
    $obj = json_decode($json);    
    $uname = $obj->uname;
    $pw = $obj->pw;
    $mail = $obj->mail;
    $type = '' ;
    if(!isset($_SESSION['usertype'])){
        $type = 'member';
    }else{
        $type = $obj->type;
    }
           
    //Create a record
    $sql = "insert into member values ('$uname', '$pw', '$mail', '$type')";
    if(checkDup($uname, $conn)){
        if(mysqli_query($conn, $sql)){
            echo "true";
        }else{
            die ('Some Error!' . mysql_error());		
        }
    }else{
        echo "false";
    }
    mysqli_close($conn);
        break;
    }




?>