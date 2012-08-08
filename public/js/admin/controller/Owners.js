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
	    
	],
	refs:[
	      {
	    	  ref:"ownersGrid",
	    	  selector:"viewport owner_list[name=owner_list]"
	      }
	],
	
	init: function() {
        this.control({
        	"viewport button[name=batch-accept-leads]": {
                click: this.approveLeads
            }
            
        });
    },
    approveLeads:function(){
    	var grid = this.getOwnersGrid();
    	var records = grid.getSelectionModel().getSelection();
    	if (records.length>0){
    		var owner_ids = [];
    		Ext.each(records, function(record){
    			owner_ids.push(record.get("owner_id"));
    		});
    		
    		var answer = Ext.Msg.show({
    		     title:'Save Changes?',
    		     msg: 'Would you like to approve the selected owners?',
    		     buttons: Ext.Msg.YESNOCANCEL,
    		     icon: Ext.Msg.QUESTION,
    		     fn:function(button){
    		    	if (button=="yes"){
    		    		Ext.Ajax.request({
    		    			url:"/owners/multiple-approve",
    		    			params:{
    		    				"owner_ids[]":owner_ids
    		    			},
    		    			success: function(response){
    		    				response = Ext.JSON.decode(response.responseText);
    		    				if (response.success){
    		    					Ext.Msg.alert('Status', 'Changes saved successfully.');
    		    					grid.getStore().load();    		    					
    		    				}
    		    			}
    		    		});
    		    	}
		    		
    		    		
    		     }
    		});
    		
    		
    		
    	}
    }
});
