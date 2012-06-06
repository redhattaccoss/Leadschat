Ext.define("Leadschat.controller.Owners", {
	extend:"Ext.app.Controller",
	stores:[
	     "Owners"
	],
	models:[
	     "Owner", "Timezone", "TimezoneGroup"
	],
	views:[
	    "owner.List",
	    "owner.Main",
	    "owner.Toolbar"
	]
});
