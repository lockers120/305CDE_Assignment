
<!DOCTYPE html> 
<html>
<head>
<meta charset="utf-8">
<title>jQuery Mobile Web App</title>
<link href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" rel="stylesheet" type="text/css"/>
<script src="http://code.jquery.com/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js" type="text/javascript"></script>
<script>

$(document).ready(function() {
	
	$("#submit").click(function(){
        
        var uname = $("#name").val();
        var password = $("#pw").val();
        var cookie = false ;
        /*
		if($("#remember").is(":checked")){
           cookie = true;
        }*/
       
        
        var data = {"uname": uname, "password": password, "remember": cookie};
        
        if(uname!=""&&password!=""){
			alert("Hi");
            $.ajax({
                        url: "api/login/",
                        type:"POST",
                        contentType: "application/json; charset=utf-8",
                        data:  JSON.stringify(data),
                        success: function(msg){ 
					
                         if(msg=="true"){ 
                                $("#content").html("Welcome back, " + uname 
                               + ". The browser will redirect you to previous page. <br>"                          
                               + "<a href='javascript:history.back();'>You can return to the previous page manually if the browser no reaction</a>");
                               setTimeout(function(){location.href="index.html";}, 5000);
                            }else{
                               alert("Please check your user name and password!");
                            } 
                        },
                        error:function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                 }               
             });
        }else{
            alert("Please fill in all the column.");
        }
    });
    
     $("#reset").click(function(){
              $("#name").val("");
              $("#pw").val("");
          });

	
	
	});
	
	</script>
</head> 
<body> 

<div data-role="page" id="page">
	<div data-role="header">
    	 <?php
            include "../util/session.php";
            include "menu.php";
      ?>
		<h1>Login</h1>
	</div>
    <div id='content'>
                <table>
                    <tr><td>ID: </td><td><input type="text" id="name"/></td></tr>
                    <tr><td>Password: </td><td><input type="password" id="pw"/></td></tr> 
                    <tr><td><button id="submit" >Login</button></td></tr>
                </table>
                <br>
                New user? <a href="register.html">Register </a>
                </div>
	<div data-role="footer">
		<h4>305SDE Assignment</h4>
	</div>
</div>


</body>
</html>
