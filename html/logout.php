<!DOCTYPE html>
<?php
    session_start();
    session_unset();
    session_destroy();
    if(isset($_COOKIE["username"])){
      unset($_COOKIE["username"]);
      unset($_COOKIE['usertype']);
      setcookie('username', '', time() - 3600, '/');
      setcookie('usertype', '', time() - 3600, '/');
    }
?>
<html>
<head>
<meta charset="utf-8">
<title>jQuery Mobile Web App</title>
<link href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" rel="stylesheet" type="text/css"/>
<script src="http://code.jquery.com/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js" type="text/javascript"></script>
</head> 
<body> 

<div data-role="page" id="page">
	<div data-role="header">
		<h1>You have logged out</h1>
	</div>
	<div data-role="content">	
		<ul data-role="listview">
        Now will rediect you to the front page.<br>
        <a href="index.html">Or you can go back by clicking here.</a>

		</ul>		
	</div>
	<div data-role="footer">
		<h4>305SDE Assignment</h4>
	</div>
</div>

</div>

</body>
</html>
