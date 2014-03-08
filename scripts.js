$(document).ready(function() {

	function about_me() {
		//when the return text is clicked on the page, the html is changed
		$("#return").click(function() {
			init();
		})
	}

	function projects() {

		$("#return").click(function() {
			init();
		})
	}

	function init() {
		//this stores the initial content for the page menu
		var temp = "<h1 id='menu-header' class='border'>Main Menu</h1><ul><li class='border' id ='projects'>Projects</li><br><li><a href='./resources/resume.pdf' id='resume'>click here to view my résumé (PDF)</a></li><br><li class='border' id='about'> About Me</li></ul>"
		//put content on page
		$("#main-menu").html(temp);
		//if about me text is clicked:
		$("#about").click(function() {
			//holds a description of myself
			var foo = "My name is Aaron Sedlacek, I'm an Information Technology and Web Science Student at Rensselaer Polytechnic Institute. My main areas of focus are Information Security and Cryptography. I graduated from Chaminade High School in 2010 and I am a member of the International Fraternity of Phi Gamma Delta. My primary areas of expertise are Web Application Exploitation, Penetration Testing, and Social Engineering.";
			//switches the text shown on the page with my description
			$("#main-menu").html("<div id='description' class='border'><h1 id='menu-header' class='border'>About Me</h1>" + foo + "</div><div id='return' class='border'>Return to Main Menu</div>");
			//about_me function calls this function again once the user decides to return to the original menu
			about_me();
		})

		$("#projects").click(function() {

			var foo = "<h1 id='menu-header' class='border'>Projects</h1><ul><li><a href='./hexxed/index.html'>Hexxed</a></li><br><li><a href='./budgetory/index.php'>Budgetory</a></li><br><li><a href='http://www.rpibookswap.com'>rpibookswap.com</a></li></ul>";

			$("#main-menu").html("<div id='projects-list'>" + foo + "</div><div id='return' class='border'>Return to Main Menu</div>");

			projects();

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