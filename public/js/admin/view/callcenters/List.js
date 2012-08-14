Ext.define("Leadschat.view.callcenters.List", {
	extend:"Ext.grid.Panel",
	title:"List of Call Centers",
	alias:"widget.callcenters_list",
	store:Ext.create("Leadschat.store.ListCallCenters"),
	columns:[
	 	    {
	 	    	header:"Call center #",
	 	    	dataIndex:"call_center_id",
	 	    	width:75
	 	    },
	 	   {
				header:"Name",
				dataIndex:"name",
				width:150
			}
			
	 	    
	],
	initComponent:function(){

	    this.selModel = Ext.create('Ext.selection.CheckboxModel');
		this.dockedItems = [
			{
				xtype:"pagingtoolbar",
				store:Ext.create("Leadschat.store.ListCallCenters"),
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