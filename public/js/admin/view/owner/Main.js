Ext.define("Leadschat.view.owner.Main", {
	extend:"Ext.panel.Panel",
	alias:"widget.owner_main",
	layout:"fit",
	initComponent:function(){
		this.items = [
		    {
		    	xtype:"owner_toolbar",
		    	docked:"top"
		    },
		    {
		    	xtype:"owner_list",
		    	layout:"fit"
		    }
		    
		]
		
		
		this.callParent(arguments);
	}
});
