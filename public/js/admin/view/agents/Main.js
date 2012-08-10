Ext.define("Leadschat.view.agents.Main", {
	extend:"Ext.panel.Panel",
	alias:"widget.agents_main",
	initComponent:function(){
		this.items = [
		    {
		    	xtype:"agents_toolbar",
		    	docked:"top"
		    },
		    {
		    	xtype:"agents_list",
		    	name:"agents_list"
		    }
		    
		]
		this.callParent(arguments);
	}
});
