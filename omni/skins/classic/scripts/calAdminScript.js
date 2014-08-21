/* Adminisrative Calendar Javascript */
var editMode = false;
$(document).ready(function(){ //document.ready function
	$('#eventEditBox').hide();
	$('.calPM').attr("checked",true);
	$('#eventForm').submit(addEvent); //on add event form submit, add the event
	$(".eventLink").dblclick(function(){
		//on event link double click, call deleteEvent function to delete event
		deleteEvent($(this),$(this).attr("id"));
		return false;
	}).parent().hover(
		function(){
			$(this).children('div').show();
		},
		function(){
			$(this).children('div').hide();
		}
	);
});

//select date function, on click of date, put info into form
function selectDate(month,day,year){ 
	$("#startMonth").attr("value",month); 
	$("#startDay").attr("value",day); 
	$("#startYear").attr("value",year);
				
	$("#endMonth").attr("value",month);
	$("#endDay").attr("value",day);
	$("#endYear").attr("value",year);
}

//sets date
function setDate(month,day,year,id,title){
	$("#month").attr("value",month); 
	$("#day").attr("value",day); 
	$("#year").attr("value",year);
	$("#icalName").attr("value",title);
	$("#eventID").attr("value",id);
	$("#eventSelect").style.display='';
	$("#selected").style.display='';
	if($("exportType").value == 'single'){
		alert("Selected event "+title+" on "+month+"-"+day+"-"+year+".");
	}
}	

//deletes an event
function deleteEvent(obj,id){ 
	confi = confirm("Are you sure you want to delete this event?"); //confirms event delete
	if(confi){
		$.post("/omni/ajax/delEvent.php",
		{ delEvent: "true", id: id},
		function(data,textStatus){
			if(data=="Success! "){
				if($(obj).parent().parent().find('.eventLink').length==1)
					$(obj).parent().parent().attr('class','day');
				$(obj).parent().remove();
			}else{
				alert(data+'\\n'+textStatus);
			}
		});
	}
}

//adds event 
function addEvent(){ 
	if($("input:radio[name=formType]:checked").val() == "Add"){
		$.post('/omni/ajax/addEvent.php',$('#eventForm').serialize(),
		function(data){
			if(data.slice(0,4)=="<spa"){
				$('#day_'+$('#startMonth').val()+'_'+$('#startDay').val()+'_'+$('#startYear').val()).append(data).attr('class','event');
				$(".eventTip").hide();						
			}else{
				alert('Returned error:'+data);
			}
		});
	}else{
		$.post('/omni/ajax/addEvent.php',$('#eventForm').serialize(),
		function(data){
			if(data.slice(0,3)=="<p>"){
				$("#event_"+$("#eventId").val()).html(data);
				alert("Event Updated");
			}else{
				alert('Returned error:'+data);
			}
		});
	}
	return false;
}

$(".eventLink").dblclick(function(){deleteEvent(this,$(this).attr("id"))});
	
function getData(id){
	//if edit mode, fetch event data
	$("#eventId").val(id);
	if($('input:radio[name=formType]:checked').val() == 'Edit'){
		$.post("/omni/ajax/getEventInfo.php",{getInfo: "true",id: id},function(data){
			var props;
			props = data.split(",");
			var info;
			var instance;
			var field;
			var prop;
			$.each(props,function(key,value){
					instance = value.indexOf(":");
					field = value.slice(0,instance);
					prop = value.slice(instance+2);
					if(field == "#startPM" || field == "#endPM"){
						$(field).attr('checked',prop);
					}else{
						$(field).val(prop);
					}
			});
			$('#typeBox').show();
			$('#locationBox').show();
		});
	}
}