Ext.define("Leadschat.view.agents.List", {
	extend:"Ext.grid.Panel",
	title:"List of Agents",
	alias:"widget.agents_list",
	store:"ListAgents",
	columns:[
	 	    {
	 	    	header:"Agent #",
	 	    	dataIndex:"agent_id",
	 	    	width:50
	 	    },
	 	   {
				header:"Agent Name",
				dataIndex:"first_name",
				width:150,
				renderer:function(value, options, row){
					return row.get("first_name")+" "+row.get("last_name");
				}
			},
			{
				header:"Type",
				dataIndex:"type",
				width:75
			},
			{
				header:"Active",
				dataIndex:"active",
				width:75
			},
			
			
	 	    
	],
	initComponent:function(){

	    this.selModel = Ext.create('Ext.selection.CheckboxModel');
		this.dockedItems = [
			{
				xtype:"pagingtoolbar",
				store:"ListAgents",
				displayInfo:true,
				dock:"bottom"
			}                    
		]
		this.callParent(arguments);
	},
	plugins: [
	  	
          Ext.create('Ext.grid.plugin.RowEditing', {
              clicksToEdit: 2
          })
      ],
	height:400,
})