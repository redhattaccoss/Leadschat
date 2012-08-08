Ext.define("Leadschat.controller.Owners", {
	extend:"Ext.app.Controller",
	stores:[
	     "Owners", "OwnerTypes"
	],
	models:[
	     "Owner", "Timezone", "TimezoneGroup"
	],
	views:[
	    "owner.List",
	    "owner.Main",
	    "owner.Toolbar",
	    "owner.Window",
	    "owner.Tab",
	    
	]
});
