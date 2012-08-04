Ext.define("Leadschat.view.owner.Tab", {
	extend:"Ext.tab.Panel",
	layout:"fit",
	alias:"widget.owner_tab",
	height:400,
	width:600,
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
		    	   title:"Login Credentials"  
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