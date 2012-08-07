Ext.define("Leadschat.view.Viewport", {
	extend:"Ext.container.Viewport",
	requires:[
		"Leadschat.view.Main",
		"Leadschat.view.Navigation",
		"Leadschat.view.owner.Main",
		"Leadschat.view.owner.List",
		"Leadschat.view.owner.Main",
		"Leadschat.view.owner.Toolbar",
		"Leadschat.view.owner.Window",
		"Leadschat.view.owner.Tab",
		"Leadschat.view.owner.BasicInformation",
		"Leadschat.view.owner.LoginCredentials"
	],
	layout:"fit",
	initComponent:function(){
		this.items = {
			xtype:"panel",
			name:"maincontainer",
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
					layout:"fit",
					name:"navigation"
				},
				{
					xtype:"main",
					columnWidth:"0.8",
				}
			],
			width:"100%",
		}
		
		this.callParent(arguments);
	}
});
