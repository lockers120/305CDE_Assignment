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
	
var nameflag; var pwflag; var mailflag;
            nameflag = false; 
            pwflag = false;
            mailflag = false;          
  

            $("#name").blur(function() {                
            var myData = $("#name").val();            
            var URLs="api/register/" + myData;
            if(myData!=''){
                $.ajax({
                    url: URLs,
                    type:"GET",
                    dataType:'text',
                    success: function(msg){
                        if(msg=="false"){
                             $("#result").html("PLEASE USE OTHER ID");
                             $('#result').css('color', 'red');
                             nameflag=false;
                        }else{
                            $("#result").html("ID CAN BE USE");      
                            $('#result').css('color', 'blue'); 
                            nameflag = true;                     
                        }                       
                    }               
                });
            }else{
                    $("#result").html("TYPE YOUR ID HERE");
                    $('#result').css('color', 'red');   
                    nameflag=false;
            }
            });
            

            $("#repw").blur(function(){
                var password = $("#pw").val();
                var repassword = $("#repw").val();
                if(password=="" || repassword ==""){
                    $("#chkpw").html("TYPE YOUR ID HERE");
                    $('#chkpw').css('color', 'red');  
                    pwflag=false; 
                }else if(password!=repassword){
                    $("#chkpw").html("TYPE YOUR PASSWORD HERE");
                    $("#chkpw").css("color", "red");    
                    pwflag=false;               
                }else if(password.length < 6){
                    $("#chkpw").html("PASSWORD LENGTH MUST BE MORE THAN 6 ");
                    $("#chkpw").css("color", "red");  
                    pwflag=false;
                }else{
                    $("#chkpw").html("");
                    pwflag = true;
                }
            });
            

            $("#mail").blur(function(){
                var mail = $("#mail").val();
                var testval = /(\w|\d)+@(\w|\d)+\.\w+/g
              
                if(testval.test(mail)){
                    $("#chkmail").html("");
                    mailflag=true;
                }else{
                    $("#chkmail").html("TYPE YOUR E-MAIL");
                    $("#chkmail").css("color", "red");       
                    mailflag=false;            
                }                
            });
            
          
          $("#submit").click(function(){
             if(nameflag == true && pwflag == true && mailflag == true){
                var name = $("#name").val();
                var pw = $("#pw").val();
                var mail = $("#mail").val();
                var type = $("#type").val()
                var myData = {"uname": name,"pw": pw, "mail": mail, "type": type};
                var URLs = "api/register/";
                $.ajax({
                    url: URLs,
                    type:"POST",
                  
                    contentType: "application/json; charset=utf-8",
                    data:  JSON.stringify(myData),
                    success: function(msg){

                      if(msg=="true"){                        
                          $("#content").html(" You have created the account! <br> "
                          + "The browser will redirect you to previous page. <br>"                          
                          + "<a href='javascript:history.back();'>You can return to the previous page manually if the browser no reaction</a>");
                          setTimeout(function(){history.back();}, 5000);
                      }else if(msg=="false"){
                          alert("Duplicate User name!\nPlease check your username!");
                      }
                     }                   
                });
            }else{
                 alert("Check your input!");
            }
          });
          
          $("#reset").click(function(){
              $("#name").val("");
              $("#pw").val("");
              $("#repw").val("");
              $("#mail").val("");       
              $("#result").html("");
              $("#chkpw").html("");
              $("#chkmail").html("");       
              nameflag = false; 
              pwflag = false;
              mailflag = false;   
          });
	
	});
	
	</script>
</head> 
<body> 

<div data-role="page" id="page">
	<div data-role="header">

		<h1>Register</h1>
	</div>
        <div id='content'>
               <table>
                    <tr><td>User name: </td><td><input type="text" id="name"/></td><td><span id="result"></span></td></tr>
                    <tr><td>Password: </td><td><input type="password" id="pw"/></td></tr>
                    <tr><td>Re-input Password: </td><td><input type="password" id="repw"/></td><td><span id="chkpw"></span></td></tr>
                    <tr><td>E-mail address: </td><td><input type="text" id="mail"/></td><td><span id="chkmail"></span></td></tr>
                    <?php
                    if(isset($_SESSION['usertype'])){
                    echo "<tr><td>Member Type: </td><td>"
                    ."<select id='type'><option value='member'>Member</option>".
                    "<option value='admin'>Administrator</option>"."</td></tr>";
                    }
                    ?>
                    <tr><td><button id="submit" >Register</button></td></tr>
                </table>
                <br>Already have a account? <a href="login.html">Login</a>
                 </div>
	<div data-role="footer">
		<h4>305SDE Assignment</h4>
	</div>
</div>


</body>
</html>
