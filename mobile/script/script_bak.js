$(document).ready(function(){
    
    var url = $(location).attr('pathname'); 
    var request = url.split('/');
    var dnames = "";
    
    //Left Panel handling
    $( "#userdetails, #userdetailsMain, #userdetailsFav" ).on( "panelbeforeopen", function( event, ui ) {  
     $.getJSON("/"+request[1]+"/util/session.php?function=getsession", function(data){
        var htmlStr = '<h3>My Info:<h3>';
        if(data!=""){
            htmlStr += '<h4>User Detail</h4>';
             htmlStr += '<table><tr><td>User Name: </td>';            
             htmlStr += "<td>"+data.name+"</td><tr><td>User Type: </td><td>"
                + data.type +"</td></tr>";
            htmlStr += '</table>'; 
            htmlStr += '<a href="#fav" class="ui-btn" onclick="mobile.fav()">My Favourite List</button>';
            htmlStr += '<a href="#" class="ui-btn" onclick="mobile.logout()" >Logout</button>';           
       }else{
           htmlStr += "<h4>You have not logged in! Please log in or sign up to continue!</h4>"
           + "<button class=\"ui-btn\"  onclick=\"javascript:location.href='#login'\">Login</button>"
           + "<button class=\"ui-btn\"  onclick=\"javascript:location.href='#register'\">Register</button>";
       }
        $( "#userdetail, #userdetailMain, #userdetailFav" ).html( htmlStr );
       });
     });
     
     //Right Panel handling
      $( "#search, #searchMain, #searchFav" ).on( "panelbeforeopen", function( event, ui ) { 
          $("#searchResult, #searchResultMain, searchResultFav").html = "";
      }); 
      
      
      //Searching panel handling
      $("#searching, #searchingMain, #searchingFav").click(function(){
          var keyword = $("#keyword, #keywordMain, #keywordFav").val();
          var htmlStr = "";
          $("#searchResult, #searchResultMain, #searchResultFav").html("");
          $.getJSON("../api/search/"+keyword, function(data){
            if(data!=""){
            $.each(data, function(k, v){
             htmlStr += '<li><a href="#main" onclick="mobile.showDrug(\''+ v.name +'\')" >' + v.name + "</a>" 
              + ' ( ' + v.type + ' ) </li>';
            });
            $("#searchResult, #searchResultMain, #searchResultFav").append('<ul data-role="listwiew">' + htmlStr + "</ul>");
            }else{
                htmlStr = "<h2>No Record!</h2>" 
                + "<br>Please try other keyword!"
                + "<br>Please note that this function is only for search the name of drug(s)";
                $("#searchResult, #searchResultMain, #searchResultFav").html(htmlStr);
            }
         });    
        });  
     
     
     //The process of login
     $("#btnlogin").click(function(){
         var username = $("#username").val();
         var password = $("#password").val();
         var data = {"uname": username, "password": password, "remember": false};
         if(username!=""&&password!=""){
            $.ajax({
                        url: "../api/login/",
                        type:"POST",
                        contentType: "application/json; charset=utf-8",
                        data:  JSON.stringify(data),
                        success: function(msg){ 
                         if(msg=="true"){ 
                                $("#loginContent").html("Welcome back, " + username 
                               + ". The browser will redirect you to previous page. <br>");
                               setTimeout(function(){history.back();}, 3000);
                            }else{
                               alert("Please check your user name and password!");
                            } 
                        },
                        error:function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                 }               
             });
        }
     });
         

/*
      Following is for sign up 
     */
    
     //Check whether the name is used
     $("#nameRes").blur(function(){
          var myData = $("#nameRes").val();            
            var URLs="../api/register/" + myData;
            if(myData!=''){
                $.ajax({
                    url: URLs,
                    type:"GET",
                    dataType:'text',
                    success: function(msg){
                        if(msg=="false"){
                             $("#nameCheck").html("This user name has been taken!");
                             $('#nameCheck').css('color', 'red');
                        }else{
                            $("#nameCheck").html("This user name can be used!");      
                            $('#nameCheck').css('color', 'blue'); 
                        }                       
                    }               
                });
            }else{
                    $("#nameCheck").html("Please input the desired user name!");
                    $('#nameCheck').css('color', 'red');   
            }
      });   
      
       //Check if the password is correct input two time
            $("#repwRes").blur(function(){
                var password = $("#pwRes").val();
                var repassword = $("#repwRes").val();
                if(password=="" || repassword ==""){
                    $("#pwCheck").html("Please input the password!");
                    $('#pwCheck').css('color', 'red');  
                }else if(password!=repassword){
                    $("#pwCheck").html("Please input the password correctly!");
                    $("#pwCheck").css("color", "red");             
                }else if(password.length < 6){
                    $("#pwCheck").html("The length of password should be at least 6 !");
                    $("#pwCheck").css("color", "red");  
                }else{
                    $("#pwCheck").html("");
                }
            });    
            
             
            //Check if the mail address vaild. 
            $("#mailRes").blur(function(){
                var mail = $("#mailRes").val();
                var testval = /(\w|\d)+@(\w|\d)+\.\w+/g
                //new RegExp('^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/g');
                if(testval.test(mail)){
                    $("#mailCheck").html("");
                }else{
                    $("#mailCheck").html("Please input the mail address correctly!");
                    $("#mailCheck").css("color", "red");   
                }                
            });
            
       //Enable the sumbit button when all columns have been filled       
          $("#btnRes").click(function(){          
                var name = $("#nameRes").val();
                var pw = $("#pwRes").val();
                var pwre = $("#repwRes").val();
                var mail = $("#mailRes").val();                
                var type = "member"
                var myData = {"uname": name,"pw": pw, "mail": mail, "type": type};
                var URLs = "../api/register/";
                var testval = /(\w|\d)+@(\w|\d)+\.\w+/g;
                if(pw==pwre&&(testval.test(mail))){
                $.ajax({
                    url: URLs,
                    type:"POST",  
                    contentType: "application/json; charset=utf-8",
                    data:  JSON.stringify(myData),
                    success: function(msg){
                      if(msg=="true"){                        
                          $("#registerContent").html(" You have created the account! <br> "
                          + "The browser will redirect you to previous page. <br>" );
                          setTimeout(function(){history.back();}, 3000);
                      }else if(msg=="false"){
                          alert("Duplicate User name!\nPlease check your username!");
                      }
                     }                   
                });
                }else{
                    alert("Somethings wrong! Check the input.");
                }            
          });
          
    
   //End of sign up process 
   
    $("#submit").click(function(){
        var cm = $("#cm").val();
        if(cm!=""){
            var drugname = dnames;
            var myData = {"comment": cm, "dname": drugname};
            $.ajax({
            url: "../api/comment/",
            type:"POST",
            contentType: "application/json; charset=utf-8",
            data:  JSON.stringify(myData),
            success: function(msg){ 
                alert("Comment Success!");
                $("#cm").val("");
                mobile.showDrug(drugname);
            }
        });
        }       
    });
    
     favourite = {
        delete: function(dname){
            var myData = {"dname": dname};
            $.ajax({
            url: "../api/favourite/",
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
    
    mobile = {
        fav: function(){
            var htmlStr='';
             $.getJSON("../api/favourite/", function(data){
             if(data!=""){
                    htmlStr="<div style='margin: 0px auto; display: table; ' <h2>Favourite List</h2><ul>";
                    $.each(data, function(i, row){
                        htmlStr+= "<li>Drug Name: "
                        + "<a href='#main' onclick='mobile.showDrug(\""+ row.dname +"\")'>" + row.dname + "</a></li>"
                        + "<a class='ui-btn ui-btn-inline ui-shadow ui-corner-all' href='javascript:void(0)' onclick='favourite.delete(\""+row.dname+"\") '>delete</a></td></tr>"
                    });
                    htmlStr+="</ul></div>";   
                    $("#favContent").html(htmlStr);            
            }else{
                htmlStr = "You have no item in favourite list!";
                $("#favContent").html(htmlStr);   
            }
          });   
        },
        
        closeDialog: function(){
            $('.ui-dialog').dialog('close').enhanceWithin();
        },
        
        logout: function(){
             $.ajax({
                        url: "../util/session.php?function=logout",
                        type:"GET",
                        success: function(msg){ 
                           alert(msg);
                           location.reload();
                        },
                        error:function(xhr, ajaxOptions, thrownError){
                        alert(xhr.status);
                        alert(thrownError);
                 }               
             });
        },
        
        //Function Same to script/drug.js
        showDrug: function(dname){
         dnames = dname;
         $.getJSON("../api/drug/"+dname, function(data){
         $.each(data, function(i, row){
          $("#content").html("<table><tr><td>Drug Name: </td><td>" + row.name + "</td></tr>"
          + "<tr><td>Drug Type: </td><td>" + row.type + "</td></tr>"
          + "<tr><td>Desciption: </td><td width='70%'>" + row.desc + "</td></tr></table>" 
          + "<a href='javascript:void(0)' onclick='fav.add(\""+row.name+"\")'>Add to my favourite</a>"
          );          
     });
    });
    
    $.getJSON("../api/comment/"+dname, function(data){
       var htmlStr="";
       htmlStr="<table width='100%'>";
         $.each(data, function(i, row){
            htmlStr+= "<tr><td colspan='2'>" + row.comment + "</td></tr>"
            + "<tr><td>Posted by: </td><td>" + row.uname 
            + " in : " + row.time + "</td></tr>";
            if(row.owner){
                htmlStr+="<tr>"
                +"<td><a href='javascript:void(0)' onclick='comment.pop(\""+row.comment+"\", \""+row.id+"\")'>Edit</a></td>" 
                +"<td><a href='javascript:void(0)' onclick='comment.delete(\""+row.id+"\")'>Delete</a></td>"
                +"</tr>";
            }
         }); 
     $("#comment").html(htmlStr+"</table>");
    });
    $( "#search, #searchMain, #searchFav" ).panel( "close" );
    }
    }
    
    fav = {
        add: function(did){
        var myData = {"dname": did};
        $.ajax({
            url: "../api/favourite/",
            type:"POST",
            contentType: "application/json; charset=utf-8",
            data:  JSON.stringify(myData),
            success: function(msg){ 
                if(msg=="true"){
                alert("Added to Favourite List!");
                mobile.showDrug(dnames);
                }else{
                    alert("Cannot add to favourite list. Maybe you have added?");
                }
            }
         });
        }
    }
    
  
   
    comment = {
        pop: function(cm, id){           
            $("#cmedit").html(cm);            
            $.mobile.changePage('#dialog', 'pop', true, true);
            $("#editcm").click(function(){
                var newcm = $("#cmedit").val();
                comment.edit(id, newcm);
            });
            
        },
        
        edit: function(id, cm){
            var myData = {"id": id, "cm": cm};
            $.ajax({
            url: "../api/comment/",
            type:"PUT",
            contentType: "application/json; charset=utf-8",
            data:  JSON.stringify(myData),
            success: function(msg){ 
                alert("Comment Edited!");
                mobile.closeDialog();
                mobile.showDrug(dnames).enhanceWithin();
            }
        });
        },
        
        delete:  function(id){
            var myData = {"id": id};
            $.ajax({
            url: "../api/comment/",
            type:"DELETE",
            contentType: "application/json; charset=utf-8",
            data:  JSON.stringify(myData),
            success: function(msg){ 
                alert("Comment Deleted");
                mobile.showDrug(dnames).enhanceWithin();
            }
        });
       }
    }
    
     favourite = {
        delete: function(dname){
            var myData = {"dname": dname};
            $.ajax({
            url: "../api/favourite/",
            type:"DELETE",
            contentType: "application/json; charset=utf-8",
            data:  JSON.stringify(myData),
            success: function(msg){ 
                if(msg=='true'){
                    alert("Removed for Favourite list!");
                   mobile.fav();
                }else{
                    alert(msg);
                }
            }
        });
         }
     }
      

    
});