Ext.define("Leadschat.view.account.InformationToolbar",{
	extend:"Ext.toolbar.Toolbar",
	alias:"widget.account_infomation_toolbar",
	items:[
			{
				   text:"Add New Account",
				   icon:"/js/ext/examples/shared/icons/fam/add.png",
				   name:"add-new-account"
			},
	       "->",
	       {
	    	   xtype:"textfield",
	    	   name:"searchField",
	    	   emptyText:"Search"
	       }
	       
	],
	bodyPadding:5
})