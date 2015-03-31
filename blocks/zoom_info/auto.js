$(document).ready(function() {

	$('.zoomInfoCont').colorbox({
		inline:true,
		href:function(){
			var number = $(this).attr("id"); // returns item130
			var numDiv = "#"+number+"Info"; // creates #item130Info
			return numDiv;
		}
});