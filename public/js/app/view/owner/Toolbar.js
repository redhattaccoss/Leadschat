Ext.define("Leadschat.view.owner.Toolbar", {
	extend:"Ext.toolbar.Toolbar",
	alias:"widget.owner_toolbar",
	items:[
	       {
	    	   text:"Edit"
	       },
	       {
	    	   text:"Mark as Deleted"
	       },
	       {
	    	   text:"Mark as Approved"
	       },
	       "->",
	       {
	    	   xtype:"textfield",
	    	   name:"searchField",
	    	   emptyText:"Search"
	       },
	       {
	    	   
	       }
	       
	]

})