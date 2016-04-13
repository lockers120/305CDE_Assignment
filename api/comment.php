<?php
    include "../util/sqlcon.php";
    include "../util/session.php";
    $method = $_SERVER['REQUEST_METHOD'];

    switch($method){
        case 'GET': //If the request is specified a drug, return a drug fulfill the name.
            $uri = explode("/", substr(@$_SERVER["REQUEST_URI"], 1));
            $sql = "SELECT * FROM comment WHERE drugname = '$uri[3]'";
            $result = mysqli_query($conn, $sql);
            $owner = false;
            $cmlist =  array();
            while($row = mysqli_fetch_array($result)){  
                if(isset($_SESSION['username'])){ 
                    if($_SESSION['username']==$row[1]  || $_SESSION['usertype']=='admin'){
                        $owner = true;
                    }
                }
                $rows =  array("uname" => $row[1],
                               "dname" => $row[2],
                               "comment" => $row[3],
                               "time" => $row[4],
                               "id" => $row[0],
                               "owner" => $owner); 
                array_push($cmlist, $rows);
            }
            echo json_encode($cmlist);  
            mysqli_close($conn);
            break;
            
        case 'POST': //If create a new record
            $obj = json_decode(file_get_contents('php://input'));    
            $uname = $_SESSION['username'];
            $dname = $obj->dname;
            $cm = $obj->comment;
                        
            $sql = "insert into comment(username, drugname, comment) values ('$uname', '$dname', '$cm')";
            if(mysqli_query($conn, $sql)){
                echo "true";
            }else{
                die ('Some Error!' . mysql_error());		
            }
            mysqli_close($conn);
            break;
        case 'PUT': //If update a record
            $obj = json_decode(file_get_contents('php://input'));
            $cmid = $obj->id;
            $cm = $obj->cm;
            
            $sql = "UPDATE comment SET comment = '$cm' WHERE cmid = '$cmid'";
            if(mysqli_query($conn, $sql)){
                echo "true";
            }else{
                die ('Some Error!' . mysql_error());		
            }
            mysqli_close($conn);
        
            break;
        case 'DELETE': //If delete a record
            $obj = json_decode(file_get_contents('php://input'));
            $cmid = $obj->id;
            
            $sql = "DELETE FROM comment WHERE cmid = '$cmid'";
            if(mysqli_query($conn, $sql)){
                echo "true";
            }else{
                die ('Some Error!' . mysql_error());		
            }
            mysqli_close($conn);
            break;
            
    }
?>