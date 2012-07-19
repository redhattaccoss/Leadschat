Ext.define("Leadschat.view.owner.List", {
	extend:"Ext.grid.Panel",
	title:"Registered Owners",
	alias:"widget.owner_list",
	selType: "rowmodel",
	columns:[
		{
			header:"Client",
			dataIndex:"first_name",
			width:150,
			renderer:function(value, options, row){
				return row.get("first_name")+" "+row.get("last_name");
			}
		},
		{
			header:"Email address",
			dataIndex:"email",
			width:327,
			sortable:false
		},	
		{
			header:"Timezone",
			dataIndex:"timezone_id",
			renderer:function(value, options, row){
				return row.raw.timezone.name;
			}
		},
		{
			header:"Number of Hits",
			dataIndex:"number_hits"
		},
		{
			header:"Owner Type",
			dataIndex:"owner_type"
		},
		{
			header:"Approved",
			dataIndex:"approved",
			editor: {
                xtype: 'checkboxfield',
            },
            renderer:function(value, options, row){
            	if (row.get("approved")){
            		return "Y";
            	}else{
            		return "N";
            	}
            }
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
	plugins: [
          Ext.create('Ext.grid.plugin.RowEditing', {
              clicksToEdit: 0
          })
      ],
	height:600,
});
