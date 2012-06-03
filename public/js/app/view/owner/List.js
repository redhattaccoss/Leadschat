Ext.define("Leadschat.view.owner.List", {
	extend:"Ext.grid.Panel",
	title:"Registered Owners",
	xtype:"widget.owner_list"
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
			header:"Email address",
			dataIndex:"email"
		}
		
		
	]
});
