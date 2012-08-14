Ext.define("Leadschat.view.Main", {
	extend:"Ext.panel.Panel",
	alias:"widget.main",
	layout:"card",
	items:[
		{
			xtype:"owner_main",
			id:"owner_main"
		},

		{
			xtype:"agents_main",
			id:"agents_main"
		},
		
		{
			xtype:"callcenters_main",
			id:"callcenters_main"
			
		}
		
	]
})
