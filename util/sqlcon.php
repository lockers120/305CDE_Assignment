<?php

//Connect to Database server and select the database
	$hostname = "127.0.0.1";
	$username = "root";
	$password = "";
	$conn = mysqli_connect($hostname, $username, $password) or
	die ("Could not open connection to database");

	mysqli_select_db($conn, "305cde") or 
	die ("Could not select database!");
    
    ?>