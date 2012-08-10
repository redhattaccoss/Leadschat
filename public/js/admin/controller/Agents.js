Ext.define("Leadschat.controller.Agents", {
	extend:"Ext.app.Controller",
	models:[
	       "Agent"
	],
	stores:[
	       "ListAgents"
	],
	views:[
	    "agents.List",
	    "agents.Main",
	    "agents.Toolbar"
	],
})