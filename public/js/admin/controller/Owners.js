Ext.define("Leadschat.controller.Owners", {
	extend:"Ext.app.Controller",
	stores:[
	     "Owners", "OwnerTypes", "NumberOfHits", "Timezones"
	],
	models:[
	     "Owner", "Timezone", "TimezoneGroup", "NumberOfHit"
	],
	views:[
	    "owner.List",
	    "owner.Main",
	    "owner.Toolbar",
	    "owner.Window",
	    "owner.Tab",
	    
	]
});
