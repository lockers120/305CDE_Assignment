
<!DOCTYPE html> 

<html>
<head>
<meta charset="utf-8">
<title>jQuery Mobile Web App</title>
<link href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" rel="stylesheet" type="text/css"/>
<script src="http://code.jquery.com/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
    
    $.getJSON("api/favourite/", function(data){
        if(data!=""){
             $("#content").html("<h2>Favourite List</h2><table width='100%'>");
            $.each(data, function(i, row){
                $("#content").append("<tr><td width='70%'>Drug Name: </td><td>" + row.dname + "</td></tr>"
                + "<tr><td></td><td><a href='javascript:void(0)' onclick='favourite.delete(\""+row.dname+"\") '>delete</a></td></tr>"
                ); 
            $("#content").append("</table>"); 
            }) ;
            
        }else{
         $("#content").html("You have no item in favourite list!");
       }
    });
    
    favourite = {
        delete: function(dname){
            var myData = {"dname": dname};
            $.ajax({
            url: "api/favourite/",
            type:"DELETE",
            contentType: "application/json; charset=utf-8",
            data:  JSON.stringify(myData),
            success: function(msg){ 
                if(msg=='true'){
                    alert("Removed for Favourite list!");
                    location.reload();
                }else{
                    alert(msg);
                }
            }
        });
         }
    }
    
    
    
});
</script>
</head> 
<body> 

<div data-role="page" id="page">

	<div data-role="header">
		<?php
include "menu.php";
?>
        <h1>Favourite</h1>
	</div>
	<div data-role="content">	
		<ul data-role="listview">
        <div id="content"></div>
		</ul>		
	</div>
	<div data-role="footer">
		<h4>305SDE Assignment</h4>
	</div>
</div>


</body>
</html>
