<?php
    include "../util/sqlcon.php";
    require("../util/session.php");
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch($method){
        case "GET":
         $request = explode("/", substr(@$_SERVER['REQUEST_URI'], 1));
         $username = $request[3];
         if($username==null){
           echo "This api is use to show specified user detail...";
         }else{
            $sql = "SELECT * FROM member WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            $userlist =  array();
            $row = mysqli_fetch_array($result);   
            $userlist =  array("username" => $row[0],
                                         "mail" => $row[2]);
            echo json_encode($userlist);       
         }
         break;
         
         case "PUT":
         $action = "";
         $username = $_SESSION["username"];
         $data = json_decode(file_get_contents("php://input"));
         if($data->action=="password"){
             $action = "password";
         }else if($data->action=="email"){
             $action = "email";
         }
         $sql = "UPDATE Member SET $action = '$data->value' WHERE username = '$username'";
         $result = mysqli_query($conn, $sql);
         if($result==true){
             echo $action." is changed!";
         }
         
         case 'DELETE': //If to delete a user.
            break;
        
    }
  
    
?>