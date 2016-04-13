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
    var url = $(location).attr('pathname'); 
    var request = url.split('/');

    $.getJSON("/"+request[1]+"/api/search/", function(data){
        
        var htmlStr = '<table width="80%"><tr><th>Drug Name</th></tr>';
        $.each(data, function(k, v){
         htmlStr +=  '<tr><td><a href="drug/' + v.name + '" rel="external"> ' + v.name + "</a>";
         });
         htmlStr += '</table>';
        $("#drugdata").append(htmlStr);
        });
        
     $("#searching").click(function(){
        var keyword = $("#keyword").val();
        var htmlStr='';
        var flag = false;
        $.getJSON("api/search/"+keyword, function(data){
        if(data!=""){
            htmlStr = "<h2>The searching result of the keyword: " + keyword;
            htmlStr += '<table width="100%"><tr><th>Drug Name</th></tr>';
            $.each(data, function(k, v){
             htmlStr +=  '<tr><td><a href="drug/' + v.name + '" rel="external"> ' + v.name + "</a>" 
              + '</td></tr>';
         });
         htmlStr += '</table>';
        }else{
            htmlStr = "<h2>No Record!</h2>" 
            + "<br>Please try other keyword!"
            + "<br>Please note that this function is only for search the name of drug(s)";
        }
        $("#outerbox").html(htmlStr);
        });
        
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
    <div id="search">
        <input type="text" id="keyword" placeholder="Search drug detail..." >
        <button id="searching">Search</button>
    </div>
      <div id="outerbox">
      <div id="content">
        <h1>Drug Abuse</h1>
         <img src="html/drugabuse1.jpg" width="275" height="183" alt="" longdesc="drugabuse1.jpg">
<ul>
  Many people do not understand why or how other people become addicted to drugs. It is often mistakenly assumed that drug abusers lack moral principles or willpower and that they could stop using drugs simply by choosing to change their behavior. In reality, drug addiction is a complex disease, and quitting takes more than good intentions or a strong will. In fact, because drugs change the brain in ways that foster compulsive drug abuse, quitting is difficult, even for those who are ready to do so. Through scientific advances, we know more about how drugs work in the brain than ever, and we also know that drug addiction can be successfully treated to help people stop abusing drugs and lead productive lives.        
<br></ul>
<ul>Drug abuse is a serious public health problem that affects almost every community and family in some way. Each year drug abuse causes millions of serious illnesses or injuries among Americans. Abused drugs include<br></ul>

 <div id="drugdata">
      </div>
         <ul> (You must login to check the drug details.)
         <br></ul>
	<div data-role="footer">
		<h4>305SDE Assignment</h4>
	</div>
    </body>
 </html>
