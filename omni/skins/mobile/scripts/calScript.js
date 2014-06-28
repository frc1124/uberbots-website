//Non administrative calendar javascript

	$(document).ready(function(){
		$(".eventTip").hide(); //hide event tip
		$("#exportRange").hide();
		$("#exportSingle").hide();
		$("#eventSelect").hide();
		$(".eventLink").parent().hover( //show event tip popups
			function(){
				$(this).children('div').show();
			},
			function(){
				$(this).children('div').hide();
			});
	});
