Ext.define("Leadschat.view.Viewport", {
	extend:"Ext.container.Viewport",
	requires:[
		"Leadschat.view.Main",
		"Leadschat.view.Navigation",
		"Leadschat.view.owner.Main",
		"Leadschat.store.Navigation"
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
					title:"Main Navigation"
				},
				{
					xtype:"main",
					columnWidth:"0.8"
				}
			],
			width:"100%",
		}
		
		this.callParent(arguments);
	}
});
