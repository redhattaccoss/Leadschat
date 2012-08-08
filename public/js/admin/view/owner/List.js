Ext.define("Leadschat.view.owner.List", {
	extend:"Ext.grid.Panel",
	title:"Registered Owners",
	alias:"widget.owner_list",
	selModel: Ext.create('Ext.selection.CheckboxModel'),
	columns:[
	    {
	    	header:"Owner #",
	    	dataIndex:"owner_id",
	    	locked:true,
	    	width:50
	    },
	    {
            align:"center",
			header:"Action",
			xtype:"actioncolumn",
			locked:true,
			items:[
			       {
			    	   icon:"/js/ext/examples/shared/icons/fam/vcard.png",
			    	   name:"click",
			    	   handler: function(grid, rowIndex, colIndex) {
			    		   var record = grid.getStore().getAt(rowIndex);
			    		   Ext.ModelManager.getModel("Leadschat.model.Owner").load(record.get("owner_id"), {
			    			   success:function(user){
			    				   var window = Ext.create("Leadschat.view.owner.Window",{
					    			  title:record.get("first_name")+"'s Information",
					    			  record:record
					    		   });
			    				   window.down("owner_basicinformation").setLabel(record);
			    				   window.down("form").loadRecord(record);
					    		   window.show();	   
			    			   }
			    		   })
			    		   
			    	   }
			       },
			       {
			    	   icon:"/js/ext/examples/shared/icons/fam/vcard_delete.png",
			    	   handler: function(grid, rowIndex, colIndex) {
			    		   
			    	   }
			       },
			       {
			    	   icon:"/js/ext/examples/shared/icons/fam/vcard_edit.png",
			    	   handler: function(grid, rowIndex, colIndex) {
			    		   
			    	   }
			       },
			]
		
		},
		{
			header:"Approved",
			dataIndex:"approved",
			editor: {
                xtype: 'checkboxfield',
            },
            align:"center",
            renderer:function(value, options, row){
            	if (row.get("approved")){
            		return "Y";
            	}else{
            		return "N";
            	}
            }
		},
		{
			header:"Client",
			dataIndex:"first_name",
			locked:true,
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
				var timezone = row.get("timezone");
				return timezone.name;
			}
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
	plugins: [
	       
          Ext.create('Ext.grid.plugin.RowEditing', {
              clicksToEdit: 2
          })
      ],
	height:400,
});
