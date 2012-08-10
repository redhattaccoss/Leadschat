Ext.define("Leadschat.controller.Main", {
	extend:"Ext.app.Controller",
	refs:[
	      {
	    	  ref:"navigation",
	    	  selector:"viewport > panel[name=maincontainer] > navigation[name=navigation]"
	      },
	      {
	    	  ref:"ownersGrid",
	    	  selector:"viewport > panel[name=maincontainer] > main > owner_list"
	      }
	],

	
	init: function() {
        this.control({
        	"viewport > panel[name=maincontainer] > navigation[name=navigation]": {
                itemclick: this.navigate
            },
            "viewport owner_list":{
            	edit:this.onRowEditOnGrid
            }
            
        });
    },
    onRowEditOnGrid:function(editor, e){
    	var owner_id = e.record.get("owner_id");
    	var url = "";
    	if (e.record.get("approved")){
    		url = "/owners/process-approve";
    	}else{
    		url = "/owners/process-disapprove";
    	}
		Ext.Ajax.request({
			url:url,
			params:{
				owner_id:owner_id
			},
			success: function(response){
				response = Ext.JSON.decode(response.responseText);
			}
		})
    },
    navigate: function(tree, record) {
        var label = record.get("text");
        var container =tree.up("viewport").down("main").getLayout();
        if (label=="Logout"){
        	location.href="/agents/logout";
        }else if (label=="Manage Accounts"){
        	//container.setActiveItem("test");
        }else if (label=="Manage Owners"){
        	container.setActiveItem("owner_main");
        }else if (label=="Manage Agents"){
        	container.setActiveItem("agents_main");
        }
    }
});