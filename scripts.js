$(document).ready(function() {

	function init() {
		//this stores the initial content for the page menu
		var temp = "<h1 id='menu-header' class='border'>Main Menu</h1><ul><li class='border'>Projects</li><br><li><a href='./resources/resume.pdf'>click here to view my résumé (PDF)</a></li><br><li><a href='http://www.rpibookswap.com'>rpibookswap.com</a></li><br><li class='border' id='about'> About Me</li></ul>"
		//put content on page
		$("#main-menu").html(temp);
		//if about me text is clicked:
		$("#about").click(function() {
			//holds a description of myself
			var foo = "This is just placeholder text. Maybe someday i'll write something that's actually about me.";
			//switches the text shown on the page with my description
			$("#main-menu").html("<div id='description' class='border'>" + foo + "</div><div id='return' class='border'>Return to Main Menu</div>");
			//about_me function calls this function again once the user decides to return to the original menu
			about_me();
		})
	}

	function about_me() {
		//when the return text is clicked on the page, the html is changed
		$("#return").click(function() {
			init();
		})
	}	
	//calls init function
	init();
	//makes main manu draggable
	$(function() {
    	$( "#main-menu" ).draggable();
  	})
	//makes my image draggable
	$(function() {
    	$( "#my_image" ).draggable();
  	})
});