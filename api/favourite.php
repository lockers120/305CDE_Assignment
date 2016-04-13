<?php
    include "../util/sqlcon.php";
    include "../util/session.php";
    $method = $_SERVER['REQUEST_METHOD'];

    switch($method){
        case 'GET': //If get the favourite list
            $uname = $_SESSION['username'];
            $sql = "SELECT * FROM favourite WHERE username = '$uname'";
            $result = mysqli_query($conn, $sql);
            $favouritelist =  array();
            while($row = mysqli_fetch_array($result)){   
                $rows =  array("dname" => $row[1]); 
                array_push($favouritelist, $rows);
            }
            echo json_encode($favouritelist);  
            mysqli_close($conn);
            break;
            
        case "POST":
            $obj = json_decode(file_get_contents('php://input'));    
            $uname = $_SESSION['username'];
            $dname = $obj->dname;
                        
            $sql = "insert into favourite values ('$uname', '$dname')";
            if(mysqli_query($conn, $sql)){
                echo "true";
            }else{
                die ('Some Error!' . mysql_error());		
            }
            mysqli_close($conn);
            break;
            
        case "PUT":
            break;
            
        case "DELETE":
            $obj = json_decode(file_get_contents('php://input'));
            $dname = $obj->dname;
            
            $sql = "DELETE FROM favourite WHERE drugname = '$dname'";
            if(mysqli_query($conn, $sql)){
                echo "true";
            }else{
                die ('Some Error!' . mysql_error());		
            }
            mysqli_close($conn);
            break;
    }
?>