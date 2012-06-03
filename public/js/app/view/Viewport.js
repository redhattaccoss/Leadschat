Ext.define("Leadschat.view.Viewport", {
	extend:"Ext.container.Viewport",
	requires:[
		"Leadschat.view.Main",
		"Leadschat.view.Navigation",
		"Leadschat.view.Header",
		"Leadschat.view.owner.Main"
	],
	layout:"fit",
	initComponent:function(){
		this.items = {
			xtype:"panel",
			dockedItems:[{
				dock:"top",
				xtype:"toolbar",
				items:[
					{xtype:"component", html:"<img src='/images/leadchat-small.png'/>"}
				]
			}],
			layout:"column",
			items:[
				{
					xtype:"navigation",
					width:"0.3",					
				},
				{
					xtype:"main",
					width:"0.7"
				}
			]
			
		}
		
	}
});
