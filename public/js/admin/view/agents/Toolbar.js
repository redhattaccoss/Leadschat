Ext.define("Leadschat.view.agents.Toolbar", {
	extend:"Ext.toolbar.Toolbar",
	alias:"widget.agents_toolbar",
	items:[
			{
				   text:"Add New Agents",
				   icon:"/js/ext/examples/shared/icons/fam/add.png",
				   name:"add-new-account"
			},
	       {
	    	   text:"Mark as Inactive",
	    	   icon:"/js/ext/examples/shared/icons/fam/delete.png",
	    	   name:"batch-inactive"
	       },
	       
	       "->",
	       {
	    	   xtype:"textfield",
	    	   name:"searchField",
	    	   emptyText:"Search"
	       }
	       
	]

})