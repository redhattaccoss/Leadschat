Ext.define("Leadschat.view.owner.Tab", {
	extend:"Ext.tab.Panel",
	layout:"fit",
	alias:"widget.owner_tab",
	height:590,
	width:980,
	autoScroll:false,
	record:null,
	initComponent:function(){
		this.items = [
		       {
		    	   title:"Information",
		    	   items:[
		    	         {
		    	        	 xtype:"owner_basicinformation"
		    	         }
		    	   ]
		       },
		       {
		    	   title:"Login Credentials",
		    	   items:[
		    	          Ext.create("Leadschat.view.owner.LoginCredentials", {
		    	        	  record:this.record
		    	          })
		    	   ]
		       
		       },
		       {
		    	   title:"Accounts"
		       },
		       {
		    	   title:"Lead History"
		       },
		       {
		    	   title:"Transactions"
		       }
		],
		
		this.callParent(arguments);
	}
	
})