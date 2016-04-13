<?php
    include "../util/sqlcon.php";
    $method = $_SERVER['REQUEST_METHOD'];

    switch($method){
        case 'GET': //If the request is specified a drug, return a drug fulfill the name.
            $uri = explode("/", substr(@$_SERVER["REQUEST_URI"], 1));
            $sql = "SELECT * FROM drug WHERE drugname = '$uri[3]'";			
            $result = mysqli_query($conn, $sql);
            $druglist =  array();
            $row = mysqli_fetch_array($result);
            $rows =  array("name" => $row[0],
                            "desc" => $row[1]); 
            array_push($druglist, $rows);
            echo json_encode($druglist);  
            mysqli_close($conn);
            break;
        case 'POST': //If create a new record
            $obj = json_decode(file_get_contents('php://input'));    
            $name = $obj->name;
            $type = $obj->type;
            $desc = $obj->desc;
            
            $sql = "insert into drug values ('$name', '$type', '$desc')";
            if(mysqli_query($conn, $sql)){
            echo "true";
            }else{
                die ('Some Error!' . mysql_error());		
            }
           mysqli_close($conn);
            break;
        case 'PUT': //If update a record
            break;
        case 'DELETE': //If delete a record
            break;
            
    }
?>