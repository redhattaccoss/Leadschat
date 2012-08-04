Ext.define("Leadschat.view.Main", {
	extend:"Ext.panel.Panel",
	alias:"widget.main",
	layout:"card",
	items:[
		{
			xtype:"owner_main",
			id:"owner_main"
		},{
			html:"Wazzup!!!",
			id:"test"
		}
		
	]
})
