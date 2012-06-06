Ext.define("Leadschat.view.owner.List", {
	extend:"Ext.grid.Panel",
	title:"Registered Owners",
	alias:"widget.owner_list",
	selType: "checkboxmodel",
	columns:[
		{
			header:"First Name",
			dataIndex:"first_name"
		},
		{
			header:"Last Name",
			dataIndex:"last_name"
		},
		{
			header:"Username",
			dataIndex:"username"
		},
		{
			header:"Email address",
			dataIndex:"email"
		},
		{
			header:"Mobile",
			dataIndex:"mobile"
		},
		{
			header:"Timezone",
			dataIndex:"timezone"
		},
		{
			header:"Number of Hits",
			dataIndex:"number_hits"
		},
		{
			header:"Owner Type",
			dataIndex:"owner_type"
		}
		
		
	],	
	store:"Owners",
	initComponent:function(){
		
		this.dockedItems = [
			{
				xtype:"pagingtoolbar",
				store:"Owners",
				displayInfo:true,
				dock:"bottom"
			}                    
		]
		this.callParent(arguments);
	},
	height:600,
});
