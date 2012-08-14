Ext.define("Leadschat.controller.CallCenters", {
	extend:"Ext.app.Controller",
	stores:["ListCallCenters"],
	views:["callcenters.Toolbar",
	       "callcenters.List",
	       "callcenters.Main",
	       "callcenters.AddUpdateWindow"],
	models:["CallCenter"],
	
	init: function() {
        this.control({
        	"viewport button[name=add-new-callcenter] ": {
                click:this.addNewCallCenter
            }
            
        });
    },
    
    
    addNewCallCenter:function(button){
    	var window = Ext.create("Leadschat.view.callcenters.AddUpdateWindow", {
    		title:"Add New Call Center"
    	})
    	window.show();
    }
	
});