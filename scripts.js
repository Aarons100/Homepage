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
			temp += "<li id='about'>ABOUT ME</li>";
			temp += "<br><li id='blogs'>RECOMMENDED BOOKS AND WARGAMES FOR FUN AND PROFIT</li>"
			temp += "<br><li><a href='./resources/resume.pdf' id='resume'>RÈSUMÈ (PDF)</a></li>";
			temp += "<br><li id ='work'>TEACHING, WRITEUPS, AND RESEARCH</li>";
		temp += "</ul>";
		//put content on page
		$("#main-menu").html(temp);
		//if about me text is clicke
		$("#about").click(function() {
			//holds my description of myself
			var desc = "<p>My name is Aaron Sedlacek, I'm an undergraduate student at Rensselaer Polytechnic Institute (<a href='http://rpi.edu/' style='color:blue'>RPI</a>). ";
				desc += "I'm currently working on both a B.S. and an M.S. in Information Technology and Web Science. ";
				desc += "On top of that, I'm very involved with <a href='http://rpis.ec/' style='color:blue'>RPISEC</a>, RPI's cyber security club. I'm currently the Secretary of the club, and I'm on the RPISEC CTF team. ";
				desc += "I spend my free time advancing my skills by tearing through old CTF challenges and reversing software.</p><br>";

				desc += "<p>My Master's research is on modern rootkit analysis and detection. User-land, kernel-land, firmware, and hardware level rootkits as well as bootkits are included in scope. ";
				desc += "I also taught <a href='https://github.com/RPISEC/Malware' style='color:blue'>Malware Analysis</a> (CSCI-4976/6976, CRN: 88777/87944) at RPI in Fall 2015. I also TA'ed Cryptography and Network Security as well. "
				desc += "When I'm not doing any of that, I spend time socializing with friends in my fraternity, Phi Gamma Delta, and in the cybersecurity community. </p><br>";
				desc += "<h4>Feel free to contact me! I sit in the <a href='http://rpis.ec/irc' style='color:blue'>RPISEC IRC</a> using my handle, Aidielse.</h4>";
			//for output
			var foo = "<h1 id='menu-header'>ABOUT ME</h1><div class='dense_text'>" + desc + "</div>";

			$("#main-menu").html("<div id='about-me'>" + foo + "</div><div id='return'>RETURN TO MAIN MENU</div>");

			reinit();
		});

		$("#work").click(function() {

			var foo = "<h1 id='menu-header'>TEACHING, WRITEUPS. and RESEARCH</h1>";
			foo += "<ul class='dense_text'>";

			foo += "<li><a href='https://github.com/RPISEC/Malware' style='color:blue'><h3>Malware Analysis</a>, Fall 2015 (CSCI - 4976/6976)</h3>";
			foo += "<ul><li><p>The course is a graduate/senior level class that teaches the fundamentals of software reverse engineering, Windows internals, and malware behavior in order to provide students with the tools and experience to step directly into the field of malware analysis.";
			foo += " This class is based on the Practical Malware Analysis and Practical Reverse Engineering books, which are both very excellent for entry level, intermediate, and advanced reverse engineers.</p></li></ul>";			
			foo += "<li><h3>CTF and Wargame Writeups</h3>"
			foo += "<ul>"
				foo += "<li>Coming Soon!</li>"
			foo += "</ul></li>"

			foo += "<li><h3>Research</h3>"
			foo += "<ul>"
				foo += "<li><h4 style='display:inline'>DynoSolver</h4> - Auto Reverse Engineering Tool for Simpler Crackmes</li>"
			foo += "</ul></li>"
			foo += "</ul></li>"

			$("#main-menu").html("<div id='projects-list'>" + foo + "</div><div id='return'>RETURN TO MAIN MENU</div>");
			reinit();
		});

		$("#blogs").click(function() {

			var foo = "<h1 id='menu-header'>RECOMMENDED BOOKS AND WARGAMES FOR FUN AND PROFIT</h1>";
			foo += "<ul class='dense_text'>"
				foo += "<li><h3>Recommended Books</h3>";
					foo += "<ul>";
						foo += "<li><a style='color:blue' href='http://www.amazon.com/Guide-Kernel-Exploitation-Attacking-Core/dp/1597494860'><h4 style='display:inline'>A Guide To Kernel Exploitation, Attacking the Core</h4></a> By Enrico Perla and Massimiliano Oldani.</li>"
						foo += "<li><a style='color:blue' href='https://www.google.com/#q=A+Bug+hunter%27s+diary'><h4 style='display:inline;'>A Bug Hunter's Diary</h4></a> By Tobias Klein.</li>";
						foo += "<li><a style='color:blue' href='https://www.google.com/#q=Cryptography+and+Network+Security'><h4 style='display:inline;'>Cryptography and Network Security - Principles and Practices</h4></a> By William Stallings.</li>";
						foo += "<li><a style='color:blue' href='https://www.google.com/#q=hacking:+the+art+of+exploitation'><h4 style='display:inline;'>Hacking: The Art of Exploitation</h4></a> By Jon Erickson.</li>";
						foo += "<li><a style='color:blue' href='https://www.google.com/#q=practical+malware+analysis'><h4 style='display:inline;'>Practical Malware Analysis</h4></a> By Michael Sikorski and Andrew Honig.</li>";
						foo += "<li><a style='color:blue' href='https://www.google.com/#q=practical+reverse+engineering'><h4 style='display:inline;'>Practical Reverse Engineering</h4></a> By Bruce Dang, Alexandre Gazet, Elias Bachaalany, and Sebastien Josse.</li>";
						foo += "<li><a style='color:blue' href='https://www.nostarch.com/rootkits'><h4 style='display:inline;'>Rootkits and Bootkits</h4></a> By Alex Matrosov, Eugene Rodionov, and Sergey Bratus.</li>";
						foo += "<li><a style='color:blue' href='https://www.google.com/#q=the+shellcoder%27s+handbook'><h4 style='display:inline;'>The Shellcoder's Handbook</h4></a> By Chris Anley, John Heasman , Felix Lindner , Gerardo Richarte.</li>";
						foo += "<li><a style='color:blue' href='http://www.amazon.com/Antivirus-Hackers-Handbook-Joxean-Koret/dp/1119028752'><h4 style='display:inline;'>The Antivirus Hackers' Handbook</h4></a> By Joxean Coret and Elias Bachaalany.</li>";
						foo += "<li><a style='color:blue' href='https://www.google.com/#q=the+web+application+hacker%27s+handbook'><h4 style='display:inline;'>The Web Application Hacker's Handbook</h4></a> By Dafydd Stuttard and Markus Pinto.</li>";
					foo += "</ul>";
				foo+= "</li>";
				foo += "<li><h3>Learn Exploitation and Reverse Engineering</h3>";
					foo += "<ol>"
						foo += "<li><a href='http://overthewire.org/wargames/bandit/' style='color:blue'><h4 style='display:inline'>Bandit</h4></a> By overthewire.org</li>"
						foo += "<li><a href='https://github.com/RPISEC/MBE' style='color:blue'><h4 style='display:inline'>Modern Binary Exploitation</h4></a> By RPISEC</li>"
						foo += "<li><a href='https://github.com/RPISEC/Malware' style='color:blue'><h4 style='display:inline'>Malware Analysis</h4></a> By RPISEC</li>"
					foo += "</ol>"
				foo += "</li>"
				foo += "<li><h3>Wargames For Practicing Your Skills</h3>";	
					foo += "<ul>"
						foo += "<li><a href='https://github.com/hacksysteam/HackSysExtremeVulnerableDriver' style='color:blue'><h4 style='display:inline'>Extreme Vulnerable Windows Driver</h4></a></li>"
						foo += "<li><a href='http://pwnable.kr/' style='color:blue'><h4 style='display:inline'>pwnable.kr</h4></a></li>"
						foo += "<li><a href='http://overthewire.org/' style='color:blue'><h4 style='display:inline'>Over The Wire</h4></a></li>"
						foo += "<li><a href='http://smashthestack.org/' style='color:blue'><h4 style='display:inline'>Smash The Stack</h4></a></li>"
						foo += "<li><a href='https://microcorruption.com/login'style='color:blue'><h4 style='display:inline'>Microcorruption</h4></a></li>"
					foo += "</ul>"
				foo += "</li>";
			foo += "</ul>"
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
});
