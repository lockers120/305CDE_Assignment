<?php
    include "../util/sqlcon.php";
    $method = $_SERVER['REQUEST_METHOD'];

    switch($method){
        case "GET":  
        $uri = explode("/", substr(@$_SERVER["REQUEST_URI"], 1));
        if($uri[3]==null){  //If there is no specified, show all record
            $sql = "SELECT * FROM drug";
            $result = mysqli_query($conn, $sql);
            $druglist =  array();
            while($row = mysqli_fetch_array($result)){   
                $rows =  array("name" => $row[0],
                               "desc" => $row[1]); 
                array_push($druglist, $rows);
            }
         echo json_encode($druglist);         
        }else{
            $sql = "SELECT * FROM drug WHERE drugname LIKE '%$uri[3]%'";
            $result = mysqli_query($conn, $sql);
            $druglist =  array();
            while($row = mysqli_fetch_array($result)){   
                $rows =  array("name" => $row[0],
                               "desc" => $row[1]); 
                array_push($druglist, $rows);
            }
            echo json_encode($druglist);  
        }
    }; 













?>