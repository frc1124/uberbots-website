/* Adminisrative Javascript */
		$(document).ready(function(){ //document.ready function
			$('#addEventForm').submit(addEvent); //on add event form submit, add the event
			$('#addEventForm').hide(); //hide the add event form
			$(".eventLink").dblclick(function(){
			deleteEvent($(this),$(this).attr("id"));
			return false;} //on event link double click, call deleteEvent function to delete event
			).parent().hover(
			function(){
				$(this).children('div').show();
			},
			function(){
				$(this).children('div').hide();
			}
			);
			
			/* jquery form validator, not working yet, still server side validation
			$('#addEventForm').validate({
				rules:{
					eventName: {required:true},
					eventDescriptiopn: {required:true},
					startMonth: {requried: true, digits: true, max: 12, min: 1},
					startDay: {requried: true, digits: true, max: 31, min: 1},
					startYear: {requried: true, digits: true, maxlength: 4, min: 2009},
					endMonth: {requried: true, digits: true, max: 12, min: 1},
					endDay: {requried: true, digits: true, max: 31, min: 1},
					endYear: {requried: true, digits: true, maxlength: 4, min: 2009},
					startMin: {required: true, digits: true, max: 59, min: 0},
					startHour: {required: true, digits: true, max: 12, min: 1}
				},
				messages: {
					eventName: {required: 'Please enter an event name'},
					eventDescription: {required: 'Please enter an event description'},
					startMonth: {requried: 'Please enter a start month', digits: 'Month has to be a number between one and 12', max: 'Month has to be a number between and and 12', min: 'Value must be 1 or greater'},
					startDay: {requried: 'Please enter a start day', digits: 'Day has to be a number between one and ".$daysInMonth."', max: 'Month has to be a number between and and 31', min: 'Value must be 1 or greater'},
					startYear: {requried: 'Please enter a start year', digits: 'Year has to be a four number long digit' , maxlength: 'Year must be 4 digits long or less', min: 'Value must be 1 or greater'},
					endMonth: {requried: 'Please enter a start month', digits: 'Month has to be a number between one and 12', max: 'Month has to be a number between and and 12', min: 'Value must be 1 or greater'},
					endDay: {requried: 'Please enter a start day', digits: 'Day has to be a number between one and ".$daysInMonth."', max: 'Month has to be a number between and and 31', min: 'Value must be 1 or greater'},
					endYear: {requried: 'Please enter a start year', digits: 'Year has to be a four number long digit' , maxlength: 'Year must be 4 digits long or less', min: 'Value must be 1 or greater'},
					startMin: {required: 'Please enter a start minute', digits: 'Minute has to be a number', max: 'Minute value can not be greater than 59', min: 'Minute value can not be less than 1'},
					startHour: {required: 'Please enter a start  hour', digits: 'Value must be a number', max: 'Value can not be greater than 12', min: 'Value can not be less than 1'}
				},
				errorPlacement: function(error, element) { 
					if ( element.is('.addMonth') ) 
						error.appendTo( element.parent().next().next().next() ); 
					else if ( element.is('.addDay') ) 
						error.appendTo ( element.next().next() ); 
					else 
						error.appendTo( element.parent() ); 
				}
			}); */
						
		});
	
	function selectDate(month,day,year){ //select date function, on click of date, put info into form
		$("#startMonth").attr("value",month); 
		$("#startDay").attr("value",day); 
		$("#startYear").attr("value",year);
					
		$("#endMonth").attr("value",month);
		$("#endDay").attr("value",day);
		$("#endYear").attr("value",year);
		
		$("#sMonth").attr("value",month); 
		$("#sDay").attr("value",day); 
		$("#sYear").attr("value",year);
					
		$("#eMonth").attr("value",month);
		$("#eDay").attr("value",day);
		$("#eYear").attr("value",year);
	}
	
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
	
	function deleteEvent(obj,id){ //deletes an event
		confi = confirm("Are you sure you want to delete this event?"); //confirms event delete
		if(confi){
			$.post("/omni/ajax/delEvent.php",
			{ delEvent: "true", id: id},
			function(data,textStatus){
				if(data=="Success! "){
					if($(obj).parent().parent().find('.eventLink').length==1)
						$(obj).parent().parent().attr('class','day');
					$(obj).parent().remove();
				}
				else
					alert(data+'\\n'+textStatus);
			});
				
		}}
	function addEvent(){ //adds event 
		$.post('/omni/ajax/addEvent.php',$('#addEventForm').serialize(),
			function(data){
					if(data.slice(0,4)=="<spa"){
						$('#day_'+$('#startMonth').val()+'_'+$('#startDay').val()+'_'+$('#startYear').val()).append(data).attr('class','event');
					}else{
						alert('Returned error:'+data);
					}
				});
			return false;
			}

			$(".eventLink").dblclick(function(){deleteEvent(this,$(this).attr("id"))});
