$(document).ready(function() {

	function reinit() {

		$("#return").click(function() {
			init();
		});
	}

	function init() {
		//this stores the initial content for the page menu
		var temp = "<h1 id='menu-header'>MAIN MENU</h1><ul><li id ='projects'>PROJECTS</li><br><li><a href='./resources/resume.pdf' id='resume'>RÉSUMÉ (PDF)</a></li><br><li id='about'> ABOUT ME</li></ul>"
		//put content on page
		$("#main-menu").html(temp);
		//if about me text is clicked:
		$("#about").click(function() {

			var desc = "My name is Aaron Sedlacek, I'm an Information Technology and Web Science Student at Rensselaer Polytechnic Institute. My main areas of focus are Information Security and Cryptography. I graduated from Chaminade High School in 2010 and I am a member of the International Fraternity of Phi Gamma Delta. My primary areas of expertise are Web Application Exploitation, Penetration Testing, and Social Engineering.";
	
			var foo = "<h1 id='menu-header'>ABOUT ME</h1><div id='desc'>" + desc + "</div>";

			$("#main-menu").html("<div id='about-me'>" + foo + "</div><br/><div id='return'>RETURN TO MAIN MENU</div>");

			reinit();
		});

		$("#projects").click(function() {

			var foo = "<h1 id='menu-header'>PROJECTS</h1><ul><li><a href='./hexxed/index.html'>HEXXED</a></li><br><li><a href='./budgetory/index.php'>BUDGETORY</a></li><br><li><a href='http://www.rpibookswap.com'>RPIBOOKSWAP</a></li><br><li><a href='http://upost.herokuapp.com/'>uPost</a></li></ul>";

			$("#main-menu").html("<div id='projects-list'>" + foo + "</div><div id='return'>RETURN TO MAIN MENU</div>");

			reinit();

		});
	}
	//calls init function
	init();
	//makes main manu draggable
	$(function() {
    	$( "#main-menu" ).draggable();
  	});
	//makes my image draggable
	$(function() {
    	$( "#my_image" ).draggable();
  	});
});