Ext.define("Leadschat.view.Navigation", {
	extend:"Ext.tree.Panel",
	alias:"widget.navigation",
	root: {
        text: 'Navigation',
        expanded: true,
        children: [
            {
                text: 'Owners',
                icon:"/js/ext/examples/shared/icons/fam/group.png",
                expanded:true,
                children: [
                   {
                	   text:"Manage Owners",
                	   leaf:true
                   },
                   {
                	   text:"Manage Accounts",
                	   leaf:true
                   }
                ]
            },
            {
            	icon:"/js/ext/examples/shared/icons/fam/table_multiple.png",
                text: 'Leads',
                expanded:true,
                children: [
                   {
                       text: 'To be approved leads',
                       leaf: true
                   },
                   {
                       text: 'Approved leads',
                       leaf: true
                   },
                   {
                       text: 'Expired leads',
                       leaf: true
                   },
                   {
                       text: 'Archived leads',
                       leaf: true
                   },                   
                ]
            },
            {
            	text:"Visitors and Chats",
            	icon:"/js/ext/examples/shared/icons/fam/user_suit.png",
            	expanded:true,
            	children: [
                   {
                       text: 'Manage Visitors',
                       leaf: true
                   },
                   {
                       text: 'Manage Chats',
                       leaf: true
                   }
                ]
            },
            {
            	text: "Administration",
            	icon:"/js/ext/examples/shared/icons/fam/database.png",
            	expanded:true,
            	children:[
            	     {
            	    	 text: 'Call Center',
            	    	 expanded:true,
            	    	 children:[
            	    	           {
            	    	        	  text:"Manage Call Centers",
            	    	        	  leaf:true
            	    	           },
            	    	           {
            	    	        	   text:"Add New Call Center",
            	    	        	   leaf:true   
            	    	           },
            	    	 ]
            	     },
            	     {
            	    	 text: 'Agents',
            	    	 expanded:true,
            	    	 children:[
            	    	           {
            	    	        	  text:"Manage Agents",
            	    	        	  leaf:true
            	    	           },
            	    	           {
            	    	        	   text:"Register an Agent",
            	    	        	   leaf:true   
            	    	           },
            	    	 ]
            	     },
            	     {
            	    	text:"Schedules",
            	    	expanded:true,
           	    	 	children:[
           	    	 	          {
           	    	 	        	text:"Manage Schedules",
           	    	 	        	leaf:true
           	    	 	          }
           	    	 	]
            	     },
            	     {
            	    	 text:"Invoices",
            	    	 children:[
            	    	           {
            	    	        	   text:"Manage Invoices",
            	    	        	   leaf:true
            	    	           }
            	    	 ]
            	     }
            	          
            	]
            },
            {
            	text:"Settings",
            	expanded:true
            },
            {
            	text:"Logout",
            	leaf:true
            }
        ]
    }
});
