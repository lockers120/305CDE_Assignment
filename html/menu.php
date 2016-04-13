
<html>
<head>
    <?php
    $uri = explode("/", substr(@$_SERVER["REQUEST_URI"], 1));
    $url = "/".$uri[0]."/";   
    echo '<link rel=stylesheet type="text/css" href="'.$url.'css/style.css">';
    ?>
</head>
<body>
    <div id="menu">
    <?php
        require_once("../util/session.php");
        $uri = explode("/", substr(@$_SERVER["REQUEST_URI"], 1));
        $url = "/".$uri[0]."/";   
        echo "<a href='".$url."index.html' rel='external'>HOME<a> | " ;
        if(isset($_SESSION["username"])){
              if($_SESSION['usertype'] == "admin"){ 
                 echo "<a href='".$url."register.html'>Register</a> | ";
            }
            echo "Welcome, ".$_SESSION["username"]."<br>";           
            echo "<a href='".$url."favourite.html' rel='external'>My favourite</a> | ";
            echo "<a href='".$url."logout.html'>Logout</a>";
        }else{
            echo "Welcome, Guest <br>";
            echo "<a href='".$url."register.html' rel='external'>Register</a> | <a href='".$url."login.html' rel='external'>Login</a>";
        }
    ?>
    </div>
    <hr>
</body>
</html>


