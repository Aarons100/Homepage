$(document).ready(function() {

	//this function reloads the initial main menu when the user clicks "RETURN TO MAIN MENU"
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
			//holds my description of myself
			var desc = "My name is Aaron Sedlacek, I'm an undergraduate student at Rensselaer Polytechnic Institute (<a href='http://rpi.edu/'>RPI</a>). ";
				desc += "I'm currently working on both a B.S. and an M.S. in Information Technology and Web Science. ";
				desc += "On top of that, I'm very involved with RPISEC, RPI's cyber security club. I'm currently the Secretary of the club, and I'm on the RPISEC ctf team. ";
				desc += "I spend my free time advancing my skills by tearing through old CTF challenges and reversing software. ";
				desc += "My Master's research is on rootkit design, development, and implementations on modern systems. This includes kernel and firmware level rootkits. ";
				desc += "I'm also researching malware design principles that prevent the creation of useful signatures in order to subvert Antivirus. ";
				desc += "Also also, I'm teaching Malware Analysis at RPI in Fall 2015, and helping to teach Cryptography and Network Security as well. "
				desc += "When I'm not doing any of that, I spend time socializing with friends in my fraternity, Phi Gamma Delta, and in the cybersecurity community. ";
				desc += "<h4>Feel free to contact me! I sit in the RPISEC IRC using my handle, Aidielse.</h4>";
			//for output
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
	//calls init function on initial page load
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