window.secondMenuTitle = new Array();
window.secondMenuUrl = new Array();
for(i=0;i<20;i++){
	window.secondMenuTitle[i]=new Array();
	window.secondMenuUrl[i]=new Array();
}

$(document).ready(function(){
	prevId = 0;
	$("#loginBox").hide();
	$("#editBox").hide();
	$("#secondMenuDiv").hide();
	
	$("#topMenuContainer").mouseleave(function(){
		$("#secondMenuDiv").slideUp(200);
	});
});
function toggleLoginBox(){
	$("#loginBox").toggle();
	return false;
}
		
		//menu navigation
function showSecondMenu(id){
	//trigger only if there are menu items
	if(secondMenuTitle.length>=id){
	if(secondMenuTitle[id].length!=0){
	if(id!=prevId){
	prevId = id;
	
	output = "";
	
	//menu stuff
	for(i=0;i<secondMenuTitle[id].length;i++){
		output += "<a href=\""+secondMenuUrl[id][i]+"\">"+secondMenuTitle[id][i]+"</a> ";
		}
	$("#secondMenuDiv").slideDown(200);
	$("#secondMenuDiv DIV").fadeOut("fast",function(){
	$("#secondMenuDiv DIV").html(output);
	$("#secondMenuDiv DIV").hide().fadeIn("fast");
	});
	}
	else{
	$("#secondMenuDiv").slideDown(200);
	}}}}
	
function toggleContent(){
	$('#mainColumn').toggle();
	$('#secondaryColumn').toggle();
}

function defaultSkin(){
	setCookie("skin","classic",1);
	window.location.reload();
}

function setCookie(name,value,exdays){
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=name + "=" + c_value;
}

function getCookie(name){
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==name)
    {
    return unescape(y);
    }
  }
}
		
	//change font size
$(document).ready(function(){
  // Reset Font Size
  var originalFontSize = $('html').css('font-size');
    $(".resetFont").click(function(){
    $('html').css('font-size', originalFontSize);
  });
  // Increase Font Size
  $(".increaseFont").click(function(){
    var newFontSize = parseFloat(originalFontSize,10)*1.5;
    $('html').css('font-size', newFontSize);
    return false;
  });
  // Decrease Font Size
  $(".decreaseFont").click(function(){
    var newFontSize = parseFloat(originalFontSize,10)/1.5;
    $('html').css('font-size', newFontSize);
    return false;
  });
});