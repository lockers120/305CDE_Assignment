<?php
    session_start();
        
    if(isset($_COOKIE['username'])){
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['usertype'] = $_COOKIE['usertype'];
    }
   
  
    function redirect(){
        if(isset($_SESSION['username'])&&($_SESSION['usertype']!="admin")){
            header('Location: index.html');
        }
    }
    
    function isLoggedIn(){
        if(!isset($_SESSION['username'])){
            $uri = explode("/", substr(@$_SERVER["REQUEST_URI"], 1));
            $url = "/".$uri[0]."/";   
            header('Location: '.$url.'login.html');
            die;
        }
    }
    
    function getSession(){
        if(isset($_SESSION['username'])){
            $rows =  array("name" => $_SESSION['username'],
                                    "type" =>$_SESSION['usertype']);
            echo JSON_encode($rows);
        }else{
            $rows = array();
            echo json_encode($rows);
        }
    }
    
    function logout(){
         if(isset($_SESSION['username'])){
            session_unset();
            session_destroy();
            if(isset($_COOKIE["username"])){
                unset($_COOKIE["username"]);
                unset($_COOKIE['usertype']);
                setcookie('username', '', time() - 3600, '/');
                setcookie('usertype', '', time() - 3600, '/');
            }
            echo "Logged Out!";
        }else{
           
        }
      }
      
    
    
    if(isset($_GET['function'])){
        $action = $_GET['function'];
        if($action=="getsession"){
            getSession();
        }else if($action=="logout"){
            logout();
        }
    }
    
    
?>