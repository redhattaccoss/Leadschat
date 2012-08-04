Ext.define("Leadschat.view.owner.Toolbar", {
	extend:"Ext.toolbar.Toolbar",
	alias:"widget.owner_toolbar",
	items:[
			{
				   text:"Mark as Approved",
				   icon:"/js/ext/examples/shared/icons/fam/accept.png",
				   name:"batch-accept-leads"
			},
	       {
	    	   text:"Mark as Deleted",
	    	   icon:"/js/ext/examples/shared/icons/fam/delete.png",
	    	   name:"batch-delete-leads"
	       },
	       
	       "->",
	       {
	    	   xtype:"textfield",
	    	   name:"searchField",
	    	   emptyText:"Search"
	       }
	       
	]

})