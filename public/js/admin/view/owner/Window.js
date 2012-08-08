Ext.define("Leadschat.view.owner.Window", {
	extend:"Ext.window.Window",
	alias:"widget.owner_window",
	height:600,
	width:1000,
	resizable:false,
	record:null,
	initComponent:function(){
		this.items = [
		              Ext.create("Leadschat.view.owner.Tab", {
		            	  record:this.record
		              })
		];
		
		this.callParent(arguments);
	},
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