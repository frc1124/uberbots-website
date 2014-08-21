window.secondMenuTitle = new Array();
window.secondMenuUrl = new Array();
for(i=0;i<20;i++){
	window.secondMenuTitle[i]=new Array();
	window.secondMenuUrl[i]=new Array();
}

$(document).ready(function(){
	var timeout;
	prevId = 0;
	$("#loginBox").hide();
	$("#editBox").hide();
	$("#secondMenuDiv").hide();
	
	$("#topMenuContainer").mouseleave(function(){	
		//$("#secondMenuDiv").delay(350).slideUp(200);
		/*timeout = window.setTimeout(function(){
			//alert("out");
			$("#secondMenuDiv").slideUp(200);
			delete timeout;
		}, 2000);*/
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
			}else{
				$("#secondMenuDiv").slideDown(200);
			}
		}
	}
}

function setMobile(){
	setCookie("skin","mobile",1);
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
	for (i=0;i<ARRcookies.length;i++){
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==name){
			return unescape(y);
		}
	}
}

//change font size
$(document).ready(function(){
	$('html').css('font-size', parseFloat($.cookie("fontSize"),10));
	// Reset Font Size
	var originalFontSize = "16em";
    $(".resetFont").click(function(){
		$('html').css('font-size', parseFloat(originalFontSize,10));
		$.cookie("fontSize", "", { expires: 700 });
		return false;
	});
	// Increase Font Size
	$(".increaseFont").click(function(){
	var newFontSize = parseFloat(originalFontSize,10)*1.2;
	$('html').css('font-size', newFontSize);
	$.cookie("fontSize", newFontSize, { expires: 700 });
	return false;
	});
	// Decrease Font Size
	$(".decreaseFont").click(function(){
	var newFontSize = parseFloat(originalFontSize,10)/1.2;
	$('html').css('font-size', newFontSize);
	$.cookie("fontSize", newFontSize, { expires: 700 });
	return false;
	});
});