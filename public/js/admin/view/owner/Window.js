Ext.define("Leadschat.view.owner.Window", {
	extend:"Ext.window.Window",
	alias:"widget.owner_window",
	height:450,
	width:800,
	items:[
	       {
	    	   xtype:"owner_tab"
	       }
	],
	buttons:[
	         {
	        	 text:"Save",
	        	 icon:"/js/ext/examples/shared/icons/fam/disk.png",
	        	 name:"save"
	         },
	         {
	        	 text:"Close",
	        	 icon:"/js/ext/examples/shared/icons/fam/cross.png",
	        	 name:"close"
	         }
	]

})