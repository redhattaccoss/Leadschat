Ext.define("Leadschat.view.Viewport", {
	extend:"Ext.container.Viewport",
	requires:[
	    "Ext.ux.CheckColumn",
		"Leadschat.view.Main",
		"Leadschat.view.Navigation",
		"Leadschat.view.owner.Main",
		"Leadschat.store.Navigation",
		"Leadschat.view.owner.List",
		"Leadschat.view.owner.Main",
		"Leadschat.view.owner.Toolbar",
		
	],
	layout:"fit",
	initComponent:function(){
		this.items = {
			xtype:"panel",
			dockedItems:[{
				dock:"top",
				xtype:"toolbar",
				items:[
					{
						xtype:"component", 
						html:"<img src='/public/images/leadchat-small.png'/>"
					}
				],
				height:40
			}],
			layout:"column",
			items:[
				{
					xtype:"navigation",
					columnWidth:"0.2",
					title:"Main Navigation",
					height:"100%",
					layout:"fit"
				},
				{
					xtype:"main",
					columnWidth:"0.8",
					layout:"fit"
				}
			],
			width:"100%",
		}
		
		this.callParent(arguments);
	}
});
