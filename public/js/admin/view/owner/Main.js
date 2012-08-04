Ext.define("Leadschat.view.owner.Main", {
	extend:"Ext.panel.Panel",
	alias:"widget.owner_main",
	initComponent:function(){
		this.items = [
		    {
		    	xtype:"owner_toolbar",
		    	docked:"top"
		    },
		    {
		    	xtype:"owner_list"
		    }
		    
		]
		
		
		this.callParent(arguments);
	}
});
