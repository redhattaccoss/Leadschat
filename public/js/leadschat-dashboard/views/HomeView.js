var HomeView = function(){
	
}

HomeView.prototype.toString = function(){
	var output = "";
	output+="<h1>"+
				"<span>Welcome</span> to Leadschat.com"+
			"</h1>";
	
	output+="<div class=\"welcome\">";
		output+="<p><span class=\"welcome-img\"></span><span class=\"welcome-message\">Welcome ";
		output+="to our leadschat environment! You will find all your leads when you click on 'Your Leads' tab in the main navigation. To get back to this page, you can always click on 'Home Screen' navigation item.</span></p>";
	output+="</div>";
	

	output+="<h2 class=\"home first\">System Notifications</h2>";
	output+="<div id='home-notification' class=\"notifications\">There are no notifications that require your attention</div>";
	
	
	output+='<h2 class="home">RECENT ACTIVITIES</h2>';
	output+='<div id="recent-activities" class="notifications"></div>';

	return output;	
}
				


