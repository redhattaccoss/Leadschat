Ext.define("Leadschat.view.callcenters.Main", {
	extend:"Ext.panel.Panel",
	alias:"widget.callcenters_main",
	initComponent:function(){
		this.items = [
		    {
		    	xtype:"callcenters_toolbar",
		    	docked:"top"
		    },
		    {
		    	xtype:"callcenters_list",
		    	name:"callcenters_list"
		    }
		    
		]
		this.callParent(arguments);
	}
});
