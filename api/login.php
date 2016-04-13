<?php
include "../util/sqlcon.php";
$method = $_SERVER["REQUEST_METHOD"];
switch($method){
    case "GET":       
        $uri = explode("/", substr(@$_SERVER["REQUEST_URI"], 1));
        $url = "http://".$_SERVER["SERVER_NAME"]."/".$uri[0]."/index.html";   
        header("Location: ".$url);
        exit;   
    break;
    
    case "POST":  
        $json = file_get_contents("php://input");
        $obj = json_decode($json);    
        $uname = $obj->uname;
        $pw = $obj->password; 
        $cookie = $obj->remember;
    

        $sql = "SELECT password,type FROM member WHERE username = '$uname'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result); 
           if($row["password"]==$pw){
               session_start();
               $_SESSION["username"] = $uname;
               $_SESSION["usertype"] = $row['type'];
               if($cookie==true){
                   setcookie("username", $uname, time() + (86400 * 30), "/");
                   setcookie("usertype", $type, time() + (86400*30), "/");
               }
               echo "true";               
           }else{
               echo "false";
         }  
         mysqli_close($conn);
    break;
    }
?>