$(document).ready(function() {

	//this function reloads the initial main menu when the user clicks "RETURN TO MAIN MENU"
	function reinit() {
		$("#return").click(function() {
			init();
		});
	}

	function init() {
		//this stores the initial content for the page menu
		var temp = "<h1 id='menu-header'>MAIN MENU</h1>";
		temp += "<ul>"
		temp += "<li id ='work'>WRITEUPS, RESEARCH, AND CLASSES</li>";
		temp += "<br><li><a href='./resources/resume.pdf' id='resume'>RÉSUMÉ (PDF)</a></li>";
		temp += "<br><li id = 'blog'>BLOG</li>";
		temp += "<br><li id='about'>ABOUT ME</li></ul>";
		//put content on page
		$("#main-menu").html(temp);
		//if about me text is clicke
		$("#about").click(function() {
			//holds my description of myself
			var desc = "<p>My name is Aaron Sedlacek, I'm an undergraduate student at Rensselaer Polytechnic Institute (<a href='http://rpi.edu/'>RPI</a>). ";
				desc += "I'm currently working on both a B.S. and an M.S. in Information Technology and Web Science. ";
				desc += "On top of that, I'm very involved with RPISEC, RPI's cyber security club. I'm currently the Secretary of the club, and I'm on the RPISEC ctf team. ";
				desc += "I spend my free time advancing my skills by tearing through old CTF challenges and reversing software.</p><br>";

				desc += "<p>My Master's research is on modern rootkit analysis and detection. User-land, kernel-land, firmware, and hardware level rootkits as well as bootkits are included in the scope. ";
				desc += "I'm also teaching Malware Analysis (CSCI-4976/6976, CRN: 88777/87944) at RPI in Fall 2015, and TA'ing Cryptography and Network Security as well. "
				desc += "When I'm not doing any of that, I spend time socializing with friends in my fraternity, Phi Gamma Delta, and in the cybersecurity community. </p><br>";
				desc += "<h4>Feel free to contact me! I sit in the RPISEC IRC using my handle, Aidielse.</h4>";
			//for output
			var foo = "<h1 id='menu-header'>ABOUT ME</h1><div class='dense_text'>" + desc + "</div>";

			$("#main-menu").html("<div id='about-me'>" + foo + "</div><div id='return'>RETURN TO MAIN MENU</div>");

			reinit();
		});

		$("#work").click(function() {

			var foo = "<h1 id='menu-header'>WORK</h1>";
			foo += "<ul class='dense_text'>";

			foo += "<li><h3>Malware Analysis, Fall 2015 (CSCI - 4976/6976)</h3>";
			foo += "<ul><li><p>The course is a graduate level / senior level class that teaches the fundamentals of software reverse engineering, Windows intenals, and malware behavior in order to provide students with the tools and the experience to step directly into the field of malware analysis.";
			foo += "This class is based on the Practical Malware Analysis and Practical Reverse Engineering books, which are both very excellent for entry level, intermediate, and advanced reverse engineers.</p></li>";
			foo += "<br><h4 style='display:inline;'> I will add a link to the class syllabus and website once they are finalized.</h4></li></ul>"
			
			foo += "<li><h3>CTF and Wargame Writeups</h3>"
			foo += "<ul>"
				foo += "<li>Coming Soon!</li>"
			foo += "</ul></li>"

			foo += "<li><h3>Research</h3>"
			foo += "<ul>"
				foo += "<li>Coming Soon!</li>"
			foo += "</ul></li>"

			foo += "<li><h3>Recommended Books for Fun and Profit</h3>";
			foo += "<ul>";
				foo += "<li><a href='https://www.google.com/#q=practical+malware+analysis'><h4 style='display:inline;'>Practical Malware Analysis</h4></a> by Michael Sikorski and Andrew Honig.</li>";
				foo += "<li><a href='https://www.google.com/#q=practical+reverse+engineering'><h4 style='display:inline;'>Practical Reverse Engineering</h4></a> by Bruce Dang, Alexandre Gazet, Elias Bachaalany, and Sebastien Josse.</li>";
				foo += "<li><a href='https://www.google.com/#q=the+shellcoder%27s+handbook'><h4 style='display:inline;'>The Shellcoder's Handbook</h4></a> by Chris Anley, John Heasman , Felix Lindner , Gerardo Richarte.</li>";
				foo += "<li><a href='https://www.google.com/#q=the+web+application+hacker%27s+handbook'><h4 style='display:inline;'>The Web Application Hacker's Handbook</h4></a> by Dafydd Stuttard and Markus Pinto</li>";
				foo += "<li><a href='https://www.google.com/#q=hacking:+the+art+of+exploitation'><h4 style='display:inline;'>Hacking: The Art of Exploitation</h4></a> by Jon Erickson.</li>";
				foo += "<li><a href='https://www.google.com/#q=Cryptography+and+Network+Security'><h4 style='display:inline;'>Cryptography and Network Security - Principles and Practices</h4></a> by William Stallings.</li>";
				foo += "<li><a href='https://www.google.com/#q=A+Bug+hunter%27s+diary'><h4 style='display:inline;'>A Bug Hunter's Diary</h4></a> by Tobias Klein.</li>";
			foo += "</ul></li>";

			foo += "</ul>";

			$("#main-menu").html("<div id='projects-list'>" + foo + "</div><div id='return'>RETURN TO MAIN MENU</div>");

			reinit();
		});
	}
	//calls init function on initial page loads
	init();
	//makes main menu draggable
	$(function() {
    	$( "#main-menu" ).draggable();
  	});
	//makes my image draggable
	$(function() {
    	$( "#my_image" ).draggable();
  	});
  		//makes my image draggable
	$(function() {
    	$( "#the_footer a" ).draggable();
  	});
});