Ext.define("Leadschat.view.callcenters.Toolbar", {
	extend:"Ext.toolbar.Toolbar",
	alias:"widget.callcenters_toolbar",
	items:[
			{
				   text:"Add New Call Center",
				   icon:"/js/ext/examples/shared/icons/fam/add.png",
				   name:"add-new-callcenter"
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