Ext.define("Leadschat.view.owner.Window", {
	extend:"Ext.window.Window",
	alias:"widget.owner_window",
	height:600,
	width:1000,
	resizable:false,
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